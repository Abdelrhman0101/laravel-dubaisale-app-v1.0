<?php
namespace App\Http\Controllers\Api;
// في الأعلى
use Illuminate\Support\Facades\DB;
use App\Models\BestAdvertiser;
use App\Models\CarSalesAd; // كمثال للقسم الأول
use App\Models\CarServicesAd;
use App\Models\CarRentAd;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request; // <<< أضف هذا السطر
use App\Models\User; // <<< أضف هذا السطر
use App\Models\RestaurantAd; // أضف الموديل الخاص بالمطاعم

  
  
class FeaturedContentController extends Controller
{
    public function getBestAdvertisers()
    {
        // 1. جلب كل المستخدمين المميزين مع أقسامهم
        $bestRecords = BestAdvertiser::with('user:id,advertiser_name')->get();

        // 2. تجميعهم حسب المستخدم
        $usersGroupedByCategory = $bestRecords->groupBy('user_id');

        $result = [];
        
        // 3. لكل مستخدم، جلب آخر 8 إعلانات لكل قسم مميز فيه
        foreach ($usersGroupedByCategory as $userId => $categories) {
            $user = $categories->first()->user;
            $userInfo = [
                'id' => $user->id,
                'advertiser_name' => $user->advertiser_name,
                'featured_in' => []
            ];

            foreach ($categories as $record) {
                $categorySlug = $record->category_slug;
                $ads = $this->getLatestAdsForCategory($userId, $categorySlug);

                $userInfo['featured_in'][] = [
                    'category' => $categorySlug,
                    'latest_ads' => $ads
                ];
            }
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
                         ->get(['id','price', 'year', 'km', 'main_image', 'make', 'model', 'trim'])
                         ->each(fn($ad) => $ad->main_image = asset('storage/' . $ad->main_image));
        } elseif ($categorySlug === 'car_services') {
            $ads = CarServicesAd::where('user_id', $userId)
                         ->where('add_status', 'Valid')
                         ->latest()->take(8)
                         ->get(['id', 'title', 'service_name', 'price', 'main_image', 'emirate', 'district', 'area'])
                         ->each(fn($ad) => $ad->main_image = asset('storage/' . $ad->main_image));
        } elseif ($categorySlug === 'restaurant') {
            $ads = RestaurantAd::where('user_id', $userId)
                         ->where('add_status', 'Valid')
                         ->latest()->take(8)
                         ->get(['id', 'title', 'price_range', 'main_image', 'emirate', 'district', 'area'])
                         ->each(fn($ad) => $ad->main_image = asset('storage/' . $ad->main_image));
        } elseif ($categorySlug === 'car_rent') {
            $ads = CarRentAd::where('user_id', $userId)
                         ->where('add_status', 'Valid')
                         ->latest()->take(8)
                         ->get(['id','title','make','model','year','price','day_rent','month_rent','main_image','emirate'])
                         ->each(fn($ad) => $ad->main_image = asset('storage/' . $ad->main_image));
        }
        // else if ($categorySlug === 'real_estate') {
        //     // منطق جلب إعلانات العقارات
        // }

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
                    ->where(function($q){
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
    }
    
    return response()->json([]); // إذا كان القسم غير موجود
}
}