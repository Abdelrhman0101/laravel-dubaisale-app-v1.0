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
use App\Http\Controllers\Api\OfferBoxActivationController;


// --- Filter Controllers ---
use App\Http\Controllers\Api\Filters\CarSalesFiltersController;

// --- Admin Controllers ---
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\Admin\BestAdvertiserController;
use App\Http\Controllers\Api\Admin\CarSaleFilterManagementController;
use App\Http\Controllers\Api\Admin\OfferBoxSettingsController;
use App\Http\Controllers\Api\Admin\SystemSettingsController;


// --- Middleware ---
use App\Http\Middleware\IsAdmin;


/*
|--------------------------------------------------------------------------
| Public API Routes (No Authentication Needed)
|--------------------------------------------------------------------------
*/

// Authentication
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/activate', [AuthController::class, 'activate']);
Route::post('/login', [AuthController::class, 'login']);

// Featured & Public Content
Route::get('/best-advertisers', [FeaturedContentController::class, 'getBestAdvertisers']);
Route::get('/users/{user}/ads/{category}', [FeaturedContentController::class, 'getUserAdsByCategory']);

// Public Filter Data for Frontend
// الطريقة الأكثر كفاءة: Endpoint رئيسي لجلب كل الفلاتر مرة واحدة
Route::get('/car-sales-filters', [CarSalesFiltersController::class, 'index']);

// ===== Endpoints إضافية لجلب أجزاء معينة من الفلاتر (إذا احتاجتها الواجهة ديناميكيًا) =====
Route::prefix('filters/car-sale')->group(function () {
    Route::get('/makes', [CarSaleFilterManagementController::class, 'getMakes']);
    Route::get('/makes/{make}/models', [CarSaleFilterManagementController::class, 'getModels']);
    Route::get('/models/{model}/trims', [CarSaleFilterManagementController::class, 'getTrims']);
});
Route::get('/offers-box/{category}', [FeaturedContentController::class, 'getOfferBoxAds']);

/*
|--------------------------------------------------------------------------
| Authenticated User Routes (Requires Bearer Token)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {
    
    // --- User & Profile Management ---
    Route::get('/user', fn(Request $request) => $request->user());
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/profile', [ProfileController::class, 'update']);
    Route::post('/profile/password', [ProfileController::class, 'changePassword']);
    Route::post('/upload', [UploadController::class, 'upload']);

    // --- User's Ads Management ---
    Route::get('/my-ads', [MyAdsController::class, 'index']);
    Route::apiResource('car-sales-ads', CarSalesAdController::class);
    Route::post('/offers-box/activate', [OfferBoxActivationController::class, 'activate']);

    /*
    |--------------------------------------------------------------------------
    | Admin-Only Routes (Requires Admin Role)
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->middleware(IsAdmin::class)->group(function () {
        
        // --- Admin: Full Ads Management ---
        Route::get('/ads', [CarSalesAdController::class, 'indexForAdmin']);
        Route::get('/ads/pending', [CarSalesAdController::class, 'getPendingAds']);
        Route::post('/ads/{carSalesAd}/approve', [CarSalesAdController::class, 'approveAd']);
        Route::post('/ads/{carSalesAd}/reject', [CarSalesAdController::class, 'rejectAd']);

        // --- Admin: Full Users Management ---
        Route::apiResource('/users', UserController::class); 
        Route::post('/users/{user}/toggle-best', [BestAdvertiserController::class, 'toggleStatus']);
        
        // --- Admin: Car Sale Filters (CRUD Operations) ---
        Route::prefix('filters/car-sale')->group(function () {
            // Makes Management
            Route::post('/makes', [CarSaleFilterManagementController::class, 'addMake']);
            Route::put('/makes/{make}', [CarSaleFilterManagementController::class, 'updateMake']);
            Route::delete('/makes/{make}', [CarSaleFilterManagementController::class, 'deleteMake']);
            
            // Models Management
            Route::post('/models', [CarSaleFilterManagementController::class, 'addModel']);
            Route::put('/models/{model}', [CarSaleFilterManagementController::class, 'updateModel']);
            Route::delete('/models/{model}', [CarSaleFilterManagementController::class, 'deleteModel']);

            // Trims Management
            Route::post('/trims', [CarSaleFilterManagementController::class, 'addTrim']);
            Route::put('/trims/{trim}', [CarSaleFilterManagementController::class, 'updateTrim']);
            Route::delete('/trims/{trim}', [CarSaleFilterManagementController::class, 'deleteTrim']);
        });

        Route::get('/offer-box-settings', [OfferBoxSettingsController::class, 'index']);
        Route::post('/offer-box-settings', [OfferBoxSettingsController::class, 'store']);
    });
    Route::get('/system-settings', [SystemSettingsController::class, 'index']);
    Route::post('/system-settings', [SystemSettingsController::class, 'store']);
    Route::put('/system-settings/{setting:key}', [SystemSettingsController::class, 'update']);

});