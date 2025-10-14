<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobAd;
// use App\Models\JopAD;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class JobsAdController extends Controller
{
    //
    public function index(Request $request)
    {
        $query = JobAd::query()
            ->where('add_status', 'Valid')
            ->where('admin_approved', true);

        // Smart Filters (Support multiple values)
        $query->when($request->query('emirate'), fn($q, $v) => $q->filterByEmirate($v));
        $query->when($request->query('district'), fn($q, $v) => $q->filterByDistrict($v));
        $query->when($request->query('category_type'), fn($q, $v) => $q->filterByCategoryType($v));
        $query->when($request->query('section_type'), fn($q, $v) => $q->filterBySectionType($v));
        $query->when($request->query('keyword'), fn($q, $v) => $q->keywordSearch($v));
        $query->when($request->query('offers_box_only'), fn($q, $v) => $v ? $q->inOffersBox() : null);

        // // Legacy Filters (Backward compatibility)
        // $query->when($request->query('emirate_legacy'), fn($q, $v) => $q->byEmirate($v));
        // $query->when($request->query('district_legacy'), fn($q, $v) => $q->byDistrict($v));
        // $query->when($request->query('category_type_legacy'), fn($q, $v) => $q->byCategoryType($v));
        // $query->when($request->query('section_type_legacy'), fn($q, $v) => $q->bySectionType($v));

        // Sorting options (latest, most_viewed, rank)
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
                $query->latest();
                break;
        }

        $perPage = (int) ($request->query('per_page', 15));
        return response()->json($query->get());
    }

    /**
     * GET /jobs/search - Smart search with multiple filters
     */
    // public function search(Request $request)
    // {
    //     $query = JobAd::query()
    //         ->where('add_status', 'Valid')
    //         ->where('admin_approved', true);

    //     // Smart Filters (Support multiple values)
    //     $query->when($request->query('emirate'), fn($q, $v) => $q->filterByEmirate($v));
    //     $query->when($request->query('district'), fn($q, $v) => $q->filterByDistrict($v));
    //     $query->when($request->query('category_type'), fn($q, $v) => $q->filterByCategoryType($v));
    //     $query->when($request->query('section_type'), fn($q, $v) => $q->filterBySectionType($v));
    //     $query->when($request->query('keyword'), fn($q, $v) => $q->keywordSearch($v));
    //     $query->when($request->query('offers_box_only'), fn($q, $v) => $v ? $q->offerBoxOnly() : null);

    //     // Sorting options (latest, most_viewed, rank)
    //     $sort = $request->query('sort', 'latest');
    //     if ($sort === 'most_viewed') $query->mostViewed();
    //     elseif ($sort === 'rank') $query->byRank();
    //     else $query->latest();

    //     $perPage = (int) ($request->query('per_page', 15));
    //     return response()->json($query->paginate($perPage));
    // }

    /**
     * GET /jobs/offers-box/ads - Get active offers box ads
     */
    public function getOffersBoxAds(Request $request)
    {
        $query = JobAd::query()
            ->where('add_status', 'Valid')
            ->where('admin_approved', true)
            ->inOffersBox();

        $query->when($request->query('emirate'), fn($q, $v) => $q->filterByEmirate($v));
        $query->when($request->query('district'), fn($q, $v) => $q->filterByDistrict($v));
        $query->when($request->query('category_type'), fn($q, $v) => $q->filterByCategoryType($v));
        $query->when($request->query('section_type'), fn($q, $v) => $q->filterBySectionType($v));
        $query->when($request->query('keyword'), fn($q, $v) => $q->keywordSearch($v));

        // Sorting options
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

    /**
     * GET /jobs/{id} - Public show and increment views
     */
    public function show(JobAd $jobAd)
    {
        try {
            $jobAd->incrementViews();
            return response()->json($jobAd);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => ' this Ad not found'
            ], 404);
        }
    }

    /**
     * POST /jobs - Create (Auth required)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'emirate' => 'required|string|max:100',
            'district' => 'nullable|string|max:100',
            'category_type' => 'required|string|max:100',
            'section_type' => 'required|string|max:100',
            'job_name' => 'required|string|max:100',
            'salary' => 'nullable|string|max:100',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'contact_info' => 'nullable|string',
            // 'main_image' => 'nullable|image|max:5120',
            'advertiser_name' => 'nullable|string|max:255',
            // 'phone_number' => 'nullable|string|max:20',
            // 'whatsapp' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            // Plan
            'plan_type' => 'nullable|string|max:50',
            'plan_days' => 'nullable|integer|min:0',
            'plan_expires_at' => 'nullable|date',


        ]);

        $data = $validated;
        $data['user_id'] = $request->user()->id;
        $data['add_category'] = 'Jop';

        // Upload main image
        // $data['main_image'] = $request->file('main_image')->store('jobs/main', 'public');
        // Plan
        if ($request->has('plan_days') && !$request->filled('plan_expires_at')) {
            $data['plan_expires_at'] = now()->addDays((int) $request->plan_days);
        }

        // Manual approval setting (reuse SystemSetting key manual_approval_mode)
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

        $ad = JobAd::create($data);
        return response()->json($ad, 201);
    }

    /**
     * PUT/PATCH /jobs/{id} - Update (Auth required)
     */
    public function update(Request $request, JobAd $jobAd)
    {
        if ($request->user()->id !== $jobAd->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // 2. Validation
        $validated = $request->validate([
            'emirate'         => 'sometimes|required|string|max:100',
            'district'        => 'sometimes|nullable|string|max:100',
            'category_type'   => 'sometimes|required|string|max:100',
            'section_type'    => 'sometimes|required|string|max:100',
            'job_name'        => 'sometimes|required|string|max:255',
            'salary'          => 'sometimes|nullable|string|max:100',
            'title'           => 'sometimes|required|string|max:255',
            'description'     => 'sometimes|nullable|string',
            'advertiser_name' => 'sometimes|nullable|string|max:255',
            'phone_number'    => 'sometimes|required|string|max:20',
            'whatsapp'        => 'sometimes|nullable|string|max:20',
            'address'         => 'sometimes|nullable|string|max:500',
            'main_image'      => 'sometimes|image|max:5120',
            // Plan
            'plan_type'       => 'sometimes|nullable|string|max:50',
            'plan_days'       => 'sometimes|nullable|integer|min:0',
            'plan_expires_at' => 'sometimes|nullable|date',
        ]);


        $updateFields = $request->except(['main_image']);
        if ($request->has('plan_days') && !$request->filled('plan_expires_at')) {
            $updateFields['plan_expires_at'] = now()->addDays((int) $request->plan_days);
        }

        $jobAd->update($updateFields);
        $updateData = [];
        if ($request->hasFile('main_image')) {


            if ($jobAd->main_image) {
                Storage::disk('public')->delete($jobAd->main_image);
            }

            $updateData['main_image'] = $request->file('main_image')->store('jobs/main', 'public');
            // return response()->json([  'message'=>'secss' ]);
        }

        if (!empty($updateData)) {
            $jobAd->update($updateData);
        }

        return response()->json($jobAd->fresh());
    }


    /**
     * DELETE /jobs/{id} - Destroy (Auth required)
     */
    public function destroy(Request $request, JobAd $jobAd)
    {
        if ($request->user()->id !== $jobAd->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        Storage::disk('public')->delete($jobAd->main_image);
        $jobAd->delete();

        return response()->json(['message' => 'Ad deleted successfully.'], 204);
    }

    public function approveAd(JobAd $jobAd)
    {
        $jobAd->update([
            'add_status' => 'Valid',
            'admin_approved' => true,
        ]);

        return response()->json([
            'message' => 'Ad approved successfully.',
            'ad' => $jobAd
        ]);
    }


    //get two image for jop offer and jop seeker
    public function getCategoryImages()
    {
        $settings = DB::table('system_settings')
            ->whereIn('key', ['job_offer_main_image', 'job_seeker_main_image'])
            ->get()
            ->keyBy('key');

        $data = [
            'job_offer' => [
                'category' => 'Job Offer',
                'image'    => $settings['job_offer_main_image']->value ?? null,
            ],
            'job_seeker' => [
                'category' => 'Job Seeker',
                'image'    => $settings['job_seeker_main_image']->value ?? null,
            ],
        ];

        return response()->json([
            'success' => true,
            'data'    => $data,
        ]);
    }
}
