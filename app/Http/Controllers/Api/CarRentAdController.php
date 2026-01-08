<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CarRentAd;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use App\Traits\HasRank;
use App\Traits\PackageHelper;
use Illuminate\Support\Facades\Storage;

class CarRentAdController extends Controller
{
    use HasRank, PackageHelper;
    // Public: list with smart filters
    public function index(Request $request)
    {
        $query = CarRentAd::query()->where('add_status', 'Valid')->where('admin_approved', true);

        // Smart filters - support multiple values
        $query->when($request->query('make'), fn($q, $v) => $q->filterByMake($v));
        $query->when($request->query('model'), fn($q, $v) => $q->filterByModel($v));
        $query->when($request->query('trim'), fn($q, $v) => $q->filterByTrim($v));
        $query->when($request->query('year'), fn($q, $v) => $q->filterByYear($v));
        $query->when($request->query('emirate'), fn($q, $v) => $q->filterByEmirate($v));
        $query->when($request->query('district'), fn($q, $v) => $q->filterByDistrict($v));
        $query->when($request->query('area'), fn($q, $v) => $q->filterByArea($v));

        // Price range filters
        $query->when($request->query('min_price') || $request->query('max_price'), function ($q) use ($request) {
            return $q->filterByPriceRange($request->query('min_price'), $request->query('max_price'));
        });

        // Day rent range filters
        $query->when($request->query('min_day_rent') || $request->query('max_day_rent'), function ($q) use ($request) {
            return $q->filterByDayRentRange($request->query('min_day_rent'), $request->query('max_day_rent'));
        });

        // Month rent range filters
        $query->when($request->query('min_month_rent') || $request->query('max_month_rent'), function ($q) use ($request) {
            return $q->filterByMonthRentRange($request->query('min_month_rent'), $request->query('max_month_rent'));
        });

        // Keyword search
        $query->when($request->query('keyword'), function ($q, $keyword) {
            return $q->where(function ($subQuery) use ($keyword) {
                $subQuery->where('title', 'like', '%' . $keyword . '%')
                    ->orWhere('description', 'like', '%' . $keyword . '%');
            });
        });

        // Sorting options
        $sortBy = $request->query('sort_by', 'latest');
        switch ($sortBy) {
            case 'most_viewed':
                $query->mostViewed();
                break;
            case 'rank':
                $query->byRank();
                break;
            default:
                $query->orderedByRank();
                break;
        }

        // $ads = $query->paginate(15)->withQueryString();
        $data = $query->get();
        foreach ($data as $ad) {
            $ad->incrementViews();
        };
        return response()->json($data);
    }

    /**
     * Smart search for car rent ads with advanced filtering.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $query = CarRentAd::active();

        // Apply all smart filters
        $query->when($request->query('make'), fn($q, $v) => $q->filterByMake($v));
        $query->when($request->query('model'), fn($q, $v) => $q->filterByModel($v));
        $query->when($request->query('trim'), fn($q, $v) => $q->filterByTrim($v));
        $query->when($request->query('year'), fn($q, $v) => $q->filterByYear($v));
        $query->when($request->query('emirate'), fn($q, $v) => $q->filterByEmirate($v));
        $query->when($request->query('district'), fn($q, $v) => $q->filterByDistrict($v));
        $query->when($request->query('area'), fn($q, $v) => $q->filterByArea($v));

        $query->when($request->query('min_price') || $request->query('max_price'), function ($q) use ($request) {
            return $q->filterByPriceRange($request->query('min_price'), $request->query('max_price'));
        });

        $query->when($request->query('min_day_rent') || $request->query('max_day_rent'), function ($q) use ($request) {
            return $q->filterByDayRentRange($request->query('min_day_rent'), $request->query('max_day_rent'));
        });

        $query->when($request->query('min_month_rent') || $request->query('max_month_rent'), function ($q) use ($request) {
            return $q->filterByMonthRentRange($request->query('min_month_rent'), $request->query('max_month_rent'));
        });

        $query->when($request->query('keyword'), function ($q, $keyword) {
            return $q->where(function ($subQuery) use ($keyword) {
                $subQuery->where('title', 'like', '%' . $keyword . '%')
                    ->orWhere('description', 'like', '%' . $keyword . '%');
            });
        });

        // Sorting
        $sortBy = $request->query('sort_by', 'latest');
        switch ($sortBy) {
            case 'most_viewed':
                $query->mostViewed();
                break;
            case 'rank':
                $query->byRank();
                break;
            default:
                $query->orderedByRank();
                break;
        }

        $ads = $query->paginate(15)->withQueryString();
        return response()->json($ads);
    }

    /**
     * Get car rent ads for offers box with smart filtering.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOffersBoxAds(Request $request)
    {
        $query = CarRentAd::active()->offerBoxOnly();

        // Apply smart filters for offers box
        $query->when($request->query('make'), fn($q, $v) => $q->filterByMake($v));
        $query->when($request->query('model'), fn($q, $v) => $q->filterByModel($v));
        $query->when($request->query('trim'), fn($q, $v) => $q->filterByTrim($v));
        $query->when($request->query('year'), fn($q, $v) => $q->filterByYear($v));
        $query->when($request->query('emirate'), fn($q, $v) => $q->filterByEmirate($v));
        $query->when($request->query('district'), fn($q, $v) => $q->filterByDistrict($v));
        $query->when($request->query('area'), fn($q, $v) => $q->filterByArea($v));

        $query->when($request->query('min_price') || $request->query('max_price'), function ($q) use ($request) {
            return $q->filterByPriceRange($request->query('min_price'), $request->query('max_price'));
        });

        $query->when($request->query('min_day_rent') || $request->query('max_day_rent'), function ($q) use ($request) {
            return $q->filterByDayRentRange($request->query('min_day_rent'), $request->query('max_day_rent'));
        });

        $query->when($request->query('min_month_rent') || $request->query('max_month_rent'), function ($q) use ($request) {
            return $q->filterByMonthRentRange($request->query('min_month_rent'), $request->query('max_month_rent'));
        });

        $query->when($request->query('keyword'), function ($q, $keyword) {
            return $q->where(function ($subQuery) use ($keyword) {
                $subQuery->where('title', 'like', '%' . $keyword . '%')
                    ->orWhere('description', 'like', '%' . $keyword . '%');
            });
        });

        $data = $query->get();
        foreach ($data as $ad) {
            $ad->incrementViews();
        };
        return response()->json($data);
    }

    // Public: show
    public function show(CarRentAd $carRentAd)
    {
        $carRentAd->incrementViews();
        $carRentAd->load('user');
        return response()->json($carRentAd);
    }

    // Auth: create
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'emirate' => 'required|string|max:100',
            'district' => 'nullable|string|max:100',
            'area' => 'nullable|string|max:100',
            'make' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'trim' => 'nullable|string|max:100',
            'year' => 'nullable|integer|min:1900|max:' . (int) date('Y') + 1,
            'car_type' => 'nullable|string|max:100',
            'trans_type' => 'nullable|string|max:100',
            'fuel_type' => 'nullable|string|max:100',
            'color' => 'nullable|string|max:100',
            'interior_color' => 'nullable|string|max:100',
            'seats_no' => 'nullable|integer|min:1|max:50',
            'day_rent' => 'nullable|numeric|min:0',
            'month_rent' => 'nullable|numeric|min:0',
            'price' => 'nullable|numeric|min:0',
            'location' => 'nullable|string|max:500',
            'advertiser_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'main_image' => 'required|image|max:5120',
            'thumbnail_images.*' => 'image|max:5120',
            'plan_type' => 'nullable|string|max:50|in:featured,premium_star,premium,free',
            // 'plan_days' => 'nullable|integer|min:0',
            // 'plan_expires_at' => 'nullable|date',
            'payment' => 'nullable|boolean',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $data = [
            'title' => $validated['title'],
            'description' => $validated['description'],
            'emirate' => $validated['emirate'],
            'district' => $validated['district'] ?? null,
            'area' => $validated['area'] ?? null,
            'make' => $validated['make'] ?? null,
            'model' => $validated['model'] ?? null,
            'trim' => $validated['trim'] ?? null,
            'year' => $validated['year'] ?? null,
            'car_type' => $validated['car_type'] ?? null,
            'trans_type' => $validated['trans_type'] ?? null,
            'fuel_type' => $validated['fuel_type'] ?? null,
            'color' => $validated['color'] ?? null,
            'interior_color' => $validated['interior_color'] ?? null,
            'seats_no' => $validated['seats_no'] ?? null,
            'day_rent' => $validated['day_rent'] ?? null,
            'month_rent' => $validated['month_rent'] ?? null,
            'price' => $validated['price'] ?? null,
            'location' => $validated['location'] ?? null,
            'user_id' => $user->id,
            'add_category' => 'Car Rent',
            'plan_type' => $validated['plan_type'] ?? "free",
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
        ];

        $data['advertiser_name'] = $validated['advertiser_name'];
        $data['phone_number'] = $validated['phone_number'];
        $data['whatsapp'] = $validated['whatsapp'] ?? null;
        // --- Package deduction / payment handling ---
        if (!empty($validated['plan_type']) && $validated['plan_type'] !== 'free') {
            $packageResult = $this->autoDeductAd($user, $validated['plan_type']);

            if ($packageResult['success']) {
                $data['plan_type'] = $packageResult['package_type'];
                $data['payment'] = false;
            } else {
                if (!empty($validated['payment']) && $validated['payment'] == true) {
                    $data['plan_type'] = $validated['plan_type'];
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'No active package found. Please purchase or pay for this ad.',
                    ], 403);
                }
            }
        } else {
            $freeAdsLimit = SystemSetting::where('key', 'free_ads_limit')->value('value') ?? 0;

            $userFreeAdsCount = CarRentAd::where('user_id', $user->id)
                ->where('plan_type', 'free')
                ->count();

            if ($userFreeAdsCount >= (int)$freeAdsLimit) {
                return response()->json([
                    'success' => false,
                    'message' => 'You have reached the maximum number of free ads allowed.',
                ], 403);
            }

            $data['plan_type'] = 'free';
            $data['payment'] = false;
        }
        // upload images
        $mainImagePath = $request->file('main_image')->store('car_rent/main', 'public');
        $data['main_image'] = $mainImagePath;

        $thumbnailPaths = [];
        if ($request->hasFile('thumbnail_images')) {
            foreach ($request->file('thumbnail_images') as $file) {
                $thumbnailPaths[] = $file->store('car_rent/thumbnails', 'public');
            }
        }
        $data['thumbnail_images'] = $thumbnailPaths;

        // plan fields
        if ($request->filled('plan_type')) {
            $data['plan_type'] = $request->input('plan_type');
        }
        // if ($request->has('plan_days')) {
        //     $data['plan_days'] = (int) $request->input('plan_days');
        //     if (!$request->filled('plan_expires_at')) {
        //         $data['plan_expires_at'] = now()->addDays($data['plan_days']);
        //     }
        // }
        // if ($request->filled('plan_expires_at')) {
        //     $data['plan_expires_at'] = $request->input('plan_expires_at');
        // }

        // manual approval mode (car_rent specific or global fallback)
        // اتّباع نفس منطق الأقسام الأخرى: استخدام الإعداد العام مع Cache
        $manualApproval = cache()->rememberForever('setting_manual_approval_mode', function () {
            return optional(\App\Models\SystemSetting::where('key', 'manual_approval_mode')->first())->value ?? 'true';
        });

        $isManualApprovalActive = filter_var($manualApproval, FILTER_VALIDATE_BOOLEAN);
        if ($isManualApprovalActive) {
            // الموافقة اليدوية مفعلة => Pending
            $data['add_status'] = 'Pending';
            $data['admin_approved'] = false;
        } else {
            // القبول التلقائي مفعّل => Valid
            $data['add_status'] = 'Valid';
            $data['admin_approved'] = true;
        }
        $rank = $this->getNextRank(CarRentAd::class);
        $data['rank'] = $rank;
        $ad = CarRentAd::create($data);

        return response()->json([
            'success' => true,
            'message' => 'تم إضافة الإعلان بنجاح',
            'data' => $data
        ], 201);
    }

    // Auth: update
    public function update(Request $request, CarRentAd $carRentAd)
    {
        // ✅ تحقق من صلاحية المستخدم
        if ($request->user()->id !== $carRentAd->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $nextYear = date('Y') + 1;

        // ✅ التحقق من البيانات
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'emirate' => 'sometimes|required|string|max:100',
            'district' => 'nullable|string|max:100',
            'area' => 'nullable|string|max:100',
            'make' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'trim' => 'nullable|string|max:100',
            'year' => "nullable|integer|min:1900|max:$nextYear",
            'car_type' => 'nullable|string|max:100',
            'trans_type' => 'nullable|string|max:100',
            'fuel_type' => 'nullable|string|max:100',
            'color' => 'nullable|string|max:100',
            'interior_color' => 'nullable|string|max:100',
            'seats_no' => 'nullable|integer|min:1|max:50',
            'day_rent' => 'nullable|numeric|min:0',
            'month_rent' => 'nullable|numeric|min:0',
            'price' => 'nullable|numeric|min:0',
            'location' => 'nullable|string|max:500',
            'advertiser_name' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'main_image' => 'sometimes|image|max:5120',
            'thumbnail_images.*' => 'sometimes|image|max:5120',
            // 'plan_type' => 'nullable|string|max:50',
            // 'plan_days' => 'nullable|integer|min:0',
            // 'plan_expires_at' => 'nullable|date',
            'payment' => 'sometimes|nullable|boolean',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        // ✅ تحديث الحقول النصية
        $carRentAd->fill($validated);

        // ✅ تحديث الصورة الرئيسية
        if ($request->hasFile('main_image')) {
            $oldMain = $carRentAd->main_image;

            if (is_string($oldMain) && !empty($oldMain)) {
                Storage::disk('public')->delete($oldMain);
            }

            $carRentAd->main_image = $request->file('main_image')->store('car_rent/main', 'public');
        }

        // ✅ تحديث الصور المصغّرة thumbnail_images
        if ($request->hasFile('thumbnail_images')) {
            // تأكد من تحويل القديمة إلى array
            $oldThumbs = $carRentAd->thumbnail_images;

            if (is_string($oldThumbs)) {
                $oldThumbs = json_decode($oldThumbs, true) ?: [];
            } elseif (!is_array($oldThumbs)) {
                $oldThumbs = [];
            }

            // أضف الصور الجديدة
            foreach ($request->file('thumbnail_images') as $file) {
                if ($file) {
                    $oldThumbs[] = $file->store('car_rent/thumbnails', 'public');
                }
            }

            // نظّف المصفوفة من العناصر الفارغة
            $oldThumbs = array_filter($oldThumbs, fn($v) => !empty($v));
            $carRentAd->thumbnail_images = array_values($oldThumbs);
        }

        // // ✅ تحديث بيانات الباقة (plan)
        // if ($request->filled('plan_type')) {
        //     $carRentAd->plan_type = $request->input('plan_type');
        // }

        // if ($request->has('plan_days')) {
        //     $carRentAd->plan_days = (int) $request->input('plan_days');
        //     if (!$request->filled('plan_expires_at')) {
        //         $carRentAd->plan_expires_at = now()->addDays($carRentAd->plan_days);
        //     }
        // }

        // if ($request->filled('plan_expires_at')) {
        //     $carRentAd->plan_expires_at = $request->input('plan_expires_at');
        // }

        // ✅ حفظ البيانات بعد كل التحديثات
        $carRentAd->save();

        // ✅ الرد النهائي
        return response()->json([
            'success' => true,
            'message' => 'تم تحديث الإعلان بنجاح',
            'data' => $carRentAd->fresh(),
        ]);
    }





    // Auth: delete
    public function destroy(Request $request, CarRentAd $carRentAd)
    {
        if ($request->user()->id !== $carRentAd->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if ($carRentAd->main_image) {
            Storage::disk('public')->delete($carRentAd->main_image);
        }
        foreach (($carRentAd->thumbnail_images ?? []) as $p) {
            Storage::disk('public')->delete($p);
        }
        $carRentAd->delete();
        return response()->json(['success' => true]);
    }

    // Admin: index
    public function indexForAdmin(Request $request)
    {
        $query = CarRentAd::query()->with(['user']);
        $query->when($request->query('status'), fn($q, $v) => $q->where('add_status', $v));
        $query->when($request->query('approved'), fn($q, $v) => $q->where('admin_approved', $v === 'true'));
        $ads = $query->latest()->paginate(20)->withQueryString();
        return response()->json($ads);
    }

    public function approveAd(Request $request, CarRentAd $carRentAd)
    {
        $carRentAd->update(['add_status' => 'Valid', 'admin_approved' => true]);
        return response()->json(['success' => true]);
    }

    public function rejectAd(Request $request, CarRentAd $carRentAd)
    {
        $carRentAd->update(['add_status' => 'Rejected', 'admin_approved' => false]);
        return response()->json(['success' => true]);
    }

    // Offers box public
    // public function getOffersBoxAds(Request $request)
    // {
    //     $limit = $request->query('limit', 10);
    //     $ads = CarRentAd::getOffersBoxAds($limit);
    //     return response()->json($ads);
    // }

    // Search (advanced)
    // public function search(Request $request)
    // {
    //     $request->validate([
    //         'emirate' => 'nullable|string|max:100',
    //         'make' => 'nullable|string|max:100',
    //         'model' => 'nullable|string|max:100',
    //         'trim' => 'nullable|string|max:100',
    //         'year' => 'nullable|integer|min:1900|max:' . (int)date('Y') + 1,
    //         'district' => 'nullable|string|max:100',
    //         'area' => 'nullable|string|max:100',
    //         'min_price' => 'nullable|numeric|min:0',
    //         'max_price' => 'nullable|numeric|min:0',
    //         'min_day_rent' => 'nullable|numeric|min:0',
    //         'max_day_rent' => 'nullable|numeric|min:0',
    //         'min_month_rent' => 'nullable|numeric|min:0',
    //         'max_month_rent' => 'nullable|numeric|min:0',
    //         'keyword' => 'nullable|string|max:255',
    //         'sort_by' => 'nullable|in:latest,price_low,price_high,most_viewed',
    //         'per_page' => 'nullable|integer|min:1|max:50',
    //     ]);

    //     $query = CarRentAd::query()->where('add_status', 'Valid')->where('admin_approved', true);

    //     if ($request->filled('emirate')) $query->byEmirate($request->emirate);
    //     if ($request->filled('make')) $query->byMake($request->make);
    //     if ($request->filled('model')) $query->byModel($request->model);
    //     if ($request->filled('trim')) $query->byTrim($request->trim);
    //     if ($request->filled('year')) $query->byYear($request->year);
    //     if ($request->filled('district')) $query->byDistrict($request->district);
    //     if ($request->filled('area')) $query->byArea($request->area);

    //     if ($request->filled('min_price') || $request->filled('max_price'))
    //         $query->byPriceRange($request->min_price, $request->max_price);
    //     if ($request->filled('min_day_rent') || $request->filled('max_day_rent'))
    //         $query->byDayRentRange($request->min_day_rent, $request->max_day_rent);
    //     if ($request->filled('min_month_rent') || $request->filled('max_month_rent'))
    //         $query->byMonthRentRange($request->min_month_rent, $request->max_month_rent);

    //     if ($request->filled('keyword')) {
    //         $kw = '%' . $request->keyword . '%';
    //         $query->where(function($q) use ($kw) {
    //             $q->where('title', 'like', $kw)
    //               ->orWhere('description', 'like', $kw)
    //               ->orWhere('make', 'like', $kw)
    //               ->orWhere('model', 'like', $kw)
    //               ->orWhere('trim', 'like', $kw);
    //         });
    //     }

    //     if ($request->filled('sort_by')) {
    //         switch ($request->sort_by) {
    //             case 'latest': default: $query->orderBy('created_at', 'desc'); break;
    //             case 'price_low': $query->orderByRaw('COALESCE(price, day_rent, month_rent) asc'); break;
    //             case 'price_high': $query->orderByRaw('COALESCE(price, day_rent, month_rent) desc'); break;
    //             case 'most_viewed': $query->orderBy('views', 'desc'); break;
    //         }
    //     } else {
    //         $query->orderBy('created_at', 'desc');
    //     }

    //     $perPage = $request->query('per_page', 15);
    //     $ads = $query->paginate($perPage)->withQueryString();
    //     return response()->json($ads);
    // }

    // Admin stats
    public function getStats()
    {
        return response()->json([
            'total_ads' => CarRentAd::count(),
            'active_ads' => CarRentAd::where('add_status', 'Valid')->where('admin_approved', true)->count(),
            'pending_ads' => CarRentAd::where('add_status', 'Pending')->count(),
            'rejected_ads' => CarRentAd::where('add_status', 'Rejected')->count(),
        ]);
    }
}
