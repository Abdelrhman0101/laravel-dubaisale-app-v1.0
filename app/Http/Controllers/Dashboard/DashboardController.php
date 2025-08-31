<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <<< مهم جدًا

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
    public function adsManagement() { return view('ads-management'); }
    public function bestAdvertisers() { return view('best-advertisers'); }
    public function sendNotification() { return view('send-notification'); }
}