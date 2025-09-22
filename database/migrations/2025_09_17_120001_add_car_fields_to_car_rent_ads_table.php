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
        Schema::table('car_rent_ads', function (Blueprint $table) {
            if (!Schema::hasColumn('car_rent_ads', 'car_type')) {
                $table->string('car_type')->nullable()->after('year');
            }
            if (!Schema::hasColumn('car_rent_ads', 'trans_type')) {
                $table->string('trans_type')->nullable()->after('car_type');
            }
            if (!Schema::hasColumn('car_rent_ads', 'fuel_type')) {
                $table->string('fuel_type')->nullable()->after('trans_type');
            }
            if (!Schema::hasColumn('car_rent_ads', 'color')) {
                $table->string('color')->nullable()->after('fuel_type');
            }
            if (!Schema::hasColumn('car_rent_ads', 'interior_color')) {
                $table->string('interior_color')->nullable()->after('color');
            }
            if (!Schema::hasColumn('car_rent_ads', 'seats_no')) {
                $table->integer('seats_no')->nullable()->after('interior_color');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('car_rent_ads', function (Blueprint $table) {
            $columnsToCheck = ['car_type', 'trans_type', 'fuel_type', 'color', 'interior_color', 'seats_no'];
            $columnsToDelete = [];
            
            foreach ($columnsToCheck as $column) {
                if (Schema::hasColumn('car_rent_ads', $column)) {
                    $columnsToDelete[] = $column;
                }
            }
            
            if (!empty($columnsToDelete)) {
                $table->dropColumn($columnsToDelete);
            }
        });
    }
};