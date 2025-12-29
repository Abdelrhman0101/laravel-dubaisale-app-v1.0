<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\electronicAd;
use App\Models\OtherServiceAds;
use App\Models\RealEstateAd;
use Illuminate\Http\Request;
use App\Models\CarSalesAd;
use App\Models\CarServicesAd;
use App\Models\RestaurantAd;
use App\Models\CarRentAd;
use App\Models\JobAd;
// في المستقبل، ستضيف الـ Models الأخرى هنا
// use App\Models\RealEstateAd;
// use App\Models\JobAd;
use Illuminate\Support\Collection;

class MyAdsController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // --- الخطوة 1: جلب الإعلانات من كل قسم ---
        $carAds = CarSalesAd::where('user_id', $user->id)->get();
        $carServicesAds = CarServicesAd::where('user_id', $user->id)->get();
        $restaurantAds = RestaurantAd::where('user_id', $user->id)->get();
        // $realEstateAds = RealEstateAd::where('user_id', $user->id)->get(); // للمستقبل
        // $jobAds = JobAd::where('user_id', $user->id)->get(); // للمستقبل
        $carRentAds = CarRentAd::where('user_id', $user->id)->get();
        //real-estates
        $realEstatesAds = RealEstateAd::where('user_id', $user->id)->get();
        //Jobs Ads
        $jobAds = JobAd::where('user_id', $user->id)->get();
        $electronic = electronicAd::where('user_id', $user->id)->get();
        $otherService = OtherServiceAds::where('user_id', $user->id)->get();

        // --- الخطوة 2: توحيد شكل البيانات لكل قسم ---
        $formattedCarAds = $carAds->map(function ($ad) {
            return [
                'id' => $ad->id,
                'title' => $ad->title,
                'make' => $ad->make,
                'model' => $ad->model,
                'trim' => $ad->trim,
                'year' => $ad->year,
                'plan_type' => $ad->plan_type,
                'main_image_url' => asset('storage/' . $ad->main_image),
                'views' => $ad->views,
                'price' => $ad->price,
                'status' => $ad->add_status,
                'category' => 'Cars Sales', // نوع القسم
                'category_slug' => 'car_sales', // إضافة category_slug
                'created_at' => $ad->created_at->toDateTimeString(),
                'created_at_timestamp' => $ad->created_at->timestamp,
                'expires_at' => $ad->expires_at,
            ];
        });

        $formattedCarServicesAds = $carServicesAds->map(function ($ad) {
            return [
                'id' => $ad->id,
                'title' => $ad->title,
                'service_type' => $ad->service_type,
                'service_name' => $ad->service_name,
                'emirate' => $ad->emirate,
                'district' => $ad->district,
                'area' => $ad->area,
                'plan_type' => $ad->plan_type,
                'main_image_url' => asset('storage/' . $ad->main_image),
                'views' => $ad->views,
                'price' => $ad->price,
                'status' => $ad->add_status,
                'category' => 'Car Services', // نوع القسم
                'category_slug' => 'car_services', // إضافة category_slug
                'created_at' => $ad->created_at->toDateTimeString(),
                'created_at_timestamp' => $ad->created_at->timestamp,
                'expires_at' => $ad->expires_at,
            ];
        });

        $formattedRestaurantAds = $restaurantAds->map(function ($ad) {
            return [
                'id' => $ad->id,
                'title' => $ad->title,
                'description' => $ad->description,
                'emirate' => $ad->emirate,
                'district' => $ad->district,
                'area' => $ad->area,
                // 'price_range' => $ad->price_range,
                'restaurant_category' => $ad->category,
                'plan_type' => $ad->plan_type,
                'main_image_url' => asset('storage/' . $ad->main_image),
                'views' => $ad->views,
                'price' => $ad->price_range,
                'status' => $ad->add_status,
                'category' => 'restaurant', // نوع القسم
                'category_slug' => 'restaurant', // إضافة category_slug
                'created_at' => $ad->created_at->toDateTimeString(),
                'created_at_timestamp' => $ad->created_at->timestamp,
                'expires_at' => $ad->expires_at,
            ];
        });

        $formattedCarRentAds = $carRentAds->map(function ($ad) {
            return [
                'id' => $ad->id,
                'title' => $ad->title,
                'make' => $ad->make,
                'model' => $ad->model,
                'trim' => $ad->trim,
                'year' => $ad->year,
                'plan_type' => $ad->plan_type,
                'main_image_url' => asset('storage/' . $ad->main_image),
                'views' => $ad->views,
                'price' => $ad->price ?? $ad->day_rent ?? $ad->month_rent,
                'status' => $ad->add_status,
                'category' => 'Car Rent',
                'category_slug' => 'car_rent',
                'created_at' => $ad->created_at->toDateTimeString(),
                'created_at_timestamp' => $ad->created_at->timestamp,
                'expires_at' => $ad->expires_at,
            ];
        });
        //real Estate
        $formattedRealEstateAds = $realEstatesAds->map(function ($ad) {
            return [
                'id' => $ad->id,
                'title' => $ad->title,
                'description' => $ad->description,
                'emirate' => $ad->emirate,
                'district' => $ad->district,
                'area' => $ad->area,
                'price' => $ad->price,
                'plan_type' => $ad->plan_type,
                'main_image_url' => $ad->main_image_url,
                'thumbnail_images_urls' => $ad->thumbnail_images_urls,
                'views' => $ad->views,
                'status' => $ad->add_status,
                'category' => 'Real Estate',
                'category_slug' => 'real-estate',
                'created_at' => $ad->created_at->toDateTimeString(),
                'created_at_timestamp' => $ad->created_at->timestamp,
                'expires_at' => $ad->expires_at,
            ];
        });
        //Jobs 
        $formattedJobAds = $jobAds->map(function ($ad) {
            return [
                'id' => $ad->id,
                'title' => $ad->title,
                'price' => $ad->salary,
                'emirate' => $ad->emirate,
                'district' => $ad->district,
                'category_type' => $ad->category_type,
                'section_type' => $ad->section_type,
                'job_name' => $ad->job_name,
                'views' => $ad->views,
                'status' => $ad->add_status,
                'category' => 'Jobs',
                'plan_type' => $ad->plan_type,
                'category_slug' => 'jobs',
                'created_at' => $ad->created_at->toDateTimeString(),
                'created_at_timestamp' => $ad->created_at->timestamp,
                'expires_at' => $ad->expires_at,
            ];
        });
        //electronic
        $formattedElectronicAds = $electronic->map(function ($ad) {
            return [
                'id' => $ad->id,
                'title' => $ad->title,
                'price' => $ad->price,
                'emirate' => $ad->emirate,
                'district' => $ad->district,
                'area' => $ad->area,
                'product_name' => $ad->product_name,
                'main_image_url' => asset('storage/' . $ad->main_image),
                'thumbnail_images_urls' => $ad->thumbnail_images_urls,
                'views' => $ad->views,
                'category' => $ad->add_category,
                'status' => $ad->add_status,
                'plan_type' => $ad->plan_type,
                'category_slug' => 'electronics',
                'created_at' => $ad->created_at->toDateTimeString(),
                'created_at_timestamp' => $ad->created_at->timestamp,
                'expires_at' => $ad->expires_at,
            ];
        });
        $formattedOtherServiceAds = $otherService->map(function ($ad) {
            return [
                'id' => $ad->id,
                'title' => $ad->title,
                'price' => $ad->price,
                'emirate' => $ad->emirate,
                'district' => $ad->district,
                'area' => $ad->area,
                'service_name' => $ad->service_name,
                'section_type' => $ad->section_type,
                'main_image_url' => asset('storage/' . $ad->main_image),
                'views' => $ad->views,
                'category' => $ad->add_category,
                'status' => $ad->add_status,
                'plan_type' => $ad->plan_type,
                'category_slug' => 'other-services',
                'created_at' => $ad->created_at->toDateTimeString(),
                'created_at_timestamp' => $ad->created_at->timestamp,
                'expires_at' => $ad->expires_at,
            ];
        });


        $formattedOtherServiceAds = $otherService->map(function ($ad) {
            return [
                'id' => $ad->id,
                'title' => $ad->title,
                'price' => $ad->price,
                'emirate' => $ad->emirate,
                'district' => $ad->district,
                'area' => $ad->area,
                'service_name' => $ad->service_name,
                'section_type' => $ad->section_type,
                'main_image_url' => asset('storage/' . $ad->main_image),
                'views' => $ad->views,
                'category' => $ad->add_category,
                'status' => $ad->add_status,
                'plan_type' => $ad->plan_type,
                'category_slug' => 'other-services',
                'created_at' => $ad->created_at->toDateTimeString(),
                'created_at_timestamp' => $ad->created_at->timestamp,
            ];
        });

        // --- الخطوة 3 و 4: دمج كل القوائم وترتيبها ---
        // تحويل Collections إلى arrays لتجنب مشاكل getKey()
        $allAdsArray = array_merge(
            $formattedCarAds->toArray(),
            $formattedCarServicesAds->toArray(),
            $formattedRestaurantAds->toArray(),
            $formattedCarRentAds->toArray(),
            $formattedRealEstateAds->toArray(),
            $formattedJobAds->toArray(),
            $formattedElectronicAds->toArray(),
            $formattedOtherServiceAds->toArray()
        );

        // ترتيب البيانات حسب created_at_timestamp
        usort($allAdsArray, function ($a, $b) {
            return $b['created_at_timestamp'] <=> $a['created_at_timestamp'];
        });

        // --- الخطوة 5: تنفيذ التقسيم على الصفحات (Pagination) يدويًا ---
        return response()->json([
            'user_id' => $user->id,
            'total_ads' => count($allAdsArray),
            'ads' => $allAdsArray,
        ]);
    }


    // public function userAds($user_id)
    // {
    //     $carAds = CarSalesAd::where('user_id', $user_id)->get();
    //     $carServicesAds = CarServicesAd::where('user_id', $user_id)->get();
    //     $restaurantAds = RestaurantAd::where('user_id', $user_id)->get();
    //     $carRentAds = CarRentAd::where('user_id', $user_id)->get();
    //     $realEstatesAds = RealEstateAd::where('user_id', $user_id)->get();
    //     $jobAds = JobAd::where('user_id', $user_id)->get();
    //     $electronic = electronicAd::where('user_id', $user_id)->get();
    //     $otherService = OtherServiceAds::where('user_id', $user_id)->get();

    //     $formattedCarAds = $carAds->map(function ($ad) {
    //         return [
    //             'id' => $ad->id,
    //             'title' => $ad->title,
    //             'make' => $ad->make,
    //             'model' => $ad->model,
    //             'trim' => $ad->trim,
    //             'year' => $ad->year,
    //             'plan_type' => $ad->plan_type,
    //             'main_image_url' => asset('storage/' . $ad->main_image),
    //             'price' => $ad->price,
    //             'status' => $ad->add_status,
    //             'category' => 'Cars Sales',
    //             'category_slug' => 'car_sales',
    //             'created_at' => $ad->created_at->toDateTimeString(),
    //             'created_at_timestamp' => $ad->created_at->timestamp,
    //         ];
    //     });

    //     $formattedCarServicesAds = $carServicesAds->map(function ($ad) {
    //         return [
    //             'id' => $ad->id,
    //             'title' => $ad->title,
    //             'service_type' => $ad->service_type,
    //             'service_name' => $ad->service_name,
    //             'emirate' => $ad->emirate,
    //             'district' => $ad->district,
    //             'area' => $ad->area,
    //             'plan_type' => $ad->plan_type,
    //             'main_image_url' => asset('storage/' . $ad->main_image),
    //             'price' => $ad->price,
    //             'status' => $ad->add_status,
    //             'category' => 'Car Services',
    //             'category_slug' => 'car_services',
    //             'created_at' => $ad->created_at->toDateTimeString(),
    //             'created_at_timestamp' => $ad->created_at->timestamp,
    //         ];
    //     });

    //     $formattedRestaurantAds = $restaurantAds->map(function ($ad) {
    //         return [
    //             'id' => $ad->id,
    //             'title' => $ad->title,
    //             'description' => $ad->description,
    //             'emirate' => $ad->emirate,
    //             'district' => $ad->district,
    //             'area' => $ad->area,
    //             'restaurant_category' => $ad->category,
    //             'plan_type' => $ad->plan_type,
    //             'main_image_url' => asset('storage/' . $ad->main_image),
    //             'price' => $ad->price_range,
    //             'status' => $ad->add_status,
    //             'category' => 'restaurant',
    //             'category_slug' => 'restaurant',
    //             'created_at' => $ad->created_at->toDateTimeString(),
    //             'created_at_timestamp' => $ad->created_at->timestamp,
    //         ];
    //     });

    //     $formattedCarRentAds = $carRentAds->map(function ($ad) {
    //         return [
    //             'id' => $ad->id,
    //             'title' => $ad->title,
    //             'make' => $ad->make,
    //             'model' => $ad->model,
    //             'trim' => $ad->trim,
    //             'year' => $ad->year,
    //             'plan_type' => $ad->plan_type,
    //             'main_image_url' => asset('storage/' . $ad->main_image),
    //             'price' => $ad->price ?? $ad->day_rent ?? $ad->month_rent,
    //             'status' => $ad->add_status,
    //             'category' => 'Car Rent',
    //             'category_slug' => 'car_rent',
    //             'created_at' => $ad->created_at->toDateTimeString(),
    //             'created_at_timestamp' => $ad->created_at->timestamp,
    //         ];
    //     });

    //     $formattedRealEstateAds = $realEstatesAds->map(function ($ad) {
    //         return [
    //             'id' => $ad->id,
    //             'title' => $ad->title,
    //             'description' => $ad->description,
    //             'emirate' => $ad->emirate,
    //             'district' => $ad->district,
    //             'area' => $ad->area,
    //             'price' => $ad->price,
    //             'plan_type' => $ad->plan_type,
    //             'main_image_url' => $ad->main_image_url,
    //             'thumbnail_images_urls' => $ad->thumbnail_images_urls,
    //             'status' => $ad->add_status,
    //             'category' => 'Real Estate',
    //             'category_slug' => 'real-estate',
    //             'created_at' => $ad->created_at->toDateTimeString(),
    //             'created_at_timestamp' => $ad->created_at->timestamp,
    //         ];
    //     });

    //     $formattedJobAds = $jobAds->map(function ($ad) {
    //         return [
    //             'id' => $ad->id,
    //             'title' => $ad->title,
    //             'price' => $ad->salary,
    //             'emirate' => $ad->emirate,
    //             'district' => $ad->district,
    //             'category_type' => $ad->category_type,
    //             'section_type' => $ad->section_type,
    //             'job_name' => $ad->job_name,
    //             'status' => $ad->add_status,
    //             'category' => 'Jobs',
    //             'category_slug' => 'jobs',
    //             'created_at' => $ad->created_at->toDateTimeString(),
    //             'created_at_timestamp' => $ad->created_at->timestamp,
    //         ];
    //     });

    //     $formattedElectronicAds = $electronic->map(function ($ad) {
    //         return [
    //             'id' => $ad->id,
    //             'title' => $ad->title,
    //             'price' => $ad->price,
    //             'emirate' => $ad->emirate,
    //             'district' => $ad->district,
    //             'area' => $ad->area,
    //             'product_name' => $ad->product_name,
    //             'main_image_url' => asset('storage/' . $ad->main_image),
    //             'thumbnail_images_urls' => $ad->thumbnail_images_urls,
    //             'category' => $ad->add_category,
    //             'status' => $ad->add_status,
    //             'category_slug' => 'electronics',
    //             'created_at' => $ad->created_at->toDateTimeString(),
    //             'created_at_timestamp' => $ad->created_at->timestamp,
    //         ];
    //     });

    //     $formattedOtherServiceAds = $otherService->map(function ($ad) {
    //         return [
    //             'id' => $ad->id,
    //             'title' => $ad->title,
    //             'price' => $ad->price,
    //             'emirate' => $ad->emirate,
    //             'district' => $ad->district,
    //             'area' => $ad->area,
    //             'service_name' => $ad->service_name,
    //             'section_type' => $ad->section_type,
    //             'main_image_url' => asset('storage/' . $ad->main_image),
    //             'category' => $ad->add_category,
    //             'status' => $ad->add_status,
    //             'category_slug' => 'other-services',
    //             'created_at' => $ad->created_at->toDateTimeString(),
    //             'created_at_timestamp' => $ad->created_at->timestamp,
    //         ];
    //     });

    //     $allAdsArray = array_merge(
    //         $formattedCarAds->toArray(),
    //         $formattedCarServicesAds->toArray(),
    //         $formattedRestaurantAds->toArray(),
    //         $formattedCarRentAds->toArray(),
    //         $formattedRealEstateAds->toArray(),
    //         $formattedJobAds->toArray(),
    //         $formattedElectronicAds->toArray(),
    //         $formattedOtherServiceAds->toArray()
    //     );

    //     usort($allAdsArray, fn($a, $b) => $b['created_at_timestamp'] <=> $a['created_at_timestamp']);

    //     return response()->json([
    //         'user_id' => $user_id,
    //         'total_ads' => count($allAdsArray),
    //         'ads' => $allAdsArray,
    //     ]);
    // }

    public function userAds($user_id)
    {
        $carAds = CarSalesAd::where('user_id', $user_id)->get();
        $carServicesAds = CarServicesAd::where('user_id', $user_id)->get();
        $restaurantAds = RestaurantAd::where('user_id', $user_id)->get();
        $carRentAds = CarRentAd::where('user_id', $user_id)->get();
        $realEstatesAds = RealEstateAd::where('user_id', $user_id)->get();
        $jobAds = JobAd::where('user_id', $user_id)->get();
        $electronic = electronicAd::where('user_id', $user_id)->get();
        $otherService = OtherServiceAds::where('user_id', $user_id)->get();

        $allAds = collect()
            ->merge($carAds)
            ->merge($carServicesAds)
            ->merge($restaurantAds)
            ->merge($carRentAds)
            ->merge($realEstatesAds)
            ->merge($jobAds)
            ->merge($electronic)
            ->merge($otherService);


        $allAds = $allAds->sortByDesc('created_at')->values();


        return response()->json([
            'user_id' => $user_id,
            'total_ads' => $allAds->count(),
            'ads' => $allAds,
        ]);
    }
}
