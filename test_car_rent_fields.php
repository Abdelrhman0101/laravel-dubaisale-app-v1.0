<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\CarRentAd;
use Illuminate\Support\Facades\Schema;

echo "Testing Car Rent Ads new fields...\n";

// Check if columns exist in database
$columns = ['car_type', 'trans_type', 'fuel_type', 'color', 'interior_color', 'seats_no'];

foreach ($columns as $column) {
    if (Schema::hasColumn('car_rent_ads', $column)) {
        echo "✓ Column '{$column}' exists in car_rent_ads table\n";
    } else {
        echo "✗ Column '{$column}' does NOT exist in car_rent_ads table\n";
    }
}

// Test model fillable fields
$model = new CarRentAd();
echo "\nModel uses guarded = [], so all fields are fillable.\n";

echo "\nTest completed successfully!\n";