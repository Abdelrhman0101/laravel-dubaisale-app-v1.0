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
            $table->string('car_type')->nullable()->after('year');
            $table->string('trans_type')->nullable()->after('car_type');
            $table->string('fuel_type')->nullable()->after('trans_type');
            $table->string('color')->nullable()->after('fuel_type');
            $table->string('interior_color')->nullable()->after('color');
            $table->integer('seats_no')->nullable()->after('interior_color');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('car_rent_ads', function (Blueprint $table) {
            $table->dropColumn([
                'car_type',
                'trans_type', 
                'fuel_type',
                'color',
                'interior_color',
                'seats_no'
            ]);
        });
    }
};