<?php

namespace App\Http\Controllers;

use App\Models\{
    RealEstateAd,
    CarSalesAd,
    CarRentAd,
    CarServicesAd,
    RestaurantAd,
    JobAd,
    electronicAd,
    OtherServiceAds
};
use Illuminate\Http\Request;
use App\Traits\HasRank;
use Illuminate\Support\Facades\Cache;



class SetRankOneController extends Controller
{

    use HasRank {
        makeRankOne as traitMakeRankOne;
    }
    public function makeRankOne(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|string',
            'ad_id' => 'required|integer',
        ]);

        $user = $request->user();
        $category = $validated['category'];
        $adId = $validated['ad_id'];

        $modelMap = [
            'Real State' => RealEstateAd::class,
            'Cars Sales' => CarSalesAd::class,
            'Car Rent' => CarRentAd::class,
            'Car Services' => CarServicesAd::class,
            'restaurant' => RestaurantAd::class,
            'Jop' => JobAd::class,
            'Electronics' => electronicAd::class,
            'Other Services' => OtherServiceAds::class,
        ];

        if (!array_key_exists($validated['category'], $modelMap)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid category ',
            ], 400);
        }

        // if (!isset($map[$category])) {
        //     return response()->json(['error' => 'Invalid category'], 400);
        // }

        $modelClass = $modelMap[$category];
        $ad = $modelClass::find($adId);

        if (!$ad) {
            return response()->json(['error' => 'Ad not found'], 404);
        }

        if ($ad->user_id !== $user->id) {
            return response()->json(['error' => 'You can only update rank for your own ads'], 403);
        }

        $cacheKey = "rank_one_lock_user_{$user->id}_category_{$ad->add_category}_ad_{$adId}";
        $cooldownHours = 24;

        if (Cache::has($cacheKey)) {
            $remainingSeconds = Cache::get($cacheKey) - now()->timestamp;
            $remainingHours = ceil($remainingSeconds / 3600);

            return response()->json([
                'error' => "You can only promote this ad to Rank 1 once every 24 hours. Please wait around {$remainingHours} hour(s)."
            ], 429);
        }

        $success = $this->traitMakeRankOne($modelClass, $adId);

        if (!$success) {
            return response()->json(['error' => 'Something went wrong while updating rank'], 500);
        }

        Cache::put(
            $cacheKey,
            now()->addHours($cooldownHours)->timestamp,
            now()->addHours($cooldownHours)
        );

        return response()->json([
            'success' => true,
            'message' => "Ad #{$adId} has been successfully promoted to Rank 1 in the {$category} category. You can do this again after 24 hours."
        ]);
    }



}
