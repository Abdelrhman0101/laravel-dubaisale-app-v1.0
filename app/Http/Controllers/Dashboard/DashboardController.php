<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BestAdvertiser;
use App\Models\CarSalesAd;
use App\Models\CarServicesAd;
use App\Models\RestaurantAd;
use App\Models\CarRentAd;
use App\Models\JobAd;
use App\Models\electronicAd;
use App\Models\OtherServiceAds;
use App\Models\RealEstateAd;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class DashboardController extends Controller
{
     public function __construct()
    {
        // هذا السطر يتحقق مما إذا كان المستخدم admin.
        // إذا لم يكن، يقوم بإطلاق خطأ 403 (Forbidden)
        if (Auth::user() && Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
    }
    public function index() { return view('dashboard'); }
    public function accounts() { return view('accounts'); }
    public function requests() { return view('requests'); }
    public function securityPermits() { return view('securityPermits'); }
    public function appController() { return view('appController'); }
    public function appSettings() { return view('AppSettings'); } // تأكد من أن اسم الملف متطابق
    public function chat() { return view('chat'); }
    public function searchFilterSettings() { return view('search-filter-settings'); }
    public function sectionBanners() { return view('section-banners'); }
    
    public function adsManagement() 
    { 
        // Helper function to map ads
        $mapAd = function($ad, $type, $catAr, $catEn) {
            return (object)[
                'id' => $ad->id,
                'image' => $ad->main_image ? Storage::url($ad->main_image) : 'https://via.placeholder.com/60x60/3490dc/ffffff?text=AD',
                'title' => $ad->title ?? $ad->name ?? 'No Title',
                'titleEn' => $ad->title_en ?? $ad->title ?? 'No Title',
                'advertiser' => optional($ad->user)->username ?? 'Unknown',
                'advertiserEn' => optional($ad->user)->username ?? 'Unknown',
                'cost' => ($ad->price ?? $ad->salary ?? 0) . ' ريال',
                'costEn' => ($ad->price ?? $ad->salary ?? 0) . ' SAR',
                'category' => $catAr,
                'categoryEn' => $catEn,
                'package' => $ad->package_type ?? 'عادي',
                'packageEn' => $ad->package_type ?? 'Standard',
                'created' => $ad->created_at ? $ad->created_at->format('Y/m/d') : '-',
                'createdEn' => $ad->created_at ? $ad->created_at->format('d M Y') : '-',
                'expiry' => $ad->plan_expires_at ? Carbon::parse($ad->plan_expires_at)->format('Y/m/d') : '-',
                'expiryEn' => $ad->plan_expires_at ? Carbon::parse($ad->plan_expires_at)->format('d M Y') : '-',
                'views' => $ad->views ?? 0,
                'type' => $type,
                'raw_created_at' => $ad->created_at // For sorting
            ];
        };

        $ads = collect();

        // Fetch from all categories (Limiting to 20 each for performance, can be adjusted)
        $ads = $ads->concat(CarSalesAd::with('user')->latest()->take(20)->get()->map(fn($ad) => $mapAd($ad, 'car_sales', 'سيارات', 'Cars')));
        $ads = $ads->concat(CarServicesAd::with('user')->latest()->take(20)->get()->map(fn($ad) => $mapAd($ad, 'car_services', 'خدمات سيارات', 'Car Services')));
        $ads = $ads->concat(RestaurantAd::with('user')->latest()->take(20)->get()->map(fn($ad) => $mapAd($ad, 'restaurant', 'مطاعم', 'Restaurants')));
        $ads = $ads->concat(CarRentAd::with('user')->latest()->take(20)->get()->map(fn($ad) => $mapAd($ad, 'car_rent', 'تأجير سيارات', 'Car Rent')));
        $ads = $ads->concat(JobAd::with('user')->latest()->take(20)->get()->map(fn($ad) => $mapAd($ad, 'jobs', 'وظائف', 'Jobs')));
        $ads = $ads->concat(electronicAd::with('user')->latest()->take(20)->get()->map(fn($ad) => $mapAd($ad, 'electronics', 'إلكترونيات', 'Electronics')));
        $ads = $ads->concat(OtherServiceAds::with('user')->latest()->take(20)->get()->map(fn($ad) => $mapAd($ad, 'other_services', 'خدمات أخرى', 'Other Services')));
        $ads = $ads->concat(RealEstateAd::with('user')->latest()->take(20)->get()->map(fn($ad) => $mapAd($ad, 'real_estate', 'عقارات', 'Real Estate')));

        // Sort by raw_created_at descending
        $ads = $ads->sortByDesc('raw_created_at')->values(); // values() resets keys

        return view('ads-management', compact('ads')); 
    }
    
    public function bestAdvertisers() 
    { 
        $categories = [
            'restaurant', 
            'car_services', 
            'car_rent', 
            'jobs', 
            'electronics', 
            'real-estate', 
            'car_sales', 
            'other_services'
        ];

        $counts = [];
        foreach ($categories as $category) {
            $counts[$category] = BestAdvertiser::whereJsonContains('categories', $category)->count();
        }

        return view('best-advertisers', compact('counts')); 
    }
    
    public function sendNotification() { return view('send-notification'); }
}