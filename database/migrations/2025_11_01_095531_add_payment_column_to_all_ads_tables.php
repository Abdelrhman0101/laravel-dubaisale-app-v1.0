<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tables = [
            'car_services_ads',
            'car_sales_ads',
            'car_rent_ads',
            'other_service_ads',
            'job_ads',
            'electronics_home_ads',
            'real_estate_ads',
            'restaurant_ads'
        ];

        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName) && !Schema::hasColumn($tableName, 'payment')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->boolean('payment')->default(false);
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = [
            'car_services_ads',
            'car_sales_ads',
            'car_rent_ads',
            'other_service_ads',
            'job_ads',
            'electronics_home_ads',
            'real_estate_ads',
            'restaurant_ads'
        ];

        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName) && Schema::hasColumn($tableName, 'payment')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->dropColumn('payment');
                });
            }
        }
    }
};
