<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CarSalesAd;
use App\Models\CarServicesAd;
use App\Models\OfferBoxSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\RestaurantAd;
use App\Models\CarRentAd;

class OfferBoxActivationController extends Controller
{
    public function activate(Request $request)
    {
        $data = $request->validate([
            'ad_id' => 'required|integer',
            'category_slug' => 'required|string|in:car_sales,car_services,restaurant,car_rent',
            'days' => 'required|integer|min:1',
        ]);

        // 1. جلب الإعلان والتحقق من الملكية
        $ad = $this->getAdByCategory($data['category_slug'], $data['ad_id']);
        if (!$ad) {
            return response()->json(['error' => 'Ad not found'], 404);
        }
        
        if ($request->user()->id !== $ad->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        if ($ad->active_offers_box_status) {
             return response()->json(['error' => 'This ad is already in the Offers Box.'], 422);
        }
        
        // 2. جلب إعدادات القسم
        $settings = OfferBoxSetting::where('category_slug', $data['category_slug'])->first();
        if (!$settings) {
            return response()->json(['error' => 'Offers Box is not available for this category yet.'], 404);
        }
        
        // 3. التحقق من العدد الأقصى (الخطوة الأهم)
        $currentActiveOffers = $this->getCurrentActiveOffersCount($data['category_slug']);

        if ($currentActiveOffers >= $settings->max_ads) {
            return response()->json(['error' => 'The Offers Box for this category is full. Please try again later.'], 422);
        }

        // 4. حساب السعر وتحديث الإعلان
        $totalPrice = $data['days'] * $settings->price_per_day;
        // (هنا في المستقبل، سيتم وضع منطق الدفع. الآن سنفترض أنه تم بنجاح)

        $ad->update([
            'active_offers_box_status' => true,
            'active_offers_box_days' => $data['days'],
            'active_offers_box_expires_at' => now()->addDays($data['days']),
        ]);

        return response()->json([
            'message' => 'Ad has been successfully promoted to the Offers Box!',
            'total_price' => $totalPrice,
            'expires_at' => $ad->active_offers_box_expires_at,
        ]);
    }

    /**
     * Get ad by category and ID.
     */
    private function getAdByCategory($categorySlug, $adId)
    {
        switch ($categorySlug) {
            case 'car_sales':
                return CarSalesAd::find($adId);
            case 'car_services':
                return CarServicesAd::find($adId);
            case 'restaurant':
                return RestaurantAd::find($adId);
            case 'car_rent':
                return CarRentAd::find($adId);
            default:
                return null;
        }
    }

    /**
     * Get current active offers count by category.
     */
    private function getCurrentActiveOffersCount($categorySlug)
    {
        switch ($categorySlug) {
            case 'car_sales':
                return CarSalesAd::where('active_offers_box_status', true)->count();
            case 'car_services':
                return CarServicesAd::where('active_offers_box_status', true)->count();
            case 'restaurant':
                return RestaurantAd::where('active_offers_box_status', true)->count();
            case 'car_rent':
                return CarRentAd::where('active_offers_box_status', true)->count();
            default:
                return 0;
        }
    }
}