<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| هذه الروابط وظيفتها فقط عرض ملفات Blade الخاصة بالداش بورد.
| الحماية والتحقق من الصلاحيات ستتم بالكامل عبر JavaScript والـ API
| من خلال "حارس الحماية" الذي نضعه في بداية كل صفحة.
|
*/

// --- صفحة تسجيل الدخول (Route عام) ---
// هذه الصفحة هي الوحيدة التي لا تحتاج إلى "حارس حماية" في الـ JavaScript.
Route::get('/login', function () {
    // تأكد من أن ملفك موجود في `resources/views/auth/login-custom.blade.php`
    return view('auth.login-custom');
})->name('login');


// --- صفحات الداش بورد (Routes محمية عبر JavaScript) ---

// الصفحة الرئيسية للداش بورد
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// صفحة الموافقة على الإعلانات
Route::get('/ads-approval', function () {
    return view('ads-approval');
})->name('ads-approval');

// صفحة إدارة الحسابات
Route::get('/accounts', function () {
    return view('accounts');
})->name('accounts');

// صفحة الطلبات (Requests)
Route::get('/requests', function () {
    return view('requests');
})->name('requests');

// صفحة التصاريح الأمنية
Route::get('/securityPermits', function () {
    return view('securityPermits');
})->name('securityPermits');

// صفحة التحكم بالتطبيق
Route::get('/appController', function () {
    return view('appController');
})->name('appController');

// صفحة إعدادات التطبيق (متغيرات النظام)
Route::get('/AppSettings', function () {
    return view('AppSettings'); // تأكد من تطابق اسم الملف
})->name('AppSettings');

// صفحة المحادثات
Route::get('/chat', function () {
    return view('chat');
})->name('chat');

// صفحة إعدادات فلاتر البحث
Route::get('/search-filter-settings', function () {
    return view('search-filter-settings');
})->name('search-filter-settings');

// صفحة بنرات الأقسام
Route::get('/section-banners', function () {
    return view('section-banners');
})->name('section-banners');

// صفحة إدارة الإعلانات
Route::get('/ads-management', function () {
    return view('ads-management');
})->name('ads-management');

// صفحة أفضل المعلنين
Route::get('/best-advertisers', function () {
    return view('best-advertisers');
})->name('best-advertisers');

// صفحة إرسال الإشعارات
Route::get('/send-notification', function () {
    return view('send-notification');
})->name('send-notification');


// --- التوجيه الافتراضي ---
// إذا حاول أي شخص الوصول إلى المسار الرئيسي /، سيتم توجيهه إلى صفحة تسجيل الدخول.
Route::get('/', function () {
    return view('home');
});
// English landing page
Route::get('/en', function () {
    return view('home-en');
})->name('home-en');

// صفحات قانونية عامة
Route::view('/privacy-policy', 'privacy')->name('privacy');
Route::view('/terms', 'terms')->name('terms');

// --- لا يوجد Route لتسجيل الخروج هنا ---
// عملية تسجيل الخروج ستتم عبر JavaScript عن طريق حذف التوكن من localStorage وتوجيه المستخدم لصفحة الدخول.