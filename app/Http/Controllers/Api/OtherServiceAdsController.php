<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\HasRank;
use Illuminate\Http\Request;
use App\Models\OtherServiceAds;
use App\Models\SystemSetting;
use App\Traits\PackageHelper;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OtherServiceAdsController extends Controller
{
    //

    use HasRank, PackageHelper;
    public function index(Request $request)
    {
        $query = OtherServiceAds::active();

        // === Smart filters with multi-search ===
        $query->when($request->query('emirate'), fn($q, $v) => $q->filterByEmirate($v));
        $query->when($request->query('district'), fn($q, $v) => $q->filterByDistrict($v));
        $query->when($request->query('area'), fn($q, $v) => $q->filterByArea($v));
        $query->when($request->query('section_type'), fn($q, $v) => $q->filterBySectionType($v));
        $query->when($request->query('service_name'), fn($q, $v) => $q->filterByServiceName($v));

        // Price range filter
        $query->when(
            $request->query('min_price') || $request->query('max_price'),
            fn($q) => $q->filterByPriceRange($request->query('min_price'), $request->query('max_price'))
        );

        // Keyword search in title, description, service_name
        $query->when($request->query('keyword'), function ($q, $keyword) {
            $q->where(function ($subQuery) use ($keyword) {
                $subQuery->where('title', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%")
                    ->orWhere('service_name', 'like', "%{$keyword}%");
            });
        });

        // Sorting options
        match ($request->query('sort_by', 'latest')) {
            'most_viewed' => $query->mostViewed(),
            'rank' => $query->byRank(),
            'price_low' => $query->orderBy('price', 'asc'),
            'price_high' => $query->orderBy('price', 'desc'),
            default => $query->orderedByRank(),
        };

        // In offers box filter
        if ($request->boolean('in_offers_box')) {
            $query->inOffersBox();
        }

        $perPage = min(max((int) $request->query('per_page', 15), 1), 50);

        return response()->json(
            $query->get()
        );
    }


    public function getOffersBoxAds(Request $request)
    {
        // Start with offer box query
        $query = OtherServiceAds::active()->offerBoxOnly();

        // === Smart filters with multi-search ===
        $query->when($request->query('emirate'), fn($q, $v) => $q->filterByEmirate($v));
        $query->when($request->query('district'), fn($q, $v) => $q->filterByDistrict($v));
        $query->when($request->query('area'), fn($q, $v) => $q->filterByArea($v));
        $query->when($request->query('section_type'), fn($q, $v) => $q->filterBySectionType($v));
        $query->when($request->query('service_name'), fn($q, $v) => $q->filterByServiceName($v));

        // Price range filter
        $query->when(
            $request->query('min_price') || $request->query('max_price'),
            fn($q) => $q->filterByPriceRange($request->query('min_price'), $request->query('max_price'))
        );

        // Keyword search in title, description, service_name
        $query->when($request->query('keyword'), function ($q, $keyword) {
            $q->where(function ($subQuery) use ($keyword) {
                $subQuery->where('title', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%")
                    ->orWhere('service_name', 'like', "%{$keyword}%");
            });
        });

        // Sorting options
        match ($request->query('sort_by', 'latest')) {
            'most_viewed' => $query->mostViewed(),
            'rank' => $query->byRank(),
            'price_low' => $query->orderBy('price', 'asc'),
            'price_high' => $query->orderBy('price', 'desc'),
            default => $query->orderedByRank(),
        };

        // Return all results (no pagination)
        return response()->json(
            $query->get()
        );
    }


    /**
     * GET /other-services/{id}
     */
    public function show($id)
    {
        try {
            $ad = OtherServiceAds::findOrFail($id);
            $ad->incrementViews();

            return response()->json($ad);
        } catch (ModelNotFoundException) {
            return response()->json(['message' => 'Ad not found'], 404);
        }
    }

    /**
     * POST /other-services - Create new ad
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'emirate' => 'required|string|max:100',
            'district' => 'nullable|string|max:100',
            'area' => 'nullable|string|max:150',
            'service_name' => 'required|string|max:150',
            'section_type' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'advertiser_name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'whatsapp_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'main_image' => 'required|image|max:5120',
            // Plan
            'plan_type' => 'nullable|string|max:50|in:featured,premium_star,premium,free',
            // 'plan_days' => 'nullable|integer|min:0',
            // 'plan_expires_at' => 'nullable|date',
            'payment' => 'nullable|boolean',
        ]);

        $user = $request->user();
        $data = $validated;
        $data['user_id'] = $user->id;
        $data['add_category'] = 'Other Services';


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

            $userFreeAdsCount = OtherServiceAds::where('user_id', $user->id)
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


        $data['main_image'] = $request->file('main_image')->store('other_services/main', 'public');


        $manualApproval = cache()->rememberForever(
            'setting_manual_approval_mode',
            fn() =>
            SystemSetting::where('key', 'manual_approval_mode')->value('value') ?? 'true'
        );

        $data['add_status'] = filter_var($manualApproval, FILTER_VALIDATE_BOOLEAN) ? 'Pending' : 'Valid';
        $data['admin_approved'] = $data['add_status'] === 'Valid';


        $rank = $this->getNextRank(OtherServiceAds::class);
        $data['rank'] = $rank;


        $ad = OtherServiceAds::create($data);

        return response()->json($ad, 201);
    }


    /**
     * PUT/PATCH /other-services/{id}
     */
    public function update(Request $request, OtherServiceAds $ad)
    {
        if ($request->user()->id !== $ad->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'emirate' => 'sometimes|required|string|max:100',
            'district' => 'nullable|string|max:100',
            'area' => 'nullable|string|max:150',
            'service_name' => 'sometimes|required|string|max:150',
            'section_type' => 'sometimes|required|string|max:50',
            'price' => 'sometimes|required|numeric|min:0',
            'advertiser_name' => 'sometimes|required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'whatsapp_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'main_image' => 'nullable|image|max:5120',
            // // Plan
            // 'plan_type' => 'nullable|string|max:50',
            // 'plan_days' => 'nullable|integer|min:0',
            // 'plan_expires_at' => 'nullable|date',
            'payment' => 'sometimes|nullable|boolean',
        ]);
        $updateData = $validated;

        // // Plan expiry
        // if ($request->has('plan_days') && !$request->filled('plan_expires_at')) {
        //     $updateData['plan_expires_at'] = now()->addDays((int) $request->plan_days);
        // }

        // Images
        if ($request->hasFile('main_image')) {
            if ($ad->main_image) {
                Storage::disk('public')->delete($ad->main_image);
            }
            $updateData['main_image'] = $request->file('main_image')->store('other_services/main', 'public');
        }


        $ad->update($updateData);

        return response()->json($ad->fresh());
    }

    /**
     * DELETE /other-services/{id}
     */
    public function destroy(Request $request, OtherServiceAds $ad)
    {
        if ($request->user()->id !== $ad->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        Storage::disk('public')->delete($ad->main_image);
        $ad->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Ad deleted successfully.'
        ], 200);
    }

    /**
     * Admin approve Ad
     */
    public function approveAd(Request $request, OtherServiceAds $ad)
    {
        if ($request->user()->id !== $ad->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $ad->update([
            'add_status' => 'Valid',
            'admin_approved' => true,
        ]);

        return response()->json([
            'message' => 'Ad approved successfully.',
            'ad' => $ad
        ]);
    }
}
