<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\Api\CarSalesAdController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\MyAdsController;
// === استدعاء الـ Controllers الجديدة الخاصة بالفلاتر ===
use App\Http\Controllers\Api\Filters\CarSalesFiltersController;
use App\Http\Controllers\Api\Admin\CarSaleFilterManagementController;
use App\Http\Middleware\IsAdmin;

/*
|--------------------------------------------------------------------------
| Public API Routes
|--------------------------------------------------------------------------
|
| Routes accessible by anyone, no authentication needed.
|
*/

// Authentication
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/activate', [AuthController::class, 'activate']);
Route::post('/login', [AuthController::class, 'login']);

// ---- Public Routes for Fetching Filter Data ----
// Endpoint رئيسي لجلب كل الفلاتر في رد واحد منظم للواجهة الأمامية
Route::get('/car-sales-filters', [CarSalesFiltersController::class, 'index']);

// Endpoints إضافية لجلب أجزاء معينة من الفلاتر (إذا احتاجتها الواجهة ديناميكيًا)
Route::prefix('filters/car-sale')->group(function () {
    Route::get('/makes', [CarSaleFilterManagementController::class, 'getMakes']);
    Route::get('/makes/{make}/models', [CarSaleFilterManagementController::class, 'getModels']);
    Route::get('/models/{model}/trims', [CarSaleFilterManagementController::class, 'getTrims']);
     // ==== Years Management ====
    Route::get('/years', [CarSaleFilterManagementController::class, 'getYears']);
    Route::post('/years', [CarSaleFilterManagementController::class, 'addYear']);
    Route::put('/years/{year}', [CarSaleFilterManagementController::class, 'updateYear']);
    Route::delete('/years/{year}', [CarSaleFilterManagementController::class, 'deleteYear']);
});


/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
|
| Routes that require a valid Bearer Token (for any logged-in user).
|
*/
Route::middleware('auth:sanctum')->group(function () {
    // User & Profile
    Route::get('/user', fn(Request $request) => $request->user());
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/upload', [UploadController::class, 'upload']);
    Route::post('/profile', [ProfileController::class, 'update']);
    Route::post('/profile/password', [ProfileController::class, 'changePassword']);

    // Ads Management for the logged-in user
    Route::get('/my-ads', [MyAdsController::class, 'index']);
    Route::apiResource('car-sales-ads', CarSalesAdController::class);


    /*
    |--------------------------------------------------------------------------
    | Admin-Only Routes
    |--------------------------------------------------------------------------
    |
    | Routes protected by IsAdmin middleware.
    |
    */
    Route::prefix('admin')->middleware(IsAdmin::class)->group(function () {
        
        // Admin: Ads & Users Management
        Route::get('/ads', [CarSalesAdController::class, 'indexForAdmin']);
        Route::get('/ads/pending', [CarSalesAdController::class, 'getPendingAds']);
        Route::post('/ads/{carSalesAd}/approve', [CarSalesAdController::class, 'approveAd']);
        Route::post('/ads/{carSalesAd}/reject', [CarSalesAdController::class, 'rejectAd']);
        Route::post('/users', [UserController::class, 'store']);

        // ===== Admin: Car Sale Filters Management (The Corrected Version) =====
        Route::prefix('filters/car-sale')->group(function () {
            // Makes Management
            Route::get('/makes', [CarSaleFilterManagementController::class, 'getMakes']);
            Route::post('/makes', [CarSaleFilterManagementController::class, 'addMake']);
            Route::put('/makes/{make}', [CarSaleFilterManagementController::class, 'updateMake']);
            Route::delete('/makes/{make}', [CarSaleFilterManagementController::class, 'deleteMake']);
            
            // Models Management
            Route::get('/makes/{make}/models', [CarSaleFilterManagementController::class, 'getModels']);
            Route::post('/models', [CarSaleFilterManagementController::class, 'addModel']);
            Route::put('/models/{model}', [CarSaleFilterManagementController::class, 'updateModel']);
            Route::delete('/models/{model}', [CarSaleFilterManagementController::class, 'deleteModel']);

            // Trims Management
            Route::get('/models/{model}/trims', [CarSaleFilterManagementController::class, 'getTrims']);
            Route::post('/trims', [CarSaleFilterManagementController::class, 'addTrim']);
            Route::put('/trims/{trim}', [CarSaleFilterManagementController::class, 'updateTrim']);
            Route::delete('/trims/{trim}', [CarSaleFilterManagementController::class, 'deleteTrim']);

            // Years Management
            Route::get('/years', [CarSaleFilterManagementController::class, 'getYears']);
            Route::post('/years', [CarSaleFilterManagementController::class, 'addYear']);
            Route::put('/years/{year}', [CarSaleFilterManagementController::class, 'updateYear']);
            Route::delete('/years/{year}', [CarSaleFilterManagementController::class, 'deleteYear']);
        });
    });
});