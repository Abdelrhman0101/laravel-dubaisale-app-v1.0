<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// --- Controllers ---
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MyAdsController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\CarSalesAdController;
use App\Http\Controllers\Api\CarServicesAdController;
use App\Http\Controllers\Api\FeaturedContentController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\Api\OfferBoxActivationController;
use App\Http\Controllers\Api\PublicSettingsController;
use App\Http\Controllers\Api\RestaurantAdController;


// --- Filter Controllers ---
use App\Http\Controllers\Api\Filters\CarSalesFiltersController;
use App\Http\Controllers\Api\CarServiceTypeController;

// --- Admin Controllers ---
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\Admin\BestAdvertiserController;
use App\Http\Controllers\Api\Admin\CarSaleFilterManagementController;
use App\Http\Controllers\Api\Admin\OfferBoxSettingsController;
use App\Http\Controllers\Api\Admin\SystemSettingsController;
use App\Http\Controllers\CarSalesAdSpecController;
use App\Http\Controllers\UserContactInfoController;


// --- Middleware ---
use App\Http\Middleware\IsAdmin;


/*
|--------------------------------------------------------------------------
| Public API Routes (No Authentication Needed)
|--------------------------------------------------------------------------
*/

// --- Authentication ---
// هذا هو التغيير الرئيسي: نحن نطبق middleware 'web' على هذا الـ route مباشرة
// لضمان تشغيل الجلسات (Sessions) له
Route::post('/login', [AuthController::class, 'login']);

Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/activate', [AuthController::class, 'activate']);


// --- Featured & Public Content ---
Route::get('/best-advertisers', [FeaturedContentController::class, 'getBestAdvertisers']);
Route::get('/users/{user}/ads/{category}', [FeaturedContentController::class, 'getUserAdsByCategory']);
Route::get('/offers-box/{category}', [FeaturedContentController::class, 'getOfferBoxAds']);
Route::get('/settings', [PublicSettingsController::class, 'index']);
Route::get('/locations/emirates', [\App\Http\Controllers\Api\LocationsController::class, 'index']);

// --- Restaurants (Public) ---
Route::get('/restaurants', [RestaurantAdController::class, 'index']);
Route::get('/restaurants/{restaurantAd}', [RestaurantAdController::class, 'show']);


// --- Public Filter Data ---
Route::get('/car-sales-filters', [CarSalesFiltersController::class, 'index']);
Route::prefix('filters/car-sale')->group(function () {
    Route::get('/makes', [CarSaleFilterManagementController::class, 'getMakes']);
    Route::get('/makes/{make}/models', [CarSaleFilterManagementController::class, 'getModels']);
    Route::get('/models/{model}/trims', [CarSaleFilterManagementController::class, 'getTrims']);
});

// --- Car Sales Ad Specifications (Public) ---
Route::get('/car-sales-ad-specs', [CarSalesAdSpecController::class, 'getClientSpecs']);

// --- Car Service Types (Public) ---
Route::get('/car-service-types', [CarServiceTypeController::class, 'getClientOptions']);

// --- Car Services Search & Filters (Public) ---
Route::get('/car-services/search', [CarServicesAdController::class, 'search']);
Route::get('/car-services/filters', [CarServicesAdController::class, 'getSearchFilters']);
Route::get('/car-services', [CarServicesAdController::class, 'index']);
Route::get('/car-services/{carServicesAd}', [CarServicesAdController::class, 'show']);
Route::get('/car-services/offers-box/ads', [CarServicesAdController::class, 'getOffersBoxAds']);


/*
|--------------------------------------------------------------------------
| Authenticated User Routes (Requires Bearer Token from Sanctum)
|--------------------------------------------------------------------------
*/
// هذه المجموعة محمية بـ 'auth:sanctum' وهي لا تدعم الجلسات بشكل افتراضي
Route::middleware('auth:sanctum')->group(function () {
    
    // --- User & Profile Management ---
    Route::get('/user', fn(Request $request) => $request->user());
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/profile', [ProfileController::class, 'update']);
    Route::post('/profile/password', [ProfileController::class, 'changePassword']);
    Route::post('/upload', [UploadController::class, 'upload']);

    // --- User's Ads & Offers Management ---
    Route::get('/my-ads', [MyAdsController::class, 'index']);
    Route::apiResource('car-sales-ads', CarSalesAdController::class);
    Route::apiResource('car-services-ads', CarServicesAdController::class);
    
    // --- Restaurants (CRUD Authenticated) ---
    Route::post('/restaurants', [RestaurantAdController::class, 'store']);
    Route::put('/restaurants/{restaurantAd}', [RestaurantAdController::class, 'update']);
    Route::patch('/restaurants/{restaurantAd}', [RestaurantAdController::class, 'update']);
    Route::delete('/restaurants/{restaurantAd}', [RestaurantAdController::class, 'destroy']);

    Route::post('/offers-box/activate', [OfferBoxActivationController::class, 'activate']);

    // --- User Contact Information Management ---
    Route::prefix('contact-info')->group(function () {
        Route::get('/', [UserContactInfoController::class, 'getContactInfo']);
        Route::post('/add-item', [UserContactInfoController::class, 'addContactItem']);
        Route::delete('/remove-item', [UserContactInfoController::class, 'removeContactItem']);
        Route::put('/bulk-update', [UserContactInfoController::class, 'bulkUpdateContactInfo']);
        Route::post('/initialize', [UserContactInfoController::class, 'initializeFromUserData']);
    });

    /*
    |--------------------------------------------------------------------------
    | Admin-Only Routes (Requires Admin Role)
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->middleware(IsAdmin::class)->group(function () {
        
        // --- Admin: Car Sales Ads Management ---
        Route::get('/car-sales-ads', [CarSalesAdController::class, 'indexForAdmin']);
        Route::get('/car-sales-ads/pending', [CarSalesAdController::class, 'getPendingAds']);
        Route::get('/car-sales/stats', [CarSalesAdController::class, 'getStats']);
        Route::post('/car-sales-ads/{carSalesAd}/approve', [CarSalesAdController::class, 'approveAd']);
        Route::post('/car-sales-ads/{carSalesAd}/reject', [CarSalesAdController::class, 'rejectAd']);
        
        // --- Admin: Car Services Ads Management ---
        Route::get('/car-services-ads', [CarServicesAdController::class, 'indexForAdmin']);
        Route::get('/car-services/stats', [CarServicesAdController::class, 'getStats']);
        Route::post('/car-services-ads/{carServicesAd}/approve', [CarServicesAdController::class, 'approveAd']);
        Route::post('/car-services-ads/{carServicesAd}/reject', [CarServicesAdController::class, 'rejectAd']);

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

        // --- Admin: Car Sales Ad Specifications Management ---
        Route::prefix('car-sales-ad-specs')->group(function () {
            Route::get('/', [CarSalesAdSpecController::class, 'getAdminSpecs']);
            Route::get('/{fieldName}', [CarSalesAdSpecController::class, 'getSpecByField']);
            Route::put('/{fieldName}', [CarSalesAdSpecController::class, 'updateSpec']);
            Route::post('/bulk-update', [CarSalesAdSpecController::class, 'bulkUpdateSpecs']);
        });
        
        // --- Admin: Car Service Types Management ---
        Route::apiResource('car-service-types', CarServiceTypeController::class);
        Route::post('/car-service-types/bulk-update', [CarServiceTypeController::class, 'bulkUpdate']);
        Route::post('/car-service-types/{carServiceType}/toggle-active', [CarServiceTypeController::class, 'toggleActive']);

        // --- Admin: Offer Box & System Settings ---
        Route::get('/offer-box-settings', [OfferBoxSettingsController::class, 'index']);
        Route::post('/offer-box-settings', [OfferBoxSettingsController::class, 'store']);
        Route::get('/system-settings', [SystemSettingsController::class, 'index']);
        Route::post('/system-settings', [SystemSettingsController::class, 'store']);
        Route::put('/system-settings/{setting:key}', [SystemSettingsController::class, 'update']);

        // Locations (Emirates & Districts)
        Route::get('/locations/emirates', [\App\Http\Controllers\Api\Admin\LocationsController::class, 'index']);
        Route::post('/locations/emirates', [\App\Http\Controllers\Api\Admin\LocationsController::class, 'upsertEmirate']);
        Route::post('/locations/emirates/{emirate}/districts', [\App\Http\Controllers\Api\Admin\LocationsController::class, 'upsertDistricts']);
        Route::delete('/locations/emirates/{emirate}/district', [\App\Http\Controllers\Api\Admin\LocationsController::class, 'deleteDistrict']);
        Route::put('/locations/emirates/{emirate}', [\App\Http\Controllers\Api\Admin\LocationsController::class, 'renameEmirate']);
    });

});