<?php

namespace App\Http\Controllers;

use App\Models\CarRentAd;
use App\Models\CarSalesAd;
use App\Models\CarServicesAd;
use App\Models\electronicAd;
use App\Models\Favorite;
use App\Models\JobAd;
use App\Models\OtherServiceAds;
use App\Models\RealEstateAd;
use App\Models\RestaurantAd;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class FavoritesController extends Controller
{
    //
    public function index(User $user)
{
    $favorites = Favorite::where('user_id', $user->id)->get();

    $modelMap = [
        'Real State' => RealEstateAd::class,
        'Cars Sales' => CarSalesAd::class,
        'Car Rent' => CarRentAd::class,
        'Car Services	' => CarServicesAd::class,
        'restaurant' => RestaurantAd::class,
        'Jop' => JobAd::class,
        'Electronics' => electronicAd::class,
        'Other Services' => OtherServiceAds::class,
    ];

    $groupedFavorites = [];

    foreach ($favorites as $fav) {
        if (!isset($modelMap[$fav->category_slug])) {
            continue;
        }

        $modelClass = $modelMap[$fav->category_slug];
        $ad = $modelClass::find($fav->ad_id);

        if (!$ad) {
            continue;
        }

        $groupedFavorites[$fav->category_slug][] = [
            'favorite_id' => $fav->id,
            'category_slug' => $fav->category_slug, // ✅ أضفنا السطر ده
            'ad' => $ad,
        ];
    }

    return response()->json([
        'status' => true,
        'data' => $groupedFavorites,
    ]);
}



    public function store(Request $request)
    {
        $validated = $request->validate([
            'ad_id' => 'required|integer',
            'category_slug' => 'required|string|max:255',
            'user_id' => 'required|integer|exists:users,id',
        ]);



        $modelMap = [
            'Real State' => RealEstateAd::class,
            'Cars Sales' => CarSalesAd::class,
            'Car Rent' => CarRentAd::class,
            'Car Services	' => CarServicesAd::class,
            'restaurant' => RestaurantAd::class,
            'Jop' => JobAd::class,
            'Electronics' => electronicAd::class,
            'Other Services' => OtherServiceAds::class,
        ];

        if (!array_key_exists($validated['category_slug'], $modelMap)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid category slug.',
            ], 400);
        }

        $modelClass = $modelMap[$validated['category_slug']];
        $adExists = $modelClass::find($validated['ad_id']);

        if (!$adExists) {
            return response()->json([
                'status' => false,
                'message' => 'Ad not found.',
            ], 404);
        }

        $exists = Favorite::where('user_id', $validated['user_id'])
            ->where('ad_id', $validated['ad_id'])
            ->where('category_slug', $validated['category_slug'])
            ->exists();

        if ($exists) {
            return response()->json([
                'status' => false,
                'message' => 'This ad is already in your favorites.',
            ], 409);
        }


        $favorite = Favorite::create([
            'user_id' => $validated['user_id'],
            'ad_id' => $validated['ad_id'],
            'category_slug' => $validated['category_slug'],
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Ad added to favorites successfully.',
            'data' => $favorite,
        ], 201);
    }



    public function destroy(Request $request, User $user)
    {
        $validated = $request->validate([
            'ad_id' => 'required|integer',
            'category_slug' => 'required|string|max:255',
        ]);

        $deleted = Favorite::where('user_id', $user->id)
            ->where('ad_id', $validated['ad_id'])
            ->where('category_slug', $validated['category_slug'])
            ->delete();

        if ($deleted) {
            return response()->json([
                'status' => true,
                'message' => 'Ad removed from favorites successfully.',
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Favorite not found.',
        ], 404);
    }
}
