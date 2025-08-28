<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// --- Controllers ---
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MyAdsController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\CarSalesAdController;
use App\Http\Controllers\Api\FeaturedContentController;
use App\Http\Controllers\UploadController;

// --- Filter Controllers ---
use App\Http\Controllers\Api\Filters\CarSalesFiltersController;

// --- Admin Controllers ---
// <<< لاحظ: نحن نستدعي فقط الكلاس من مساره الصحيح والجديد >>>
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\Admin\BestAdvertiserController;
use App\Http\Controllers\Api\Admin\CarSaleFilterManagementController;

// --- Middleware ---
use App\Http\Middleware\IsAdmin;


/*
|--------------------------------------------------------------------------
| Public API Routes (No Authentication Needed)
|--------------------------------------------------------------------------
*/

Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/best-advertisers', [FeaturedContentController::class, 'getBestAdvertisers']);
Route::get('/users/{user}/ads/{category}', [FeaturedContentController::class, 'getUserAdsByCategory']);
Route::get('/car-sales-filters', [CarSalesFiltersController::class, 'index']);


/*
|--------------------------------------------------------------------------
| Authenticated User Routes (Requires Bearer Token)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {
    
    Route::get('/user', fn(Request $request) => $request->user());
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/profile', [ProfileController::class, 'update']);
    Route::post('/profile/password', [ProfileController::class, 'changePassword']);
    Route::post('/upload', [UploadController::class, 'upload']);

    Route::get('/my-ads', [MyAdsController::class, 'index']);
    Route::apiResource('car-sales-ads', CarSalesAdController::class);


    /*
    |--------------------------------------------------------------------------
    | Admin-Only Routes (Requires Admin Role)
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->middleware(IsAdmin::class)->group(function () {
        
        Route::get('/ads', [CarSalesAdController::class, 'indexForAdmin']);
        Route::get('/ads/pending', [CarSalesAdController::class, 'getPendingAds']);
        Route::post('/ads/{carSalesAd}/approve', [CarSalesAdController::class, 'approveAd']);
        Route::post('/ads/{carSalesAd}/reject', [CarSalesAdController::class, 'rejectAd']);

        // <<< لاحظ: هذا السطر يستخدم التعريف الصحيح الذي استدعيناه في الأعلى >>>
        Route::apiResource('/users', UserController::class); 
        Route::post('/users/{user}/toggle-best', [BestAdvertiserController::class, 'toggleStatus']);
        
        Route::prefix('filters/car-sale')->group(function () {
            // Makes Management
            Route::apiResource('/makes', CarSaleFilterManagementController::class)->except(['show']); // using apiResource for simplicity
            // ... يمكنك استخدام apiResource هنا أيضًا لتبسيط الكود
        });
    });
});