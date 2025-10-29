<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SearchIndex;
use App\Models\CarSalesAd;
use App\Models\RealEstateAd;
use App\Models\JobAd;
use App\Models\CarRentAd;
use App\Models\CarServicesAd;
use App\Models\ElectronicAd;
use App\Models\OtherServiceAds;
use App\Models\RestaurantAd;

class SearchIndexSeeder extends Seeder
{
    public function run()
    {
        SearchIndex::truncate();

        $map = [
            'Real State' => RealEstateAd::class,
            'Cars Sales' => CarSalesAd::class,
            'Car Rent' => CarRentAd::class,
            'Car Services' => CarServicesAd::class,
            'Restaurant' => RestaurantAd::class,
            'Job' => JobAd::class,
            'Electronics' => ElectronicAd::class,
            'Other Services' => OtherServiceAds::class,
        ];

        foreach ($map as $categoryName => $modelClass) {

            if (!class_exists($modelClass)) {
                $this->command->warn("⚠️ Model class not found: {$modelClass}");
                continue;
            }

            $ads = $modelClass::select('id', 'title')->get();

            foreach ($ads as $ad) {
                SearchIndex::create([
                    'item_type' => $categoryName,
                    'item_id' => $ad->id,
                    'category_slug' => $categoryName, 
                    'title' => $ad->title,
                ]);
            }

            $this->command->info("✅ Added {$ads->count()} ads from {$categoryName}");
        }

        $this->command->info('🎯 Search index seeding completed successfully!');
    }
}
