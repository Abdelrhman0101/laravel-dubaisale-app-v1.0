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
        Schema::table('all_ads_tables', function (Blueprint $table) {
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


            foreach ($tables as $table) {
                if (Schema::hasTable($table) && !Schema::hasColumn($table, 'payment')) {
                    Schema::table($table, function (Blueprint $table) {
                        $table->boolean('payment')
                            ->default(false)->nullable();
                            // ->after('price');
                    });
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('all_ads_tables', function (Blueprint $table) {
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
            foreach ($tables as $table) {
                if (Schema::hasTable($table) && Schema::hasColumn($table, 'payment')) {
                    Schema::table($table, function (Blueprint $table) {
                        $table->dropColumn('payment');
                    });
                }
            }
        });
    }
};
