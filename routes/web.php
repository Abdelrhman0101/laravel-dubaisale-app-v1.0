<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\LoginController;
use App\Http\Controllers\Dashboard\AdApprovalController;
use App\Http\Controllers\Dashboard\DashboardController; // <<< سننشئ هذا

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| هذه الروابط خاصة بواجهة الويب (الداش بورد) وتستخدم نظام مصادقة الجلسات (Sessions).
|
*/

// --- Routes متاحة للجميع (تسجيل الدخول) ---
// الـ middleware 'guest' يضمن أن هذه الصفحات لا يمكن الوصول إليها إلا إذا كان المستخدم "ضيفًا" (غير مسجل دخوله)
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
});


// --- Routes محمية (تتطلب تسجيل دخول كـ Admin) ---
// هذه المجموعة تحمي كل ما بداخلها وتضمن أن المستخدم مسجل دخوله وأنه admin.
Route::middleware(['auth', 'admin.web'])->group(function () {

    // تسجيل الخروج
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // الصفحة الرئيسية للداش بورد
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // صفحة الموافقة على الإعلانات
    Route::get('/ads-approval', [AdApprovalController::class, 'index'])->name('ads-approval');

    // باقي صفحات الداش بورد (باستخدام Controller ليكون الكود نظيفًا)
    // سننشئ DashboardController ليتولى عرض هذه الصفحات
    Route::get('/accounts', [DashboardController::class, 'accounts'])->name('accounts');
    Route::get('/requests', [DashboardController::class, 'requests'])->name('requests');
    Route::get('/securityPermits', [DashboardController::class, 'securityPermits'])->name('securityPermits');
    Route::get('/appController', [DashboardController::class, 'appController'])->name('appController');
    Route::get('/AppSettings', [DashboardController::class, 'appSettings'])->name('AppSettings');
    Route::get('/chat', [DashboardController::class, 'chat'])->name('chat');
    Route::get('/search-filter-settings', [DashboardController::class, 'searchFilterSettings'])->name('search-filter-settings');
    Route::get('/section-banners', [DashboardController::class, 'sectionBanners'])->name('section-banners');
    Route::get('/ads-management', [DashboardController::class, 'adsManagement'])->name('ads-management');
    Route::get('/best-advertisers', [DashboardController::class, 'bestAdvertisers'])->name('best-advertisers');
    Route::get('/send-notification', [DashboardController::class, 'sendNotification'])->name('send-notification');

});

// --- Redirect a Root URL ---
Route::get('/', function () {
    return redirect()->route('login');
});