<?php
namespace App\Http\Controllers\Api;
// في الأعلى
use Illuminate\Support\Facades\DB;
use App\Models\BestAdvertiser;
use App\Models\CarSalesAd; // كمثال للقسم الأول
use App\Http\Controllers\Controller;
use Illuminate\Http\Request; // <<< أضف هذا السطر

  
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
                         ->get(['price', 'year', 'km', 'main_image', 'make', 'model', 'trim'])
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
}