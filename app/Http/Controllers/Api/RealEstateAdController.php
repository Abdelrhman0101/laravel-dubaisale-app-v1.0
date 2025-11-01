<?php

namespace App\Http\Controllers\Api;

use App\Traits\HasRank;
use App\Traits\PackageHelper;
use App\Http\Controllers\Controller;
use App\Models\RealEstateAd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RealEstateAdController extends Controller
{
    use HasRank, PackageHelper;
    /**
     * GET /real-estates - Public index with smart filters
     */
    public function index(Request $request)
    {
        $query = RealEstateAd::active();

        // Smart filters - support multiple values
        $query->when($request->query('emirate'), function ($q, $emirate) {
            return $q->filterByEmirate($emirate);
        });

        $query->when($request->query('district'), function ($q, $district) {
            return $q->filterByDistrict($district);
        });

        $query->when($request->query('area'), function ($q, $area) {
            return $q->filterByArea($area);
        });

        $query->when($request->query('contract_type'), function ($q, $contractType) {
            return $q->filterByContractType($contractType);
        });

        $query->when($request->query('property_type'), function ($q, $propertyType) {
            return $q->filterByPropertyType($propertyType);
        });

        // Price range filter
        $query->when($request->query('min_price') || $request->query('max_price'), function ($q) use ($request) {
            return $q->filterByPriceRange($request->query('min_price'), $request->query('max_price'));
        });

        // Keyword search in title, description, property_type, contract_type
        $query->when($request->query('keyword'), function ($q, $keyword) {
            return $q->where(function ($subQuery) use ($keyword) {
                $subQuery->where('title', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%")
                    ->orWhere('property_type', 'like', "%{$keyword}%")
                    ->orWhere('contract_type', 'like', "%{$keyword}%");
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
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'latest':
            default:
                $query->orderedByRank();
                break;
        }

        // In offers box filter
        if ($request->boolean('in_offers_box')) {
            $query->inOffersBox();
        }

        $perPage = $request->query('per_page', 15);
        $perPage = min(max($perPage, 1), 50); // Between 1 and 50

        return response()->json($query->get());
    }

    /**
     * Smart search endpoint for real estates.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        // Validation for search parameters
        $request->validate([
            'emirate' => 'nullable|string|max:500',
            'district' => 'nullable|string|max:500',
            'area' => 'nullable|string|max:500',
            'contract_type' => 'nullable|string|max:500',
            'property_type' => 'nullable|string|max:500',
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|min:0',
            'keyword' => 'nullable|string|max:255',
            'sort_by' => 'nullable|in:latest,most_viewed,rank,price_low,price_high',
            'per_page' => 'nullable|integer|min:1|max:50',
            'in_offers_box' => 'nullable|boolean',
        ]);

        // Use the same logic as index method
        return $this->index($request);
    }

    /**
     * Get offer box ads with smart filtering.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOffersBoxAds(Request $request)
    {
        // Start with offer box query
        $query = RealEstateAd::active()->offerBoxOnly();

        // Apply the same smart filters as index method
        $query->when($request->query('emirate'), function ($q, $emirate) {
            return $q->filterByEmirate($emirate);
        });

        $query->when($request->query('district'), function ($q, $district) {
            return $q->filterByDistrict($district);
        });

        $query->when($request->query('area'), function ($q, $area) {
            return $q->filterByArea($area);
        });

        $query->when($request->query('contract_type'), function ($q, $contractType) {
            return $q->filterByContractType($contractType);
        });

        $query->when($request->query('property_type'), function ($q, $propertyType) {
            return $q->filterByPropertyType($propertyType);
        });

        $query->when($request->query('min_price') || $request->query('max_price'), function ($q) use ($request) {
            return $q->filterByPriceRange($request->query('min_price'), $request->query('max_price'));
        });

        $query->when($request->query('keyword'), function ($q, $keyword) {
            return $q->where(function ($subQuery) use ($keyword) {
                $subQuery->where('title', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%")
                    ->orWhere('property_type', 'like', "%{$keyword}%")
                    ->orWhere('contract_type', 'like', "%{$keyword}%");
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
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'latest':
            default:
                $query->orderedByRank();
                break;
        }

        $perPage = $request->query('per_page', 15);
        $perPage = min(max($perPage, 1), 50);

        return response()->json($query->paginate($perPage)->withQueryString());
    }

    /**
     * GET /real-estates/{id}
     */
    public function show($id)
    {
        try {
            $realEstateAd = RealEstateAd::findOrFail($id);
            $realEstateAd->incrementViews();
            return response()->json($realEstateAd);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => ' this Ad not found'
            ], 404);
        }
    }
    /**
     * POST /real-estates - Create new ad
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'emirate' => 'required|string|max:100',
            'district' => 'nullable|string|max:100',
            'area' => 'nullable|string|max:150',
            'price' => 'required|numeric|min:0',
            'contract_type' => 'nullable|string|max:50',
            'property_type' => 'nullable|string|max:50',
            'advertiser_name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'whatsapp_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'main_image' => 'required|image|max:5120',
            'thumbnail_images.*' => 'image|max:5120',
            // Plan
            'plan_type' => 'nullable|string|max:50',
            'plan_days' => 'nullable|integer|min:0',
            'plan_expires_at' => 'nullable|date',
            'payment' => 'nullable|boolean',
        ]);

        $data = $validated;
        $user = $request->user();
        $data['user_id'] = $request->user()->id;
        $data['add_category'] = 'Real State';

        // --- Package deduction / payment handling ---
        if (!empty($validated['plan_type']) && $validated['plan_type'] !== 'free') {
            $packageResult = $this->autoDeductAd($user, $validated['plan_type']);

            if ($packageResult['success']) {
                $data['plan_type'] = $packageResult['package_type'];
                $data['payment'] = false;
            } else {
                if (!empty($validated['payment']) && $validated['payment'] == true) {
                    $data['plan_type'] = $validated['plan_type'];
                    // $data['payment'] = true;
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'No active package found. Please purchase or pay for this ad.',
                    ], 403);
                }
            }
        } else {

            $data['plan_type'] = 'free';
            $data['payment'] = false;
        }
        // Upload images
        $data['main_image'] = $request->file('main_image')->store('real_estates/main', 'public');
        $thumbs = [];
        if ($request->hasFile('thumbnail_images')) {
            foreach ($request->file('thumbnail_images') as $file) {
                $thumbs[] = $file->store('real_estates/thumbnails', 'public');
            }
        }
        $data['thumbnail_images'] = $thumbs;

        // Plan
        if ($request->has('plan_days') && !$request->filled('plan_expires_at')) {
            $data['plan_expires_at'] = now()->addDays((int) $request->plan_days);
        }
        // Manual approval check
        $manualApproval = cache()->rememberForever('setting_manual_approval_mode', function () {
            return \App\Models\SystemSetting::where('key', 'manual_approval_mode')->first()->value ?? 'true';
        });
        $isManual = filter_var($manualApproval, FILTER_VALIDATE_BOOLEAN);
        if ($isManual) {
            $data['add_status'] = 'Pending';
            $data['admin_approved'] = false;
        } else {
            $data['add_status'] = 'Valid';
            $data['admin_approved'] = true;
        }
        $rank = $this->getNextRank(RealEstateAd::class);
        $data['rank'] = $rank;
        $ad = RealEstateAd::create($data);
        return response()->json($ad, 201);
    }

    /**
     * PUT/PATCH /real-estates/{id}
     */
    public function update(Request $request, RealEstateAd $realEstateAd)
    {
        if ($request->user()->id !== $realEstateAd->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'emirate' => 'sometimes|required|string|max:100',
            'district' => 'sometimes|nullable|string|max:100',
            'area' => 'sometimes|nullable|string|max:150',
            'price' => 'sometimes|required|numeric|min:0',
            'contract_type' => 'sometimes|nullable|string|max:50',
            'property_type' => 'sometimes|nullable|string|max:50',
            'advertiser_name' => 'sometimes|required|string|max:255',
            'phone_number' => 'sometimes|nullable|string|max:20',
            'whatsapp_number' => 'sometimes|nullable|string|max:20',
            'address' => 'sometimes|nullable|string|max:500',
            'main_image' => 'sometimes|image|max:5120',
            'thumbnail_images.*' => 'sometimes|image|max:5120',
            // Plan
            'plan_type' => 'sometimes|nullable|string|max:50',
            'plan_days' => 'sometimes|nullable|integer|min:0',
            'plan_expires_at' => 'sometimes|nullable|date',
        ]);

        $updateFields = $request->except(['main_image', 'thumbnail_images']);
        if ($request->has('plan_days') && !$request->filled('plan_expires_at')) {
            $updateFields['plan_expires_at'] = now()->addDays((int) $request->plan_days);
        }
        $realEstateAd->update($updateFields);

        $updateData = [];
        if ($request->hasFile('main_image')) {
            Storage::disk('public')->delete($realEstateAd->main_image);
            $updateData['main_image'] = $request->file('main_image')->store('real_estates/main', 'public');
        }
        if ($request->hasFile('thumbnail_images')) {
            if (is_array($realEstateAd->thumbnail_images)) {
                Storage::disk('public')->delete($realEstateAd->thumbnail_images);
            }
            $thumbs = [];
            foreach ($request->file('thumbnail_images') as $file) {
                $thumbs[] = $file->store('real_estates/thumbnails', 'public');
            }
            $updateData['thumbnail_images'] = $thumbs;
        }
        if (!empty($updateData)) {
            $realEstateAd->update($updateData);
        }

        return response()->json($realEstateAd->fresh());
    }

    /**
     * DELETE /real-estates/{id}
     */
    public function destroy(Request $request, RealEstateAd $realEstateAd)
    {
        if ($request->user()->id !== $realEstateAd->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        Storage::disk('public')->delete($realEstateAd->main_image);
        if (is_array($realEstateAd->thumbnail_images)) {
            Storage::disk('public')->delete($realEstateAd->thumbnail_images);
        }

        $realEstateAd->delete();
        return response()->json(['message' => 'Ad deleted successfully.'], 204);
    }

    public function approveAd(RealEstateAd $realEstateAd)
    {
        $realEstateAd->update([
            'add_status' => 'Valid',
            'admin_approved' => true,
        ]);

        return response()->json([
            'message' => 'Ad approved successfully.',
            'ad' => $realEstateAd
        ]);
    }

    public function offersBoxAds(Request $request)
    {
        $query = RealEstateAd::active()->inOffersBox();

        $query->when($request->query('emirate'), fn($q, $v) => $q->byEmirate($v));
        $query->when($request->query('district'), fn($q, $v) => $q->byDistrict($v));
        $query->when($request->query('area'), fn($q, $v) => $q->byArea($v));
        $query->when($request->query('contract_type'), fn($q, $v) => $q->byContractType($v));
        $query->when($request->query('property_type'), fn($q, $v) => $q->byPropertyType($v));

        $query->when($request->filled('price_min') || $request->filled('price_max'), function ($q) use ($request) {
            $q->byPriceRange($request->price_min, $request->price_max);
        });

        $sort = $request->query('sort', 'latest');
        if ($sort === 'most_viewed') {
            $query->mostViewed();
        } elseif ($sort === 'rank') {
            $query->byRank();
        } else {
            $query->latest();
        }

        $limit = (int) $request->query('limit', 10);

        $ads = $query->limit($limit)->get();

        return response()->json($ads);
    }
}
