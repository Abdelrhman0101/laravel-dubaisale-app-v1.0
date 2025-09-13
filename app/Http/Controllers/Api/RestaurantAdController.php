<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RestaurantAd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RestaurantAdController extends Controller
{
    /**
     * GET /restaurants - Public index with filters
     */
    public function index(Request $request)
    {
        $query = RestaurantAd::query()
            ->where('add_status', 'Valid')
            ->where('admin_approved', true);

        $query->when($request->query('emirate'), fn($q, $v) => $q->byEmirate($v));
        $query->when($request->query('district'), fn($q, $v) => $q->byDistrict($v));
        $query->when($request->query('area'), fn($q, $v) => $q->byArea($v));
        $query->when($request->query('price_range'), fn($q, $v) => $q->byPriceRange($v));
        $query->when($request->query('category'), fn($q, $v) => $q->byCategory($v));

        // Sorting options (optional): latest, most_viewed, rank
        $sort = $request->query('sort', 'latest');
        if ($sort === 'most_viewed') $query->mostViewed();
        elseif ($sort === 'rank') $query->byRank();
        else $query->latest();

        $perPage = (int) ($request->query('per_page', 15));
        return response()->json($query->paginate($perPage));
    }

    /**
     * GET /restaurants/{id} - Public show and increment views
     */
    public function show(RestaurantAd $restaurantAd)
    {
        $restaurantAd->incrementViews();
        return response()->json($restaurantAd);
    }

    /**
     * POST /restaurants - Create (Auth required)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'emirate' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'area' => 'nullable|string|max:100',
            'price_range' => 'required|string|max:100',
            'category' => 'nullable|string|max:100|exists:restaurant_categories,name',
            'main_image' => 'required|image|max:5120',
            'thumbnail_images.*' => 'image|max:5120',
            'advertiser_name' => 'required|string|max:255',
            'whatsapp_number' => 'required|string|max:20',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'required|string|max:500',
            // Plan fields
            'plan_type' => 'nullable|string|max:50',
            'plan_days' => 'nullable|integer|min:0',
            'plan_expires_at' => 'nullable|date',
        ]);

        $data = [
            'title' => $validated['title'],
            'description' => $validated['description'],
            'emirate' => $validated['emirate'],
            'district' => $validated['district'],
            'area' => $validated['area'] ?? null,
            'price_range' => $validated['price_range'],
            'category' => $validated['category'] ?? null,
            'advertiser_name' => $validated['advertiser_name'],
            'whatsapp_number' => $validated['whatsapp_number'],
            'phone_number' => $validated['phone_number'] ?? null,
            'address' => $validated['address'],
            'user_id' => $request->user()->id,
            'add_category' => 'Restaurants',
        ];

        // Upload main image
        $data['main_image'] = $request->file('main_image')->store('restaurants/main', 'public');

        // Upload thumbnails
        $thumbs = [];
        if ($request->hasFile('thumbnail_images')) {
            foreach ($request->file('thumbnail_images') as $file) {
                $thumbs[] = $file->store('restaurants/thumbnails', 'public');
            }
        }
        $data['thumbnail_images'] = $thumbs;

        // Plan handling
        if ($request->filled('plan_type')) $data['plan_type'] = $request->input('plan_type');
        if ($request->has('plan_days')) {
            $data['plan_days'] = (int) $request->input('plan_days');
            if (!$request->filled('plan_expires_at')) {
                $data['plan_expires_at'] = now()->addDays($data['plan_days']);
            }
        }
        if ($request->filled('plan_expires_at')) {
            $data['plan_expires_at'] = $request->input('plan_expires_at');
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

        $ad = RestaurantAd::create($data);
        return response()->json($ad, 201);
    }

    /**
     * PUT/PATCH /restaurants/{id} - Update (Auth required)
     */
    public function update(Request $request, RestaurantAd $restaurantAd)
    {
        if ($request->user()->id !== $restaurantAd->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'emirate' => 'sometimes|required|string|max:100',
            'district' => 'sometimes|required|string|max:100',
            'area' => 'sometimes|nullable|string|max:100',
            'price_range' => 'sometimes|required|string|max:100',
            'category' => 'sometimes|nullable|string|max:100|exists:restaurant_categories,name',
            'main_image' => 'sometimes|image|max:5120',
            'thumbnail_images.*' => 'sometimes|image|max:5120',
            'advertiser_name' => 'sometimes|required|string|max:255',
            'whatsapp_number' => 'sometimes|required|string|max:20',
            'phone_number' => 'sometimes|nullable|string|max:20',
            'address' => 'sometimes|required|string|max:500',
            // Plan fields
            'plan_type' => 'sometimes|nullable|string|max:50',
            'plan_days' => 'sometimes|nullable|integer|min:0',
            'plan_expires_at' => 'sometimes|nullable|date',
        ]);

        $updateFields = $request->except(['main_image', 'thumbnail_images']);

        if ($request->has('plan_days') && !$request->filled('plan_expires_at')) {
            $updateFields['plan_expires_at'] = now()->addDays((int) $request->input('plan_days'));
        }

        $restaurantAd->update($updateFields);

        $updateData = [];
        if ($request->hasFile('main_image')) {
            Storage::disk('public')->delete($restaurantAd->main_image);
            $updateData['main_image'] = $request->file('main_image')->store('restaurants/main', 'public');
        }
        if ($request->hasFile('thumbnail_images')) {
            if (is_array($restaurantAd->thumbnail_images)) {
                Storage::disk('public')->delete($restaurantAd->thumbnail_images);
            }
            $thumbs = [];
            foreach ($request->file('thumbnail_images') as $file) {
                $thumbs[] = $file->store('restaurants/thumbnails', 'public');
            }
            $updateData['thumbnail_images'] = $thumbs;
        }
        if (!empty($updateData)) {
            $restaurantAd->update($updateData);
        }

        return response()->json($restaurantAd->fresh());
    }

    /**
     * DELETE /restaurants/{id} - Destroy (Auth required)
     */
    public function destroy(Request $request, RestaurantAd $restaurantAd)
    {
        if ($request->user()->id !== $restaurantAd->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        Storage::disk('public')->delete($restaurantAd->main_image);
        if (is_array($restaurantAd->thumbnail_images)) {
            Storage::disk('public')->delete($restaurantAd->thumbnail_images);
        }

        $restaurantAd->delete();
        return response()->json(null, 204);
    }
}