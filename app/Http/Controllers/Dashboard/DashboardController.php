<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
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