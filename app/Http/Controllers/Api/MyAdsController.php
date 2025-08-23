<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CarSalesAd;
// في المستقبل، ستضيف الـ Models الأخرى هنا
// use App\Models\RealEstateAd;
// use App\Models\JobAd;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class MyAdsController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // --- الخطوة 1: جلب الإعلانات من كل قسم ---
        $carAds = CarSalesAd::where('user_id', $user->id)->get();
        // $realEstateAds = RealEstateAd::where('user_id', $user->id)->get(); // للمستقبل
        // $jobAds = JobAd::where('user_id', $user->id)->get(); // للمستقبل

        // --- الخطوة 2: توحيد شكل البيانات لكل قسم ---
        $formattedCarAds = $carAds->map(function ($ad) {
            return [
                'id' => $ad->id,
                'title' => $ad->title,
                'plan_type' => $ad->plan_type,
                'main_image_url' => asset('storage/' . $ad->main_image),
                'price' => $ad->price,
                'status' => $ad->add_status,
                'category' => 'Cars Sales', // نوع القسم
                'created_at' => $ad->created_at,
            ];
        });
        
        // --- الخطوة 3 و 4: دمج كل القوائم وترتيبها ---
        // حالياً لدينا قسم واحد فقط. في المستقبل ستدمج الباقي هكذا:
        // $allAds = $formattedCarAds->merge($formattedRealEstateAds)->merge($formattedJobAds);
        
        $allAds = $formattedCarAds; // حاليًا
        $sortedAds = $allAds->sortByDesc('created_at');

        // --- الخطوة 5: تنفيذ التقسيم على الصفحات (Pagination) يدويًا ---
        $perPage = 10;
        $currentPage = $request->input('page', 1);
        $currentPageItems = $sortedAds->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $paginatedAds = new LengthAwarePaginator(
            $currentPageItems,
            $sortedAds->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );
        
        return response()->json($paginatedAds);
    }
}