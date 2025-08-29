<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CarSalesAd;
use App\Models\OfferBoxSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class OfferBoxActivationController extends Controller
{
    public function activate(Request $request)
    {
        $data = $request->validate([
            'ad_id' => 'required|integer',
            'category_slug' => 'required|string|in:car_sales', // حاليًا قسم السيارات فقط
            'days' => 'required|integer|min:1',
        ]);

        // 1. جلب الإعلان والتحقق من الملكية
        $ad = CarSalesAd::findOrFail($data['ad_id']);
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
        $currentActiveOffers = CarSalesAd::where('add_category', 'Cars Sales') // سيتم استبدالها بـ category_slug
                                         ->where('active_offers_box_status', true)->count();

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
}