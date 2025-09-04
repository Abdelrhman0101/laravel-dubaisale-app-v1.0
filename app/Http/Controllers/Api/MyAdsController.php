<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CarSalesAd;
use App\Models\CarServicesAd;
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
        $carServicesAds = CarServicesAd::where('user_id', $user->id)->get();
        // $realEstateAds = RealEstateAd::where('user_id', $user->id)->get(); // للمستقبل
        // $jobAds = JobAd::where('user_id', $user->id)->get(); // للمستقبل

        // --- الخطوة 2: توحيد شكل البيانات لكل قسم ---
        $formattedCarAds = $carAds->map(function ($ad) {
            return (object) [
                'id' => $ad->id,
                'title' => $ad->title,
                'make' => $ad->make,
                'model' => $ad->model,
                'trim' => $ad->trim,
                'plan_type' => $ad->plan_type,
                'main_image_url' => asset('storage/' . $ad->main_image),
                'price' => $ad->price,
                'status' => $ad->add_status,
                'category' => 'Cars Sales', // نوع القسم
                'created_at' => $ad->created_at,
            ];
        });
        
        $formattedCarServicesAds = $carServicesAds->map(function ($ad) {
            return (object) [
                'id' => $ad->id,
                'title' => $ad->title,
                'service_type' => $ad->service_type,
                'service_name' => $ad->service_name,
                'emirate' => $ad->emirate,
                'district' => $ad->district,
                'area' => $ad->area,
                'plan_type' => $ad->plan_type,
                'main_image_url' => asset('storage/' . $ad->main_image),
                'price' => $ad->price,
                'status' => $ad->add_status,
                'category' => 'Car Services', // نوع القسم
                'created_at' => $ad->created_at,
            ];
        });
        
        // --- الخطوة 3 و 4: دمج كل القوائم وترتيبها ---
        // دمج إعلانات السيارات وخدمات السيارات
        // في المستقبل ستدمج الباقي هكذا:
        // $allAds = $formattedCarAds->merge($formattedCarServicesAds)->merge($formattedRealEstateAds)->merge($formattedJobAds);
        
        $allAds = $formattedCarAds->merge($formattedCarServicesAds);
        $sortedAds = $allAds->sortByDesc('created_at');

        // --- الخطوة 5: تنفيذ التقسيم على الصفحات (Pagination) يدويًا ---
        $perPage = 10;
        $currentPage = $request->input('page', 1);
        $totalItems = $sortedAds->count();
        $currentPageItems = $sortedAds->slice(($currentPage - 1) * $perPage, $perPage)->values();

        // إنشاء استجابة pagination مخصصة
        $paginationData = [
            'data' => $currentPageItems,
            'current_page' => $currentPage,
            'per_page' => $perPage,
            'total' => $totalItems,
            'last_page' => ceil($totalItems / $perPage),
            'from' => ($currentPage - 1) * $perPage + 1,
            'to' => min($currentPage * $perPage, $totalItems),
            'path' => $request->url(),
            'first_page_url' => $request->url() . '?page=1',
            'last_page_url' => $request->url() . '?page=' . ceil($totalItems / $perPage),
            'next_page_url' => $currentPage < ceil($totalItems / $perPage) ? $request->url() . '?page=' . ($currentPage + 1) : null,
            'prev_page_url' => $currentPage > 1 ? $request->url() . '?page=' . ($currentPage - 1) : null,
        ];
        
        return response()->json($paginationData);
    }
}