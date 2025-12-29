<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CarSalesAd;
use App\Models\CarServicesAd;
use App\Models\RestaurantAd;
use App\Models\CarRentAd;
use App\Models\JobAd;
use App\Models\electronicAd;
use App\Models\OtherServiceAds;
use App\Models\RealEstateAd;
use App\Models\SystemSetting;
use Carbon\Carbon;

class CheckAdsExpiry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ads:check-expiry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and expire ads that have passed their validity period.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting ads expiry check...');

        // List of models to check
        $models = [
            'Car Sales' => CarSalesAd::class,
            'Car Services' => CarServicesAd::class,
            'Restaurants' => RestaurantAd::class,
            'Car Rent' => CarRentAd::class,
            'Jobs' => JobAd::class,
            'Electronics' => electronicAd::class,
            'Other Services' => OtherServiceAds::class,
            'Real Estate' => RealEstateAd::class,
        ];

        // Cache settings to avoid DB hits inside loops
        $settings = SystemSetting::all()->pluck('value', 'key');
        
        foreach ($models as $name => $modelClass) {
            $this->info("Processing {$name}...");
            
            // Fetch all active/valid ads
            // We use chunking to handle large datasets efficiently
            $modelClass::where('add_status', 'Valid')
                ->chunk(100, function ($ads) use ($settings) {
                    foreach ($ads as $ad) {
                        $this->checkAndExpireAd($ad, $settings);
                    }
                });
        }

        $this->info('Ads expiry check completed successfully.');
    }

    private function checkAndExpireAd($ad, $settings)
    {
        // 1. Determine Expiry Date
        $expiresAt = null;

        if (!empty($ad->plan_expires_at)) {
            // Use stored expiry date if available
            $expiresAt = $ad->plan_expires_at instanceof Carbon 
                ? $ad->plan_expires_at 
                : Carbon::parse($ad->plan_expires_at);
        } else {
            // Calculate based on settings
            $planType = strtolower($ad->plan_type ?? 'free');
            $settingKey = "plan_{$planType}_days";
            
            // Get duration, default to global free duration or 30 days
            if (isset($settings[$settingKey])) {
                $days = (int) $settings[$settingKey];
            } elseif ($planType === 'free' || $planType === 'standard') {
                $days = (int) ($settings['free_ads_duration'] ?? $settings['free_ad_duration'] ?? 30);
            } else {
                $days = 30; // Fallback
            }

            $expiresAt = $ad->created_at->copy()->addDays($days);
        }

        // 2. Check if Expired
        if ($expiresAt && $expiresAt->isPast()) {
            $ad->update(['add_status' => 'Expired']);
            // $this->line("Expired ad ID: {$ad->id} - Type: {$ad->getTable()}");
        }
    }
}
