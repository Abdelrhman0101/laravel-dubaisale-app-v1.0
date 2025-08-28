<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class FeaturedContentController extends Controller
{
    public function getBestAdvertisers()
    {
        // جلب المستخدمين المميزين فقط، مع جلب علاقة إعلانات السيارات الخاصة بهم
        $bestAdvertisers = User::where('the_best', true)
            ->with(['carSalesAds' => function ($query) {
                // داخل كل علاقة، قم بالتالي:
                $query->where('add_status', 'Valid') // فقط الإعلانات الصالحة
                      ->latest() // رتبها من الأحدث للأقدم
                      ->take(8) // خذ آخر 8 فقط
                      ->select([ // اختر فقط الحقول التي نحتاجها
                          'user_id', 'price', 'year', 'km', 
                          'main_image', 'make', 'model', 'trim'
                      ]);
            }])
            ->select('id', 'advertiser_name') // من جدول المستخدمين، نحتاج لهذه الحقول فقط
            ->get();

        // خطوة إضافية: تحويل مسار الصورة إلى رابط كامل
        $bestAdvertisers->each(function ($advertiser) {
            $advertiser->carSalesAds->each(function ($ad) {
                $ad->main_image = asset('storage/' . $ad->main_image);
            });
        });

        return response()->json($bestAdvertisers);
    }
}