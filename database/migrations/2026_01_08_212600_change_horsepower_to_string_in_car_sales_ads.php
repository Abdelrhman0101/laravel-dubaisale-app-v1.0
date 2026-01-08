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
        Schema::table('car_sales_ads', function (Blueprint $table) {
            // تغيير horsepower من integer إلى string
            $table->string('horsepower')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('car_sales_ads', function (Blueprint $table) {
            // إعادة horsepower إلى integer في حالة التراجع
            $table->integer('horsepower')->nullable()->change();
        });
    }
};
