<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\electronicAd;
use App\Models\SystemSetting;
use App\Traits\HasRank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ElectronicAdController extends Controller
{
    use HasRank;
    public function index(Request $request)
    {
        $query = electronicAd::active();

        // Smart filters - support multiple values
        $query->when($request->query('emirate'), function ($q, $emirate) {
            return $q->filterByEmirate($emirate);
        });

        $query->when($request->query('district'), function ($q, $district) {
            return $q->filterByDistrict($district);
        });

        $query->when($request->query('section_type'), function ($q, $sectionType) {
            return $q->filterBySectionType($sectionType);
        });


        $query->when($request->query('brand'), function ($q, $brand) {
            return $q->filterByBrand($brand);
        });

        $query->when($request->query('warranty'), function ($q, $warranty) {
            return $q->filterByWarranty($warranty);
        });

        $query->when($request->query('product_name'), function ($q, $productName) {
            return $q->filterByProductName($productName);
        });
        // Price range filter
        $query->when($request->query('min_price') || $request->query('max_price'), function ($q) use ($request) {
            return $q->filterByPriceRange($request->query('min_price'), $request->query('max_price'));
        });

        // Keyword search in title, description, product_name, brand, section_type
        $query->when($request->query('keyword'), function ($q, $keyword) {
            return $q->where(function ($subQuery) use ($keyword) {
                $subQuery->where('title', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%")
                    ->orWhere('product_name', 'like', "%{$keyword}%")
                    ->orWhere('brand', 'like', "%{$keyword}%")
                    ->orWhere('section_type', 'like', "%{$keyword}%");
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
     * Smart search endpoint for electronics.
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
            'section_type' => 'nullable|string|max:500',
            'brand' => 'nullable|string|max:500',
            'product_name' => 'nullable|string|max:255',
            'warranty' => 'nullable|boolean',
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|min:0',
            'keyword' => 'nullable|string|max:255',
            'sort_by' => 'nullable|in:latest,most_viewed,rank,price_low,price_high',
            'per_page' => 'nullable|integer|min:1|max:50',
            'in_offers_box' => 'nullable|boolean',
        ]);

        return $this->index($request);
    }

    /**
     * Get electronics ads for offers box.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOffersBoxAds(Request $request)
    {
        // Start with offer box query
        $query = electronicAd::active()->offerBoxOnly();

        // Apply smart filters
        $query->when($request->query('section_type'), function ($q, $section) {
            return $q->filterBySectionType($section);
        });

        $query->when($request->query('brand'), function ($q, $brand) {
            return $q->filterByBrand($brand);
        });

        $query->when($request->query('warranty'), function ($q, $warranty) {
            return $q->filterByWarranty($warranty);
        });

        $query->when($request->query('product_name'), function ($q, $name) {
            return $q->filterByProductName($name);
        });
        $query->when($request->query('district'), function ($q, $district) {
            return $q->filterByDistrict($district);
        });
        $query->when($request->query('emirate'), function ($q, $emirate) {
            return $q->filterByEmirate($emirate);
        });

        $query->when($request->query('min_price') || $request->query('max_price'), function ($q) use ($request) {
            return $q->filterByPriceRange($request->query('min_price'), $request->query('max_price'));
        });

        $query->when($request->query('keyword'), function ($q, $keyword) {
            return $q->where(function ($subQuery) use ($keyword) {
                $subQuery->where('title', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%")
                    ->orWhere('product_name', 'like', "%{$keyword}%")
                    ->orWhere('brand', 'like', "%{$keyword}%")
                    ->orWhere('section_type', 'like', "%{$keyword}%");
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

        // Pagination
        $perPage = $request->query('per_page', 15);
        $perPage = min(max($perPage, 1), 50);

        return response()->json($query->paginate($perPage)->withQueryString());
    }


    /**
     * Display the specified electronic ad.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $ad = electronicAd::active()->findOrFail($id);
            $ad->incrementViews();
            return response()->json($ad);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Electronic ad not found'], 404);
        }
    }

    /**
     * Store a newly created electronic ad in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'emirate' => 'required|string|max:100',
            'district' => 'nullable|string|max:100',
            'area' => 'nullable|string|max:150',
            'address' => 'nullable|string|max:500',

            // Product
            'product_name' => 'required|string|max:255',
            'section_type' => 'required|string|max:100',
            'brand' => 'nullable|string|max:100',
            'warranty' => 'nullable|boolean',
            'price' => 'required|numeric|min:0',

            // Advertiser
            'advertiser_name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'whatsapp_number' => 'nullable|string|max:20',

            // Images
            'main_image' => 'required|image|max:5120',
            'thumbnail_images.*' => 'image|max:5120',

            // Plan
            'plan_type' => 'nullable|string|max:50',
            'plan_days' => 'nullable|integer|min:0',
            'plan_expires_at' => 'nullable|date',
        ]);

        $data = $validated;
        $data['user_id'] = $request->user()->id;
        $data['add_category'] = 'Electronics';

        // Upload images
        $data['main_image'] = $request->file('main_image')->store('electronics/main', 'public');
        $thumbs = [];
        if ($request->hasFile('thumbnail_images')) {
            foreach ($request->file('thumbnail_images') as $file) {
                $thumbs[] = $file->store('electronics/thumbnails', 'public');
            }
        }
        $data['thumbnail_images'] = $thumbs;

        // Plan
        if ($request->has('plan_days') && !$request->filled('plan_expires_at')) {
            $data['plan_expires_at'] = now()->addDays((int) $request->plan_days);
        }

        // Manual approval check
        $manualApproval = cache()->rememberForever('setting_manual_approval_mode', function () {
            return \App\Models\SystemSetting::where('key', 'manual_approval_mode')->value('value') ?? 'true';
        });
        $isManual = filter_var($manualApproval, FILTER_VALIDATE_BOOLEAN);

        if ($isManual) {
            $data['add_status'] = 'Pending';
            $data['admin_approved'] = false;
        } else {
            $data['add_status'] = 'Valid';
            $data['admin_approved'] = true;
        }
        $rank = $this->getNextRank(electronicAd::class);
        $data['rank'] = $rank;

        $ad = electronicAd::create($data);
        return response()->json($ad, 201);
    }


    /**
     * Update the specified electronic ad in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, electronicAd $electronicAd)
    {
        if ($request->user()->id !== $electronicAd->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'emirate' => 'sometimes|required|string|max:100',
            'district' => 'sometimes|nullable|string|max:100',
            'section_type' => 'sometimes|required|string|max:100',
            'product_name' => 'sometimes|required|string|max:255',
            'brand' => 'sometimes|nullable|string|max:100',
            'warranty' => 'sometimes|nullable|boolean',
            'price' => 'sometimes|required|numeric|min:0',
            'rank' => 'nullable|integer|min:0|max:100',
            'main_image' => 'sometimes|image|max:5120',
            'thumbnail_images.*' => 'sometimes|image|max:5120',

            'plan_type' => 'sometimes|nullable|string|max:50',
            'plan_days' => 'sometimes|nullable|integer|min:0',
            'plan_expires_at' => 'sometimes|nullable|date',
        ]);

        // prepare update fields
        $updateFields = $request->except(['main_image', 'thumbnail_images']);
        if ($request->has('plan_days') && !$request->filled('plan_expires_at')) {
            $updateFields['plan_expires_at'] = now()->addDays((int) $request->plan_days);
        }
        $electronicAd->update($updateFields);

        // handle images
        $updateData = [];
        if ($request->hasFile('main_image')) {
            if ($electronicAd->main_image) {
                Storage::disk('public')->delete($electronicAd->main_image);
            }
            $updateData['main_image'] = $request->file('main_image')->store('electronics/main', 'public');
        }

        if ($request->hasFile('thumbnail_images')) {
            if (is_array($electronicAd->thumbnail_images)) {
                Storage::disk('public')->delete($electronicAd->thumbnail_images);
            }
            $thumbs = [];
            foreach ($request->file('thumbnail_images') as $file) {
                $thumbs[] = $file->store('electronics/thumbnails', 'public');
            }
            $updateData['thumbnail_images'] = $thumbs;
        }

        if (!empty($updateData)) {
            $electronicAd->update($updateData);
        }

        return response()->json($electronicAd->fresh());
    }


    /**
     * Remove the specified electronic ad from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, electronicAd $electronicAd)
    {
        if ($request->user()->id !== $electronicAd->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        Storage::disk('public')->delete($electronicAd->main_image);
        if (is_array($electronicAd->thumbnail_images)) {
            Storage::disk('public')->delete($electronicAd->thumbnail_images);
        }

        $electronicAd->delete();
        return response()->json(['message' => 'Ad deleted successfully.'], 204);
    }

    public function approveAd(electronicAd $electronic)
    {
        $electronic->update([
            'add_status' => 'Valid',
            'admin_approved' => true,
        ]);

        return response()->json([
            'message' => 'Ad approved successfully.',
            'ad' => $electronic
        ]);
    }

    /**
     * Get all electronic ads for admin (including pending ones).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    // public function indexForAdmin(Request $request)
    // {
    //     $query = electronicAd::query();

    //     // Filter by status
    //     $query->when($request->query('status'), function ($q, $status) {
    //         switch ($status) {
    //             case 'pending':
    //                 return $q->where('add_status', 'Pending')->where('admin_approved', false);
    //             case 'approved':
    //                 return $q->where('add_status', 'Valid')->where('admin_approved', true);
    //             case 'rejected':
    //                 return $q->where('add_status', 'Rejected');
    //             default:
    //                 return $q;
    //         }
    //     });

    //     // Smart filters
    //     $query->when($request->query('emirate'), function ($q, $emirate) {
    //         return $q->filterByEmirate($emirate);
    //     });

    //     $query->when($request->query('district'), function ($q, $district) {
    //         return $q->filterByDistrict($district);
    //     });

    //     $query->when($request->query('section_type'), function ($q, $sectionType) {
    //         return $q->filterBySectionType($sectionType);
    //     });

    //     $query->when($request->query('brand'), function ($q, $brand) {
    //         return $q->filterByBrand($brand);
    //     });

    //     // Keyword search
    //     $query->when($request->query('keyword'), function ($q, $keyword) {
    //         return $q->where(function ($subQuery) use ($keyword) {
    //             $subQuery->where('title', 'like', "%{$keyword}%")
    //                 ->orWhere('description', 'like', "%{$keyword}%")
    //                 ->orWhere('product_name', 'like', "%{$keyword}%")
    //                 ->orWhere('brand', 'like', "%{$keyword}%");
    //         });
    //     });

    //     // Sorting
    //     $sortBy = $request->query('sort_by', 'latest');
    //     switch ($sortBy) {
    //         case 'most_viewed':
    //             $query->mostViewed();
    //             break;
    //         case 'rank':
    //             $query->byRank();
    //             break;
    //         case 'latest':
    //         default:
    //             $query->latest();
    //             break;
    //     }

    //     $perPage = $request->query('per_page', 15);
    //     $perPage = min(max($perPage, 1), 50);

    //     return response()->json($query->paginate($perPage)->withQueryString());
    // }

    /**
     * Get pending electronic ads for admin approval.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    // public function getPendingAds(Request $request)
    // {
    //     $query = electronicAd::where('add_status', 'Pending')
    //         ->where('admin_approved', false);

    //     $perPage = $request->query('per_page', 15);
    //     $perPage = min(max($perPage, 1), 50);

    //     return response()->json($query->latest()->paginate($perPage));
    // }

    /**
     * Approve a pending electronic ad.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */


    /**
     * Reject a pending electronic ad.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    // public function rejectAd($id)
    // {
    //     try {
    //         $ad = electronicAd::where('add_status', 'Pending')->findOrFail($id);

    //         $ad->update([
    //             'add_status' => 'Rejected',
    //             'admin_approved' => false,
    //         ]);

    //         return response()->json(['message' => 'Electronic ad rejected successfully', 'ad' => $ad]);
    //     } catch (ModelNotFoundException $e) {
    //         return response()->json(['message' => 'Pending electronic ad not found'], 404);
    //     }
    // }
}