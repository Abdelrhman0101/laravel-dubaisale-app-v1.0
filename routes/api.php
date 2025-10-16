<?php


use App\Http\Controllers\Api\OtherServiceAdsController;
use App\Http\Controllers\ElectronicAdOptionController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\OtherServiceOptionsController;
use App\Http\Controllers\PageController;
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
use App\Http\Controllers\Api\JobsAdController;
use App\Http\Controllers\Api\ElectronicAdController;



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
use App\Http\Controllers\JobAdValuesController;
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

Route::post('/newSignin', [AuthController::class, 'signup']);
Route::post('/activate', [AuthController::class, 'activate']);
// Route::middleware(['SecureEndpoint'])->group(function () {
Route::put('/verify', [AuthController::class, 'verifyOtp']);
Route::post('/resend-otp', [AuthController::class, 'resendOtp']);
// تم إلغاء مسار التحويل غير الآمن بالمعرف
// Route::post('/convert-to-advertiser/{id}', [UserController::class, 'convertToAdvertiser']);
// مسار آمن لطلب OTP بناءً على رقم الهاتف
Route::post('/request-otp', [AuthController::class, 'requestOtp']);
Route::post('/convert-to-advertiser/{id}', [UserController::class, 'convertToAdvertiser']);
// });

//all ads for specfic user
Route::get('/user-ads/{user_id}', [MyAdsController::class, 'userAds']);


//pages
Route::get('/pages', [PageController::class, 'index']);
Route::get('/pages/{type}', [PageController::class, 'show']);

// --- Featured & Public Content ---
Route::get('/best-advertisers/{categorySlug}', [FeaturedContentController::class, 'getBestAdvertisers']);
Route::get('/users/{user}/ads/{category}', [FeaturedContentController::class, 'getUserAdsByCategory']);
Route::get('/offers-box/{category}', [FeaturedContentController::class, 'getOfferBoxAds']);
Route::get('/settings', [PublicSettingsController::class, 'index']);
Route::get('/locations/emirates', [\App\Http\Controllers\Api\LocationsController::class, 'index']);

// --- Restaurants (Public) ---
Route::get('/restaurants', [\App\Http\Controllers\Api\RestaurantAdController::class, 'index']);
Route::get('/restaurants/search', [\App\Http\Controllers\Api\RestaurantAdController::class, 'search']);
Route::get('/restaurants/offers-box/ads', [\App\Http\Controllers\Api\RestaurantAdController::class, 'getOffersBoxAds']);
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

//real-estate public 
Route::get('/real-estates', [RealEstateAdController::class, 'index']);
Route::get('/real-estates/search', [RealEstateAdController::class, 'search']);
Route::get('/real-estates/offers-box/ads', [RealEstateAdController::class, 'getOffersBoxAds']);
Route::get('/real-estates/{realEstateAd}', [RealEstateAdController::class, 'show']);


// --- Public Filter Data ---
Route::get('/car-sales-filters', [CarSalesFiltersController::class, 'index']);
route::get('/makes-with-models', [CarSaleFilterManagementController::class, 'getMakesWithModels']);
Route::prefix('filters/car-sale')->group(function () {
    Route::get('/makes', [CarSaleFilterManagementController::class, 'getMakes']);
    Route::get('/makes/{make}/models', [CarSaleFilterManagementController::class, 'getModels']);
    Route::get('/models/{model}/trims', [CarSaleFilterManagementController::class, 'getTrims']);

    Route::get('/models', [CarSaleFilterManagementController::class, 'getAllModels']);
});

// --- Car Sales Ad Specifications (Public) ---
Route::get('/car-sales-ad-specs', [CarSalesAdSpecController::class, 'getClientSpecs']);
//--- Real Estate Ad options
Route::get('/real_estate_options', [RealEstateAdOptionsController::class, 'getClientSpecs']);
// values of table jobs Ads
Route::get('/jobs_ad_values', [JobAdValuesController::class, 'getClientSpecs']);

// --- Car Service Types (Public) ---
Route::get('/car-service-types', [CarServiceTypeController::class, 'getClientOptions']);

//--- electronic 
Route::get('/electronic_ad_options', [ElectronicAdOptionController::class, 'getClientSpecs']);

//---other service 
Route::get('/other_service_options', [OtherServiceOptionsController::class, 'getClientSpecs']);

// --- Car Sales Ads (Public) ---
Route::get('/car-sales-ads', [CarSalesAdController::class, 'index']);
Route::get('/car-sales-ads/search', [CarSalesAdController::class, 'search']);
Route::get('/car-sales-ads/offers-box/ads', [CarSalesAdController::class, 'getOffersBoxAds']);
Route::get('/car-sales-ads/{carSalesAd}', [CarSalesAdController::class, 'show']);

// --- Car Services Search & Filters (Public) ---
Route::get('/car-services/search', [CarServicesAdController::class, 'search']);
Route::get('/car-services/filters', [CarServicesAdController::class, 'getSearchFilters']);
Route::get('/car-services', [CarServicesAdController::class, 'index']);
Route::get('/car-services/{carServicesAd}', [CarServicesAdController::class, 'show']);
Route::get('/car-services/offers-box/ads', [CarServicesAdController::class, 'getOffersBoxAds']);

// Car Services Ads - Public Routes
Route::prefix('car-services-ads')->group(function () {
    Route::get('/', [CarServicesAdController::class, 'index']);
    Route::get('/search', [CarServicesAdController::class, 'search']);
    Route::get('/offers-box/ads', [CarServicesAdController::class, 'getOffersBoxAds']);
    Route::get('/{id}', [CarServicesAdController::class, 'show']);
});

// --- Car Rent Search & Filters (Public) ---
Route::get('/car-rent/search', [CarRentAdController::class, 'search']);
Route::get('/car-rent', [CarRentAdController::class, 'index']);
Route::get('/car-rent/{carRentAd}', [CarRentAdController::class, 'show']);
Route::get('/car-rent/offers-box/ads', [CarRentAdController::class, 'getOffersBoxAds']);

// Car Rent Ads - Public Routes
Route::prefix('car-rent-ads')->group(function () {
    Route::get('/', [CarRentAdController::class, 'index']);
    Route::get('/search', [CarRentAdController::class, 'search']);
    Route::get('/offers-box/ads', [CarRentAdController::class, 'getOffersBoxAds']);
    Route::get('/{id}', [CarRentAdController::class, 'show']);
});

// --- Job Ads (Public) ---
Route::get('/jobs', [JobsAdController::class, 'index']);
// Route::get('/jobs/search', [\App\Http\Controllers\JobsAdController::class, 'search']);
Route::get('/jobs/offers-box/ads', [JobsAdController::class, 'getOffersBoxAds']);
Route::get('/jobs/{jobAd}', [JobsAdController::class, 'show']);

Route::get('/job-category-images', [JobsAdController::class, 'getCategoryImages']);

// --- Electronics Ads (Public) ---
Route::get('/electronics', [ElectronicAdController::class, 'index']);
Route::get('/electronics/search', [ElectronicAdController::class, 'search']);
Route::get('/electronics/offers-box/ads', [ElectronicAdController::class, 'getOffersBoxAds']);
Route::get('/electronics/{id}', [ElectronicAdController::class, 'show']);

//---- Other Service Ads (Public) ---
Route::get('/other-services', [OtherServiceAdsController::class, 'index']);
Route::get('/other-services/search', [OtherServiceAdsController::class, 'search']);
Route::get('/other-services/offers-box/ads', [OtherServiceAdsController::class, 'getOffersBoxAds']);
Route::get('/other-services/{id}', [OtherServiceAdsController::class, 'show']);


Route::get('/locations/districts', [\App\Http\Controllers\Api\Admin\LocationsController::class, 'getAllDistricts']);
Route::get('/system-settings/plans', [SystemSettingsController::class, 'getPlansSettings']);
Route::get('/system-settings', [SystemSettingsController::class, 'index']);
/*
|--------------------------------------------------------------------------
| Authenticated User Routes (Requires Bearer Token from Sanctum)
|--------------------------------------------------------------------------
*/
// هذه المجموعة محمية بـ 'auth:sanctum' وهي لا تدعم الجلسات بشكل افتراضي
Route::middleware([
    'auth:sanctum',
    'EnsureUserIsVerified',
    'EnsureUserIsAdvertiser'
])->group(function () {

    // --- User & Profile Management ---
    Route::get('/user', fn(Request $request) => $request->user());
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/profile', [ProfileController::class, 'update']);
    Route::post('/profile/password', [ProfileController::class, 'changePassword']);
    Route::post('/upload', [UploadController::class, 'upload']);

    //favorites
    Route::get('/favorites', [FavoritesController::class, 'index']);
    Route::post('/favorites', [FavoritesController::class, 'store']);
    Route::delete('/favorites', [FavoritesController::class, 'destroy']);

    // --- User's Ads & Offers Management ---
    Route::get('/my-ads', [MyAdsController::class, 'index']);
    Route::apiResource('car-sales-ads', CarSalesAdController::class)->except(['index', 'show']);
    Route::apiResource('car-services-ads', CarServicesAdController::class)->except(['index', 'show']);;
    Route::apiResource('car-rent-ads', CarRentAdController::class);

    // --- Restaurants (CRUD Authenticated) ---
    Route::post('/restaurants', [RestaurantAdController::class, 'store']);
    Route::put('/restaurants/{restaurantAd}', [RestaurantAdController::class, 'update']);
    Route::patch('/restaurants/{restaurantAd}', [RestaurantAdController::class, 'update']);
    Route::delete('/restaurants/{restaurantAd}', [RestaurantAdController::class, 'destroy']);

    // --- real state (CRUD Authenticated) ---

    Route::post('/real-estate', [RealEstateAdController::class, 'store']);
    Route::put('/real-estate/{realEstateAd}', [RealEstateAdController::class, 'update']);
    Route::post('/real-estate/{realEstateAd}', [RealEstateAdController::class, 'approveAd']);
    Route::delete('/real-estate/{realEstateAd}', [RealEstateAdController::class, 'destroy']);

    // --- Jobs (CRUD Authenticated) ---
    Route::post('/jobs', [JobsAdController::class, 'store']);
    Route::put('/jobs/{jobAd}', [JobsAdController::class, 'update']);
    Route::post('/jobs/{jobAd}', [JobsAdController::class, 'approveAd']);
    Route::delete('/jobs/{jobAd}', [JobsAdController::class, 'destroy']);

    // --- Electronics (CRUD Authenticated) ---
    Route::post('/electronics', [ElectronicAdController::class, 'store']);
    Route::put('/electronics/{id}', [ElectronicAdController::class, 'update']);
    Route::delete('/electronics/{id}', [ElectronicAdController::class, 'destroy']);

    // --- Other Service Ads (CRUD Authenticated) ---
    Route::post('/other-services', [OtherServiceAdsController::class, 'store']);
    Route::put('/other-services/{ad}', [OtherServiceAdsController::class, 'update']);
    Route::post('/other-services/{ad}', [OtherServiceAdsController::class, 'approveAd']);
    Route::delete('/other-services/{ad}', [OtherServiceAdsController::class, 'destroy']);

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

        // System Settings

        Route::post('/system-settings', [SystemSettingsController::class, 'store']);
        Route::post('/system-settings/create', [SystemSettingsController::class, 'createSetting']);
        Route::put('/system-settings/{setting:key}', [SystemSettingsController::class, 'update']);
        Route::delete('/system-settings/{setting:key}', [SystemSettingsController::class, 'deleteSetting']);

        // Locations (Emirates & Districts)
        Route::get('/locations/emirates', [\App\Http\Controllers\Api\Admin\LocationsController::class, 'index']);

        Route::post('/locations/emirates', [\App\Http\Controllers\Api\Admin\LocationsController::class, 'upsertEmirate']);
        Route::post('/locations/emirates/{emirate}/districts', [\App\Http\Controllers\Api\Admin\LocationsController::class, 'upsertDistricts']);
        Route::delete('/locations/emirates/{emirate}/district', [\App\Http\Controllers\Api\Admin\LocationsController::class, 'deleteDistrict']);
        Route::put('/locations/emirates/{emirate}', [\App\Http\Controllers\Api\Admin\LocationsController::class, 'renameEmirate']);

        // --- Admin: Car Rent Ads Management ---
        Route::get('/car-rent-ads', [CarRentAdController::class, 'indexForAdmin']);
        Route::get('/car-rent-ads/pending', [CarRentAdController::class, 'getPendingAds']);
        Route::post('/car-rent-ads/{carRentAd}/approve', [CarRentAdController::class, 'approveAd']);
        Route::post('/car-rent-ads/{carRentAd}/reject', [CarRentAdController::class, 'rejectAd']);

        // --- Admin: Job Ads Management ---
        Route::get('/job-ads', [JobsAdController::class, 'indexForAdmin']);
        Route::get('/job-ads/pending', [JobsAdController::class, 'getPendingAds']);
        Route::post('/job-ads/{jobAd}/approve', [JobsAdController::class, 'approveAd']);
        Route::post('/job-ads/{jobAd}/reject', [JobsAdController::class, 'rejectAd']);

        // --- Admin: Electronics Ads Management ---
        Route::get('/electronics-ads', [ElectronicAdController::class, 'indexForAdmin']);
        Route::get('/electronics-ads/pending', [ElectronicAdController::class, 'getPendingAds']);
        Route::post('/electronics-ads/{id}/approve', [ElectronicAdController::class, 'approveAd']);
        Route::post('/electronics-ads/{id}/reject', [ElectronicAdController::class, 'rejectAd']);


        // -- Admin: Real Estate Ads options  Management ---
        Route::post('/real_estate_options', [RealEstateAdOptionsController::class, 'bulkUpdateSpecs']);
        Route::get('/real_estate_options/{fieldName}', [RealEstateAdOptionsController::class, 'getSpecByField']);
        Route::put('/real_estate_options/{fieldName}', [RealEstateAdOptionsController::class, 'updateSpec']);
        Route::delete('/real_estate_options', [RealEstateAdOptionsController::class, 'bulkDeleteSpecs']);

        // -- Admin: Other Service Options Management ---
        Route::post('/other_service_options', [OtherServiceOptionsController::class, 'bulkUpdateSpecs']);
        Route::get('/other_service_options/{fieldName}', [OtherServiceOptionsController::class, 'getSpecByField']);
        Route::put('/other_service_options/{fieldName}', [OtherServiceOptionsController::class, 'updateSpec']);
        Route::delete('/other_service_options', [OtherServiceOptionsController::class, 'bulkDeleteSpecs']);

        // -- Admin: Electronic Ads Options Management ---
        Route::post('/electronic_ad_options', [ElectronicAdOptionController::class, 'bulkUpdateSpecs']);
        Route::get('/electronic_ad_options/{fieldName}', [ElectronicAdOptionController::class, 'getSpecByField']);
        Route::put('/electronic_ad_options/{fieldName}', [ElectronicAdOptionController::class, 'updateSpec']);
        Route::delete('/electronic_ad_options', [ElectronicAdOptionController::class, 'bulkDeleteSpecs']);

        // -- Admin: Job Ads Values Management ---
        Route::post('/jobs_ad_values', [JobAdValuesController::class, 'bulkUpdateSpecs']);
        Route::get('/jobs_ad_values/{fieldName}', [JobAdValuesController::class, 'getSpecByField']);
        Route::put('/jobs_ad_values/{fieldName}', [JobAdValuesController::class, 'updateSpec']);
        Route::delete('/jobs_ad_values', [JobAdValuesController::class, 'bulkDeleteSpecs']);
    });
});
