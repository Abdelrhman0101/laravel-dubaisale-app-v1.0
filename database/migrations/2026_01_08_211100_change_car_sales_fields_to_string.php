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
            // تغيير الحقول من integer إلى string
            $table->string('engine_capacity')->nullable()->change();
            $table->string('seats_no')->nullable()->change();
            $table->string('doors_no')->nullable()->change();
            $table->string('cylinders')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('car_sales_ads', function (Blueprint $table) {
            // إعادة الحقول إلى integer في حالة التراجع
            $table->integer('engine_capacity')->nullable()->change();
            $table->integer('seats_no')->nullable()->change();
            $table->integer('doors_no')->nullable()->change();
            $table->integer('cylinders')->nullable()->change();
        });
    }
};
