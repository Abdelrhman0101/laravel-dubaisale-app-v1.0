<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CarSalesAd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
use App\Models\CarMake;

class CarSalesAdController extends Controller
{
    // عرض جميع الإعلانات
    /**
     * Display a listing of the resource with smart filtering.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        // 1. نبدأ بالاستعلام الأساسي الذي يعرض الإعلانات المعتمدة فقط
        $query = CarSalesAd::query()
            ->where('add_status', 'Valid')
            ->where('admin_approved', true);

        // 2. تطبيق الفلاتر بشكل ديناميكي بناءً على الطلب الوارد
        // الدالة `when` تقوم بتطبيق الفلتر فقط إذا كانت القيمة موجودة في الطلب

        // Filter by 'make' if provided in the URL query string
        $query->when($request->query('make'), function ($q, $make) {
            return $q->filterByMake($make);
        });

        // Filter by 'model' if provided in the URL query string
        $query->when($request->query('model'), function ($q, $model) {
            return $q->filterByModel($model);
        });

        // Filter by 'trim' if provided in the URL query string
        $query->when($request->query('trim'), function ($q, $trim) {
            return $q->filterByTrim($trim);
        });

        // Filter by 'year' if provided in the URL query string
        $query->when($request->query('year'), function ($q, $year) {
            return $q->filterByYear($year);
        });

        // 3. الترتيب من الأحدث للأقدم وتقسيم النتائج على صفحات
        $ads = $query->latest()->paginate(15)->withQueryString();

        return response()->json($ads);
    }


    // إنشاء إعلان جديد
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            // ... (نفس قواعد التحقق السابقة)
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'make' => 'required|string',
            'model' => 'required|string',
            'year' => 'required|digits:4',
            'km' => 'required|integer',
            'price' => 'required|numeric',
            'trans_type' => 'required|string',
            'phone_number' => 'required|string',
            'emirate' => 'required|string',
            'main_image' => 'required|image|max:5120',
            'thumbnail_images.*' => 'image|max:5120',
            // --- Plan fields: optional and open for client control ---
            'plan_type' => 'nullable|string|max:50',
            'plan_days' => 'nullable|integer|min:0',
            'plan_expires_at' => 'nullable|date',
        ]);

        $data = $request->all();

        // (هذا الجزء الخاص بالصلاحيات مؤقت وغير مثالي، الأفضل معالجته على مستوى الخادم)
        $fixPermissions = function ($path) { /* ... */};

        // رفع الصورة الأساسية
        $mainImagePath = $request->file('main_image')->store('cars/main', 'public');
        $data['main_image'] = $mainImagePath;

        // رفع الصور المصغرة
        if ($request->hasFile('thumbnail_images')) {
            $thumbnailPaths = [];
            foreach ($request->file('thumbnail_images') as $file) {
                $thumbnailPaths[] = $file->store('cars/thumbnails', 'public');
            }
            $data['thumbnail_images'] = $thumbnailPaths;
        }

        // --- Plan fields: allow client to set or override values ---
        if ($request->filled('plan_type')) {
            $data['plan_type'] = $request->input('plan_type');
        }
        if ($request->has('plan_days')) { // allow 0
            $data['plan_days'] = (int) $request->input('plan_days');
            if (!$request->filled('plan_expires_at')) {
                $data['plan_expires_at'] = now()->addDays($data['plan_days']);
            }
        }
        if ($request->filled('plan_expires_at')) {
            $data['plan_expires_at'] = $request->input('plan_expires_at');
        }

        // ربط الإعلان بالمستخدم
        $data['user_id'] = $request->user()->id;

        // =========================================================
        // ====   هنا يبدأ المنطق الذكي للموافقة التلقائية    ====
        // =========================================================

        // 1. جلب إعداد الموافقة من قاعدة البيانات
        // نحن نستخدم الـ Cache لجعل هذه العملية سريعة جدًا
        $manualApproval = cache()->rememberForever('setting_manual_approval_mode', function () {
            // القيمة الافتراضية هي true (أكثر أمانًا) إذا لم يتم العثور على الإعداد
            return \App\Models\SystemSetting::where('key', 'manual_approval_mode')->first()->value ?? 'true';
        });

        // 2. تحويل القيمة النصية إلى boolean
        $isManualApprovalActive = filter_var($manualApproval, FILTER_VALIDATE_BOOLEAN);

        // 3. تحديد حالة الإعلان بناءً على الإعداد
        if ($isManualApprovalActive) {
            // إذا كانت الموافقة اليدوية مفعلة، الإعلان ينتظر المراجعة
            $data['add_status'] = 'Pending';
            $data['admin_approved'] = false;
        } else {
            // إذا كانت الموافقة اليدوية معطلة، الإعلان يتم نشره تلقائيًا
            $data['add_status'] = 'Valid';
            $data['admin_approved'] = true;
        }

        // =========================================================

        $ad = CarSalesAd::create($data);

        return response()->json($ad, 201);
    }

    // عرض إعلان واحد محدد
    public function show(CarSalesAd $carSalesAd)
    {
        // Increment views count
        $carSalesAd->incrementViews();

        return response()->json($carSalesAd);
    }

    // تحديث إعلان
    /**
     * تحديث بيانات إعلان موجود.
     */
    public function update(Request $request, CarSalesAd $carSalesAd)
    {
        // 1. التحقق من أن المستخدم هو صاحب الإعلان
        if ($request->user()->id !== $carSalesAd->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // 2. التحقق من صحة البيانات المدخلة
        // 'sometimes' تعني أن الحقل ليس إجباريًا، ولكن إذا وُجد، يجب أن يتبع القواعد
        $validatedData = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'make' => 'sometimes|required|string',
            'model' => 'sometimes|required|string',
            'year' => 'sometimes|required|digits:4',
            'km' => 'sometimes|required|integer',
            'price' => 'sometimes|required|numeric',
            // --- قواعد التحقق الخاصة بالصور ---
            'main_image' => 'sometimes|image|max:5120', // صورة واحدة، ليست مصفوفة
            'thumbnail_images.*' => 'sometimes|image|max:5120',
            // --- Plan fields: optional and open for client control ---
            'plan_type' => 'sometimes|nullable|string|max:50',
            'plan_days' => 'sometimes|nullable|integer|min:0',
            'plan_expires_at' => 'sometimes|nullable|date',
        ]);

        // 3. تحديث الحقول النصية
        // نقوم باستثناء حقول الصور من التحديث التلقائي وبناء مصفوفة قابلة للتعديل لإضافة منطق plan
        $updateFields = $request->except(['main_image', 'thumbnail_images']);

        // إذا تم تمرير plan_days بدون plan_expires_at، احسب تاريخ الانتهاء تلقائياً
        if ($request->has('plan_days') && !$request->filled('plan_expires_at')) {
            $updateFields['plan_expires_at'] = now()->addDays((int) $request->input('plan_days'));
        }

        $carSalesAd->update($updateFields);

        // =========================================================
        // ====        المنطق الذكي لتحديث الصور          ====
        // =========================================================

        $updateData = [];

        // 4. تحديث الصورة الرئيسية (إذا تم رفع صورة جديدة)
        if ($request->hasFile('main_image')) {
            // أ. حذف الصورة القديمة من الـ storage
            Storage::disk('public')->delete($carSalesAd->main_image);

            // ب. رفع الصورة الجديدة
            $path = $request->file('main_image')->store('cars/main', 'public');

            // ج. تجهيز المسار الجديد للحفظ في قاعدة البيانات
            $updateData['main_image'] = $path;
        }

        // 5. تحديث الصور المصغرة (إذا تم رفع صور جديدة)
        if ($request->hasFile('thumbnail_images')) {
            // أ. حذف كل الصور المصغرة القديمة
            if (is_array($carSalesAd->thumbnail_images)) {
                Storage::disk('public')->delete($carSalesAd->thumbnail_images);
            }

            // ب. رفع الصور الجديدة وتجميع مساراتها
            $thumbnailPaths = [];
            foreach ($request->file('thumbnail_images') as $file) {
                $thumbnailPaths[] = $file->store('cars/thumbnails', 'public');
            }

            // ج. تجهيز مصفوفة المسارات الجديدة للحفظ
            $updateData['thumbnail_images'] = $thumbnailPaths;
        }

        // 6. تحديث قاعدة البيانات بمسارات الصور الجديدة (إذا وُجدت)
        if (!empty($updateData)) {
            $carSalesAd->update($updateData);
        }

        // 7. إرجاع بيانات الإعلان المحدثة بالكامل
        // ->fresh() لجلب أحدث نسخة من البيانات من قاعدة البيانات
        return response()->json($carSalesAd->fresh());
    }

    // حذف إعلان
    public function destroy(Request $request, CarSalesAd $carSalesAd)
    {
        // Authorization Check: Only the owner can delete
        if ($request->user()->id !== $carSalesAd->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Delete associated images from storage
        Storage::disk('public')->delete($carSalesAd->main_image);
        if (is_array($carSalesAd->thumbnail_images)) {
            Storage::disk('public')->delete($carSalesAd->thumbnail_images);
        }

        $carSalesAd->delete();

        return response()->json(null, 204); // 204 No Content
    }

    /**
     * [Admin] جلب كل الإعلانات المعلقة للمراجعة.
     */
    public function getPendingAds()
    {
        $pendingAds = CarSalesAd::where('add_status', 'Pending')
            ->latest()
            ->paginate(15);
        return response()->json($pendingAds);
    }

    /**
     * [Admin] الموافقة على إعلان.
     */
    public function approveAd(CarSalesAd $carSalesAd)
    {
        $carSalesAd->update([
            'add_status' => 'Valid',
            'admin_approved' => true,
        ]);

        return response()->json([
            'message' => 'Ad approved successfully.',
            'ad' => $carSalesAd
        ]);
    }

    /**
     * [Admin] رفض إعلان.
     */
    public function rejectAd(CarSalesAd $carSalesAd)
    {
        $carSalesAd->update(['add_status' => 'Rejected']);

        // هنا يمكنك لاحقًا إرسال إشعار للمستخدم بسبب الرفض

        return response()->json([
            'message' => 'Ad rejected successfully.',
            'ad' => $carSalesAd
        ]);
    }

    /**
     * [Admin] جلب جميع الإعلانات بجميع حالاتها للمشرف.
     */
    public function indexForAdmin()
    {
        // ببساطة، نقوم بجلب كل الإعلانات بدون أي شروط (where)
        // with('user') يقوم بجلب بيانات صاحب الإعلان مع كل إعلان لتقليل استعلامات قاعدة البيانات (Eager Loading)
        // latest() لترتيبها من الأحدث للأقدم
        // paginate() لتقسيم النتائج على صفحات
        $allAds = CarSalesAd::with('user')->latest()->paginate(15);

        return response()->json($allAds);
    }

    /**
     * [Admin] Get comprehensive statistics for car sales ads.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStats()
    {
        try {
            // إجمالي الإعلانات
            $totalAds = CarSalesAd::count();

            // الإعلانات المعلقة
            $pendingAds = CarSalesAd::where('add_status', 'Pending')->count();

            // الإعلانات المعتمدة
            $approvedAds = CarSalesAd::where('admin_approved', true)
                ->where('add_status', 'Valid')
                ->count();

            // الإعلانات المرفوضة
            $rejectedAds = CarSalesAd::where('add_status', 'Rejected')->count();

            // الإعلانات في صندوق العروض النشط
            $activeOffersBox = CarSalesAd::where('active_offers_box_days', '>', 0)
                ->where('admin_approved', true)
                ->count();

            // إجمالي المشاهدات
            $totalViews = CarSalesAd::sum('views');

            // إعلانات هذا الشهر
            $thisMonthAds = CarSalesAd::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count();

            // عدد الماركات المختلفة
            $brandsCount = CarSalesAd::distinct('make')->count('make');

            return response()->json([
                'total_ads' => $totalAds,
                'pending_ads' => $pendingAds,
                'approved_ads' => $approvedAds,
                'rejected_ads' => $rejectedAds,
                'active_offers_box' => $activeOffersBox,
                'total_views' => $totalViews,
                'this_month_ads' => $thisMonthAds,
                'brands_count' => $brandsCount
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve statistics',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getMakesWithModels()
    {
        $makes = CarMake::with('models:id,car_make_id,name')->get();

        $data = $makes->map(function ($make) {
            return [
                'make' => $make->name,
                'models' => $make->models->pluck('name')
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
