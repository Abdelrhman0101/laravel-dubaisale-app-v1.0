<?php

use Illuminate\Support\Facades\Route;

// صفحة تسجيل الدخول
Route::get('/login', function () {
    return view('login');
})->name('login');
Route::get('/', function () {
    return view('login');
})->name('login');
// صفحة الداشبورد
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
// صفحة ادارة الحسابات
Route::get('/accounts', function () {
    return view('accounts');
})->name('accounts');
// 
Route::get('/requests', function () {
    return view('requests');
})->name('requests');

Route::get('/securityPermits', function () {
    return view('securityPermits');
})->name('securityPermits');

Route::get('/appController', function () {
    return view('appController');
})->name('appController');
Route::get('/AppSettings', function () {
    return view('AppSettings');
})->name('AppSettings');
// ... (المسارات الأخرى)

// صفحة المحادثات
Route::get('/chat', function () {
    return view('chat'); // اسم ملف ה-Blade سيكون chat.blade.php
})->name('chat');

// صفحات إدارة التطبيق
Route::get('/search-filter-settings', function () {
    return view('search-filter-settings');
})->name('search-filter-settings');

Route::get('/section-banners', function () {
    return view('section-banners');
})->name('section-banners');

// صفحة إدارة الإعلانات
Route::get('/ads-management', function () {
    return view('ads-management');
})->name('ads-management');

Route::get('/best-advertisers', function () {
    return view('best-advertisers');
})->name('best-advertisers');

Route::get('/send-notification', function () {
    return view('send-notification');
})->name('send-notification');

Route::get('/ads-approval', function () {
    return view('ads-approval');
})->name('ads-approval');

// مسارات إدارة المستخدمين المحظورين
Route::get('/blocked-users', [App\Http\Controllers\UserController::class, 'blockedUsers'])->name('blocked-users');
Route::patch('/users/{id}/toggle-block', [App\Http\Controllers\UserController::class, 'toggleBlockStatus'])->name('users.toggle-block');


// مسارات إدارة المستخدمين
Route::get('/users-management', [App\Http\Controllers\UserController::class, 'usersManagement'])->name('users-management');
Route::get('/user-details/{id}', [App\Http\Controllers\UserController::class, 'userDetails'])->name('user-details');

// مسار متغيرات النظام
Route::get('/system-variables', function () {
    return view('system-variables');
})->name('system-variables');

// مسارات رسائل الدعم الفني
Route::get('/support-messages', [App\Http\Controllers\SupportMessagesController::class, 'index'])->name('support-messages');
Route::get('/api/support-messages', [App\Http\Controllers\SupportMessagesController::class, 'getMessages'])->name('api.support-messages');
Route::patch('/api/support-messages/{id}/mark-read', [App\Http\Controllers\SupportMessagesController::class, 'markAsRead'])->name('api.support-messages.mark-read');