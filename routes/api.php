<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\Api\CarSalesAdController;
use App\Http\Controllers\Api\UserController;
use App\Http\Middleware\IsAdmin; // هذا السطر صحيح ومهم
use App\Http\Controllers\Api\ProfileController; // <<< لا تنسَ إضافته في الأعلى
use App\Http\Controllers\Api\MyAdsController; // <<< لا تنسَ هذا السطر


// Routes مفتوحة للجميع
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/activate', [AuthController::class, 'activate']);
Route::post('/login', [AuthController::class, 'login']);
Route::apiResource('car-sales-ads', CarSalesAdController::class);

// Routes محمية وتتطلب Bearer Token صالح
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', fn(Request $request) => $request->user());
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/upload', [UploadController::class, 'upload']);
    Route::post('/profile', [ProfileController::class, 'update']);
    Route::post('/profile/password', [ProfileController::class, 'changePassword']);
    Route::get('/my-ads', [MyAdsController::class, 'index']);
    // Resource for users to manage their OWN ads
    // Route::apiResource('car-sales-ads', CarSalesAdController::class);

    // =========================================================
    // ==== Admin-Only Routes (هنا التصحيح النهائي) ====
    // =========================================================
    Route::prefix('admin') // <- الخطوة 1: أرجع البادئة إلى 'admin'
        ->middleware(IsAdmin::class) // <- الخطوة 2: استبدل 'admin' باسم الكلاس هنا
        ->group(function () {
            
            // Resource for admin to manage ALL ads
            Route::get('/ads', [CarSalesAdController::class, 'indexForAdmin']);
            Route::get('/ads/pending', [CarSalesAdController::class, 'getPendingAds']);
            Route::post('/ads/{carSalesAd}/approve', [CarSalesAdController::class, 'approveAd']);
            Route::post('/ads/{carSalesAd}/reject', [CarSalesAdController::class, 'rejectAd']);
            
            // لا تنسَ إضافة الـ route الخاص بإنشاء المستخدمين
            Route::post('/users', [UserController::class, 'store']);
        });
});

