<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\CarSalesAd;
use App\Models\CarServicesAd;
use App\Models\RestaurantAd;
use App\Models\CarRentAd;
use App\Models\RealEstateAd;
use App\Models\JobAd;
use App\Models\electronicAd;
use App\Models\OtherServiceAds;
use App\Models\SystemSetting;
use App\Traits\PackageHelper;
use Carbon\Carbon;

class RenewAdController extends Controller
{
    use PackageHelper;

    /**
     * Map category slugs to Model classes.
     */
    protected $modelMap = [
        'car_sales' => CarSalesAd::class,
        'car_services' => CarServicesAd::class,
        'restaurant' => RestaurantAd::class,
        'car_rent' => CarRentAd::class,
        'real_estate' => RealEstateAd::class, // normalized slug
        'real-estate' => RealEstateAd::class, // potential variance
        'jobs' => JobAd::class,
        'electronics' => electronicAd::class,
        'other_services' => OtherServiceAds::class,
        'other-services' => OtherServiceAds::class,
    ];

    /**
     * Renew an expired ad.
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function renew(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ad_id' => 'required|integer',
            'category_slug' => 'required|string',
            'plan_type' => 'nullable|string|in:featured,premium_star,premium,free',
            'payment' => 'nullable|boolean' // Mock payment flag from frontend
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $slug = strtolower($request->category_slug);
        
        // Normalize slug handling
        if (!isset($this->modelMap[$slug])) {
            return response()->json(['error' => 'Invalid category slug.'], 400);
        }

        $modelClass = $this->modelMap[$slug];
        $user = $request->user();

        // Find the Ad
        // We find it regardless of status, but typically it should be Expired
        $ad = $modelClass::where('id', $request->ad_id)
            ->where('user_id', $user->id)
            ->first();

        if (!$ad) {
            return response()->json(['error' => 'Ad not found or unauthorized.'], 404);
        }

        // --- Renewal Logic ---

        // 1. Determine Plan to Renew As
        // If user sends a new plan_type (e.g. upgrading during renewal), use it.
        // Otherwise, use the ad's existing plan_type or default to 'free'.
        $planType = $request->input('plan_type', $ad->plan_type ?? 'free');

        // 2. Handle Payment / Package Deduction
        if ($planType !== 'free') {
            // Attempt to deduct from package first
            $packageResult = $this->autoDeductAd($user, $planType);

            if ($packageResult['success']) {
                // Deducted successfully from user's active package
                $planType = $packageResult['package_type'];
            } else {
                // No package balance available.
                // Check if 'payment' flag is true (Simulating successful payment gateway)
                if ($request->boolean('payment')) {
                    // Payment success -> Proceed with renewal
                    // In a real app, you'd log the transaction here.
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'No active package found. Please pay to renew.',
                        'require_payment' => true // Signal frontend to show payment screen
                    ], 403);
                }
            }
        } else {
            // Free Renewal Check
            // Check if user exceeded free limit (optional, depends on business rule)
            // For now, we allow renewing free ads if within limit.
            
            $limitKey = $this->getFreeLimitKey($slug);
            $freeLimit = SystemSetting::getSetting($limitKey, 0); // Default 0 if not set? Or large number?
            
            // Count ACTIVE free ads only
            $activeFreeAds = $modelClass::where('user_id', $user->id)
                ->where('plan_type', 'free')
                ->where('add_status', 'Valid')
                ->count();

            if ($ad->add_status !== 'Valid' && $activeFreeAds >= (int)$freeLimit) {
                 return response()->json([
                    'success' => false,
                    'message' => 'You have reached your limit of active free ads. Upgrade to renew.',
                ], 403);
            }
        }

        // 3. Calculate New Expiry
        $days = $this->getPlanDuration($planType);
        $newExpiry = Carbon::now()->addDays($days);

        // 4. Update Ad
        $ad->plan_type = $planType;
        $ad->plan_expires_at = $newExpiry; // Explicitly set it now
        $ad->created_at = Carbon::now(); // Bump to top "Fresh Start"
        $ad->updated_at = Carbon::now();
        $ad->add_status = 'Valid';
        
        // Manual Approval Check (If system requires approval for renewals?)
        // Usually renewals are auto-approved if content didn't change, 
        // but let's check the setting to be safe/consistent.
        $manualApproval = filter_var(SystemSetting::getSetting('manual_approval_mode', 'true'), FILTER_VALIDATE_BOOLEAN);
        
        if ($manualApproval) {
            $ad->add_status = 'Pending';
            $ad->admin_approved = false;
        } else {
            $ad->add_status = 'Valid';
            $ad->admin_approved = true;
        }
        
        $ad->save();

        return response()->json([
            'success' => true,
            'message' => 'Ad renewed successfully.',
            'ad' => $ad
        ]);
    }

    /**
     * Get duration days for a plan from settings.
     */
    private function getPlanDuration($planType)
    {
        $settingKey = "plan_{$planType}_days";
        $days = SystemSetting::getSetting($settingKey);
        
        if (!$days) {
             if ($planType === 'free' || $planType === 'standard') {
                 $days = SystemSetting::getSetting('free_ad_duration', 30);
             } else {
                 $days = 30; 
             }
        }
        return (int)$days;
    }

    private function getFreeLimitKey($slug)
    {
        // Map slug to setting key suffix?
        // e.g. 'car_sales' -> 'free_ads_limit' (Global?) 
        // or 'free_ads_limit_car_sales' ?
        // Using global 'free_ads_limit' as primary fallback for now based on previous code.
        return 'free_ads_limit'; 
    }
}
