<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CarServicesAd;
use App\Models\CarServiceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class CarServicesAdController extends Controller
{
    /**
     * Display a listing of car services ads with smart filtering.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        // 1. نبدأ بالاستعلام الأساسي الذي يعرض الإعلانات المعتمدة فقط
        $query = CarServicesAd::query()
                       ->where('add_status', 'Valid')
                       ->where('admin_approved', true);

        // 2. تطبيق الفلاتر بشكل ديناميكي بناءً على الطلب الوارد
        // الدالة `when` تقوم بتطبيق الفلتر فقط إذا كانت القيمة موجودة في الطلب

        // Filter by 'service_type' if provided in the URL query string
        $query->when($request->query('service_type'), function ($q, $serviceType) {
            return $q->byServiceType($serviceType);
        });

        // Filter by 'emirate' if provided in the URL query string
        $query->when($request->query('emirate'), function ($q, $emirate) {
            return $q->byEmirate($emirate);
        });

        // Filter by 'district' if provided in the URL query string
        $query->when($request->query('district'), function ($q, $district) {
            return $q->byDistrict($district);
        });

        // Filter by 'area' if provided in the URL query string
        $query->when($request->query('area'), function ($q, $area) {
            return $q->byArea($area);
        });

        // Filter by price range if provided
        $query->when($request->query('min_price'), function ($q, $minPrice) {
            return $q->byPriceRange($minPrice, null);
        });

        $query->when($request->query('max_price'), function ($q, $maxPrice) {
            return $q->byPriceRange(null, $maxPrice);
        });
        
        // 3. الترتيب من الأحدث للأقدم وتقسيم النتائج على صفحات
        $ads = $query->latest()->paginate(15)->withQueryString();

        return response()->json($ads);
    }

    /**
     * Store a newly created car services ad.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'emirate' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'area' => 'required|string|max:100',
            'service_type' => 'required|string|exists:car_service_types,name',
            'service_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'location' => 'required|string|max:500',
            'advertiser_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'whatsapp' => 'required|string|max:20',
            'main_image' => 'required|image|max:5120', // 5MB max
            'thumbnail_images.*' => 'image|max:5120',
        ]);

        $user = $request->user();

        // Prepare data array with only actual database columns
        $data = [
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'emirate' => $validatedData['emirate'],
            'district' => $validatedData['district'],
            'area' => $validatedData['area'],
            'service_type' => $validatedData['service_type'],
            'service_name' => $validatedData['service_name'],
            'price' => $validatedData['price'],
            'location' => $validatedData['location'] ?? null,
            'user_id' => $user->id,
            'add_category' => 'Car Services',
        ];

        // Set contact info from request data
        $data['advertiser_name'] = $validatedData['advertiser_name'];
        $data['phone_number'] = $validatedData['phone_number'];
        $data['whatsapp'] = $validatedData['whatsapp'];

        // رفع الصورة الأساسية
        $mainImagePath = $request->file('main_image')->store('car_services/main', 'public');
        $data['main_image'] = $mainImagePath;

        // رفع الصور المصغرة
        $thumbnailPaths = [];
        if ($request->hasFile('thumbnail_images_urls')) {
            foreach ($request->file('thumbnail_images_urls') as $thumbnailImage) {
                $thumbnailPath = $thumbnailImage->store('car_services/thumbnails', 'public');
                $thumbnailPaths[] = $thumbnailPath;
            }
        }
        $data['thumbnail_images'] = json_encode($thumbnailPaths);

        // =========================================================
        // ====   هنا يبدأ المنطق الذكي للموافقة التلقائية    ====
        // =========================================================

        // 1. جلب إعداد الموافقة من قاعدة البيانات
        $manualApproval = cache()->rememberForever('setting_manual_approval_mode', function () {
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

        $ad = CarServicesAd::create($data);

        return response()->json([
            'success' => true,
            'message' => 'تم إضافة الإعلان بنجاح',
            'data' => [
                'id' => $ad->id,
                'title' => $ad->title,
                'service_type' => $ad->service_type,
                'advertiser_name' => $ad->advertiser_name,
                'phone_number' => $ad->phone_number,
                'whatsapp' => $ad->whatsapp,
                'price' => $ad->price,
                'main_image' => $ad->main_image,
                'thumbnail_images_urls' => $thumbnailPaths
            ]
        ], 201);
    }

    /**
     * Display the specified car services ad.
     *
     * @param  \App\Models\CarServicesAd  $carServicesAd
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(CarServicesAd $carServicesAd)
    {
        // Increment views count
        $carServicesAd->incrementViews();
        
        // Load service type relationship
        $carServicesAd->load('serviceType');
        
        return response()->json($carServicesAd);
    }

    /**
     * Update the specified car services ad.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CarServicesAd  $carServicesAd
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, CarServicesAd $carServicesAd)
    {
        // 1. التحقق من أن المستخدم هو صاحب الإعلان
        if ($request->user()->id !== $carServicesAd->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        // 2. التحقق من صحة البيانات المدخلة
        $validatedData = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'emirate' => 'sometimes|required|string|max:100',
            'district' => 'sometimes|required|string|max:100',
            'area' => 'sometimes|required|string|max:100',
            'service_type' => 'sometimes|required|string|exists:car_service_types,name',
            'service_name' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|numeric|min:0',
            'location' => 'sometimes|nullable|string|max:500',
            'main_image' => 'sometimes|image|max:5120',
            'thumbnail_images.*' => 'sometimes|image|max:5120',
        ]);

        // 3. تحديث الحقول النصية
        $carServicesAd->update($request->except(['main_image', 'thumbnail_images']));

        // =========================================================
        // ====        المنطق الذكي لتحديث الصور          ====
        // =========================================================
        
        $updateData = [];

        // 4. تحديث الصورة الرئيسية (إذا تم رفع صورة جديدة)
        if ($request->hasFile('main_image')) {
            // أ. حذف الصورة القديمة من الـ storage
            Storage::disk('public')->delete($carServicesAd->main_image);
            
            // ب. رفع الصورة الجديدة
            $path = $request->file('main_image')->store('car_services/main', 'public');
            
            // ج. تجهيز المسار الجديد للحفظ في قاعدة البيانات
            $updateData['main_image'] = $path;
        }

        // 5. تحديث الصور المصغرة (إذا تم رفع صور جديدة)
        if ($request->hasFile('thumbnail_images')) {
            // أ. حذف كل الصور المصغرة القديمة
            if (is_array($carServicesAd->thumbnail_images)) {
                Storage::disk('public')->delete($carServicesAd->thumbnail_images);
            }
            
            // ب. رفع الصور الجديدة وتجميع مساراتها
            $thumbnailPaths = [];
            foreach ($request->file('thumbnail_images') as $file) {
                $thumbnailPaths[] = $file->store('car_services/thumbnails', 'public');
            }
            
            // ج. تجهيز مصفوفة المسارات الجديدة للحفظ
            $updateData['thumbnail_images'] = $thumbnailPaths;
        }

        // 6. تحديث قاعدة البيانات بمسارات الصور الجديدة (إذا وُجدت)
        if (!empty($updateData)) {
            $carServicesAd->update($updateData);
        }
        
        // 7. إرجاع بيانات الإعلان المحدثة بالكامل
        return response()->json($carServicesAd->fresh());
    }

    /**
     * Remove the specified car services ad from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CarServicesAd  $carServicesAd
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, CarServicesAd $carServicesAd)
    {
        // Authorization Check: Only the owner can delete
        if ($request->user()->id !== $carServicesAd->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Delete associated images from storage
        Storage::disk('public')->delete($carServicesAd->main_image);
        if (is_array($carServicesAd->thumbnail_images)) {
            Storage::disk('public')->delete($carServicesAd->thumbnail_images);
        }

        $carServicesAd->delete();

        return response()->json(null, 204); // 204 No Content
    }

    /**
     * Get all car services ads for admin panel.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexForAdmin(Request $request)
    {
        $query = CarServicesAd::query()->with(['user', 'serviceType']);

        // Filter by status if provided
        $query->when($request->query('status'), function ($q, $status) {
            return $q->where('add_status', $status);
        });

        // Filter by approval status if provided
        $query->when($request->query('approved'), function ($q, $approved) {
            return $q->where('admin_approved', $approved === 'true');
        });

        $ads = $query->latest()->paginate(20)->withQueryString();

        return response()->json($ads);
    }

    /**
     * [Admin] Approve a car services ad.
     *
     * @param  \App\Models\CarServicesAd  $carServicesAd
     * @return \Illuminate\Http\JsonResponse
     */
    public function approveAd(CarServicesAd $carServicesAd)
    {
        $carServicesAd->update([
            'add_status' => 'Valid',
            'admin_approved' => true,
        ]);

        return response()->json([
            'message' => 'Car services ad approved successfully.',
            'ad' => $carServicesAd
        ]);
    }

    /**
     * [Admin] Reject a car services ad.
     *
     * @param  \App\Models\CarServicesAd  $carServicesAd
     * @return \Illuminate\Http\JsonResponse
     */
    public function rejectAd(CarServicesAd $carServicesAd)
    {
        $carServicesAd->update([
            'add_status' => 'Rejected',
            'admin_approved' => false,
        ]);

        return response()->json([
            'message' => 'Car services ad rejected successfully.',
            'ad' => $carServicesAd
        ]);
    }

    /**
     * Get car services ads for offers box.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOffersBoxAds(Request $request)
    {
        $limit = $request->query('limit', 10);
        $ads = CarServicesAd::getOffersBoxAds($limit);
        
        return response()->json($ads);
    }

    /**
     * Get search filters data for car services.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSearchFilters()
    {
        // Get unique emirates from car services ads
        $emirates = CarServicesAd::select('emirate')
                                 ->distinct()
                                 ->whereNotNull('emirate')
                                 ->where('emirate', '!=', '')
                                 ->orderBy('emirate')
                                 ->pluck('emirate');

        // Get active service types
        $serviceTypes = CarServiceType::where('is_active', true)
                                      ->orderBy('sort_order')
                                      ->orderBy('name')
                                      ->get(['name', 'display_name']);

        // Get unique districts from car services ads
        $districts = CarServicesAd::select('district')
                                  ->distinct()
                                  ->whereNotNull('district')
                                  ->where('district', '!=', '')
                                  ->orderBy('district')
                                  ->pluck('district');

        return response()->json([
            'emirates' => $emirates,
            'service_types' => $serviceTypes,
            'districts' => $districts,
        ]);
    }

    /**
     * Advanced search for car services ads.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $request->validate([
            'emirate' => 'nullable|string|max:100',
            'service_type' => 'nullable|string|exists:car_service_types,name',
            'district' => 'nullable|string|max:100',
            'area' => 'nullable|string|max:100',
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|min:0',
            'keyword' => 'nullable|string|max:255',
            'sort_by' => 'nullable|in:latest,price_low,price_high,most_viewed',
            'per_page' => 'nullable|integer|min:1|max:50',
        ]);

        // Start with active ads query
        $query = CarServicesAd::query()
                              ->where('add_status', 'Valid')
                              ->where('admin_approved', true);

        // Apply filters
        if ($request->filled('emirate')) {
            $query->byEmirate($request->emirate);
        }

        if ($request->filled('service_type')) {
            $query->byServiceType($request->service_type);
        }

        if ($request->filled('district')) {
            $query->byDistrict($request->district);
        }

        if ($request->filled('area')) {
            $query->byArea($request->area);
        }

        if ($request->filled('min_price') || $request->filled('max_price')) {
            $query->byPriceRange($request->min_price, $request->max_price);
        }

        // Keyword search in title, description, and service_name
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'LIKE', "%{$keyword}%")
                  ->orWhere('description', 'LIKE', "%{$keyword}%")
                  ->orWhere('service_name', 'LIKE', "%{$keyword}%");
            });
        }

        // Apply sorting
        switch ($request->sort_by) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'most_viewed':
                $query->mostViewed();
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        $perPage = $request->per_page ?? 15;
        $ads = $query->paginate($perPage)->withQueryString();

        return response()->json($ads);
    }
}