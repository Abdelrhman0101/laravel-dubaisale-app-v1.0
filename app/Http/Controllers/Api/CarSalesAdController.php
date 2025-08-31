<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CarSalesAd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

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
        ]);

        $data = $request->all();

        // (هذا الجزء الخاص بالصلاحيات مؤقت وغير مثالي، الأفضل معالجته على مستوى الخادم)
        $fixPermissions = function ($path) { /* ... */ };

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
        return response()->json($carSalesAd);
    }

    // تحديث إعلان
    public function update(Request $request, CarSalesAd $carSalesAd)
    {
        // Authorization Check: Only the owner can update
        if ($request->user()->id !== $carSalesAd->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        // Validate incoming data
        $validatedData = $request->validate([ 'title' => 'sometimes|required|string|max:255', /*...*/]);

        // For this example, we'll just update simple fields
        $carSalesAd->update($request->except(['main_image', 'thumbnail_images']));

        // Logic to update images can be added here (delete old, upload new)

        return response()->json($carSalesAd);
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
}