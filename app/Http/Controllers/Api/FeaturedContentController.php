<?php

namespace App\Http\Controllers\Api;
// في الأعلى
use App\Models\RealEstateAd;
use Illuminate\Support\Facades\DB;
use App\Models\BestAdvertiser;
use App\Models\CarSalesAd; // كمثال للقسم الأول
use App\Models\CarServicesAd;
use App\Models\CarRentAd;
use App\Http\Controllers\Controller;
use App\Models\electronicAd;
use App\Models\JobAd;
use App\Models\OtherServiceAds;
use Illuminate\Http\Request; // <<< أضف هذا السطر
use App\Models\User; // <<< أضف هذا السطر
use App\Models\RestaurantAd; // أضف الموديل الخاص بالمطاعم
use Illuminate\Support\Facades\Log;

class FeaturedContentController extends Controller
{

    public function getBestAdvertisers($categorySlug)
    {
        $bestRecords = BestAdvertiser::with('user:id,advertiser_name')
            ->whereJsonContains('categories', $categorySlug)
            ->get();

        if ($bestRecords->isEmpty()) {
            return response()->json([]);
        }

        $usersGroupedByUser = $bestRecords->groupBy('user_id');

        $result = [];

        foreach ($usersGroupedByUser as $userId => $records) {
            $user = $records->first()->user;
            $userInfo = [
                'id' => $user->id,
                'advertiser_name' => $user->advertiser_name ?? $user->name ?? null,
                'category' => $categorySlug,
                'latest_ads' => $this->getLatestAdsForCategory($userId, $categorySlug) // لازم الميثود دي ترجع ads مناسبة
            ];

            $result[] = $userInfo;
        }

        return response()->json($result);
    }

    /**
     * دالة مساعدة لجلب الإعلانات بناءً على القسم.
     */
    private function getLatestAdsForCategory($userId, $categorySlug)
    {
        $ads = collect(); // مجموعة فارغة

        // هذا هو الجزء القابل للتطوير
        if ($categorySlug === 'car_sales') {
            $ads = CarSalesAd::where('user_id', $userId)
                ->where('add_status', 'Valid')
                ->latest()->take(8)
                ->get(['id', 'price', 'year', 'km', 'main_image', 'make', 'model', 'trim','add_category']);
            // ->each(fn($ad) => $ad->main_image = asset('storage/' . $ad->main_image));
        } elseif ($categorySlug === 'car_services') {
            $ads = CarServicesAd::where('user_id', $userId)
                ->where('add_status', 'Valid')
                ->latest()->take(8)
                ->get(['id', 'title', 'service_name', 'price', 'main_image', 'emirate', 'district', 'area','add_category']);
            // ->each(fn($ad) => $ad->main_image = asset('storage/' . $ad->main_image));
        } elseif ($categorySlug === 'restaurant') {
            $ads = RestaurantAd::where('user_id', $userId)
                ->where('add_status', 'Valid')
                ->latest()->take(8)
                ->get(['id', 'title', 'price_range', 'main_image', 'emirate', 'district', 'area','add_category']);
            // ->each(fn($ad) => $ad->main_image = asset('storage/' . $ad->main_image));
        } elseif ($categorySlug === 'car_rent') {
            $ads = CarRentAd::where('user_id', $userId)
                ->where('add_status', 'Valid')
                ->latest()->take(8)
                ->get(['id', 'title', 'make', 'model', 'year', 'price', 'day_rent', 'month_rent', 'main_image', 'emirate','add_category']);
            // ->each(fn($ad) => $ad->main_image = asset('storage/' . $ad->main_image));
        } elseif ($categorySlug === 'real-estate') {
            $ads = RealEstateAd::where('user_id', $userId)
                ->where('add_status', 'Valid')
                ->latest()->take(8)
                ->get(['id', 'title', 'price', 'emirate', 'district', 'area', 'contract_type', 'property_type', 'main_image','add_category']);
            // ->each(fn($ad) => $ad->main_image = asset('storage/' . $ad->main_image));
        } elseif ($categorySlug === 'jobs') {
            $ads = JobAd::where('user_id', $userId)
                ->where('add_status', 'Valid')
                ->latest()->take(8)
                ->get(['id', 'title', 'salary', 'emirate', 'district', 'category_type', 'section_type', 'job_name','add_category']);
        } elseif ($categorySlug === 'electronics') {
            $ads = electronicAd::where('user_id', $userId)
                ->where('add_status', 'Valid')
                ->latest()->take(8)
                ->get(['id', 'title', 'price', 'emirate', 'district', 'area', 'product_name', 'main_image', 'add_category', 'add_status']);
        } elseif ($categorySlug === 'other_services') {
            $ads = OtherServiceAds::where('user_id', $userId)
                ->where('add_status', 'Valid')
                ->latest()->take(8)
                ->get(['id', 'title', 'price', 'emirate', 'district', 'area', 'service_name', 'main_image', 'add_category', 'add_status']);
        }

        return $ads;
    }

    public function getUserAdsByCategory(Request $request, User $user, $category)
    {
        // يمكنك إضافة تحقق من أن الـ category مسموح به
        $ads = $this->getLatestAdsForCategory($user->id, $category);

        return response()->json($ads);
    }

    public function getOfferBoxAds($category)
    {
        // مستقبلاً، سنقوم ببناء نظام ذكي يتعرف على الموديل المناسب
        if ($category === 'car_sales') {
            $ads = CarSalesAd::where('add_category', 'Cars Sales')
                ->where('active_offers_box_status', true)
                ->inRandomOrder() // لعرض الإعلانات بترتيب عشوائي ليكون عادلاً
                ->get(); // يمكن إضافة ->limit() إذا أردت
            return response()->json($ads);
        } elseif ($category === 'car_services') {
            $ads = CarServicesAd::getOffersBoxAds();
            return response()->json($ads);
        } elseif ($category === 'restaurant') {
            // محاكاة نفس أسلوب CarServicesAd::getOffersBoxAds()
            $ads = RestaurantAd::where('add_status', 'Valid')
                ->where('admin_approved', true)
                ->where('active_offers_box_status', true)
                ->where(function ($q) {
                    $q->whereNull('active_offers_box_expires_at')
                        ->orWhere('active_offers_box_expires_at', '>', now());
                })
                ->inRandomOrder()
                ->limit(10)
                ->get();
            return response()->json($ads);
        } elseif ($category === 'car_rent') {
            $ads = CarRentAd::getOffersBoxAds();
            return response()->json($ads);
        } elseif ($category === 'real-estate') {
            $ads = RealEstateAd::where('add_category', 'Real State')
                ->where('active_offers_box_status', true)
                ->get();
        } elseif ($category == 'Jobs') {
            $ads = JobAd::where('add_category', 'Jop')
                ->where('active_offers_box_status', true)
                ->get();
        } elseif ($category == 'electronics') {
            $ads = electronicAd::where('add_category', 'electronics')
                ->where('active_offers_box_status', true)
                ->get();
        } elseif ($category == 'other_services') {
            $ads = OtherServiceAds::where('add_category', 'Other Services')
                ->where('active_offers_box_status', true)
                ->get();
        }


        return response()->json($ads);
    }
}
