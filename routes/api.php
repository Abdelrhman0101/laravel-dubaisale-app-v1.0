<?php


use App\Http\Controllers\RealEstateAdOptionsController;
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
use App\Http\Controllers\Api\CarRentAdController;
use App\Http\Controllers\Api\RealEstateAdController;


// --- Filter Controllers ---
use App\Http\Controllers\Api\Filters\CarSalesFiltersController;
use App\Http\Controllers\Api\CarServiceTypeController;

// --- Admin Controllers ---
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\Admin\BestAdvertiserController;
use App\Http\Controllers\Api\Admin\CarSaleFilterManagementController;
use App\Http\Controllers\Api\Admin\OfferBoxSettingsController;
use App\Http\Controllers\Api\Admin\SystemSettingsController;
use App\Http\Controllers\Api\Admin\RestaurantCategoryController;
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
Route::get('/best-advertisers/{categorySlug}', [FeaturedContentController::class, 'getBestAdvertisers']);
Route::get('/users/{user}/ads/{category}', [FeaturedContentController::class, 'getUserAdsByCategory']);
Route::get('/offers-box/{category}', [FeaturedContentController::class, 'getOfferBoxAds']);
Route::get('/settings', [PublicSettingsController::class, 'index']);
Route::get('/locations/emirates', [\App\Http\Controllers\Api\LocationsController::class, 'index']);

// --- Restaurants (Public) ---
Route::get('/restaurants', [\App\Http\Controllers\Api\RestaurantAdController::class, 'index']);
Route::get('/restaurants/{restaurantAd}', [\App\Http\Controllers\Api\RestaurantAdController::class, 'show']);

// --- Restaurant Categories (Public) ---
Route::get('/restaurant-categories', function (Request $request) {
    $onlyActive = $request->boolean('only_active', true);
    $query = \App\Models\RestaurantCategory::query();
    if ($onlyActive) {
        $query->where('active', true);
    }
    $categories = $query->orderBy('sort_order')->orderBy('name')->get(['id', 'name', 'active', 'sort_order']);
    return response()->json($categories);
});


// --- Public Filter Data ---
Route::get('/car-sales-filters', [CarSalesFiltersController::class, 'index']);
Route::prefix('filters/car-sale')->group(function () {
    Route::get('/makes', [CarSaleFilterManagementController::class, 'getMakes']);
    Route::get('/makes/{make}/models', [CarSaleFilterManagementController::class, 'getModels']);
    Route::get('/models/{model}/trims', [CarSaleFilterManagementController::class, 'getTrims']);
});

// --- Car Sales Ad Specifications (Public) ---
Route::get('/car-sales-ad-specs', [CarSalesAdSpecController::class, 'getClientSpecs']);
Route::get('/real_estate_options', [RealEstateAdOptionsController::class, 'getClientSpecs']);

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
    Route::apiResource('car-rent-ads', CarRentAdController::class);

    // --- Restaurants (CRUD Authenticated) ---
    Route::post('/restaurants', [RestaurantAdController::class, 'store']);
    Route::put('/restaurants/{restaurantAd}', [RestaurantAdController::class, 'update']);
    Route::patch('/restaurants/{restaurantAd}', [RestaurantAdController::class, 'update']);
    Route::delete('/restaurants/{restaurantAd}', [RestaurantAdController::class, 'destroy']);

    // --- real state (CRUD Authenticated) ---
    Route::get('/real-estates', [RealEstateAdController::class, 'index']);
    Route::get('/real-estate/{realEstateAd}', [RealEstateAdController::class, 'show']);
    Route::post('/real-estate', [RealEstateAdController::class, 'store']);
    Route::put('/real-estate/{realEstateAd}', [RealEstateAdController::class, 'update']);
    Route::post('/real-estate/{realEstateAd}', [RealEstateAdController::class, 'approveAd']);
    Route::delete('/real-estate/{realEstateAd}', [RealEstateAdController::class, 'destroy']);
    Route::get('/real-estates/offers-box-ads', [RealEstateAdController::class, 'offersBoxAds']);


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

        //Real State
        Route::put('/real-estate/{realEstateAd}/approve', [RealEstateAdController::class, 'approveAd']);

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

        // --- Admin: Restaurant Categories Management ---
        Route::apiResource('restaurant-categories', RestaurantCategoryController::class);

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

// --- Car Rent Search & Filters (Public) ---
Route::get('/car-rent/search', [CarRentAdController::class, 'search']);
Route::get('/car-rent', [CarRentAdController::class, 'index']);
Route::get('/car-rent/{carRentAd}', [CarRentAdController::class, 'show']);
Route::get('/car-rent/offers-box/ads', [CarRentAdController::class, 'getOffersBoxAds']);

// --- Admin: Car Rent Ads Management ---
Route::middleware(['auth:sanctum', IsAdmin::class])->group(function () {
    Route::get('/car-rent-ads', [CarRentAdController::class, 'indexForAdmin']);
    Route::get('/car-rent/stats', [CarRentAdController::class, 'getStats']);
    Route::post('/car-rent-ads/{carRentAd}/approve', [CarRentAdController::class, 'approveAd']);
    Route::post('/car-rent-ads/{carRentAd}/reject', [CarRentAdController::class, 'rejectAd']);
});