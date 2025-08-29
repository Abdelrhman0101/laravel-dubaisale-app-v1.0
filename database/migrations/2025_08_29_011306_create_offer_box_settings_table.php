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
    Schema::create('offer_box_settings', function (Blueprint $table) {
        $table->id();
        $table->string('category_slug')->unique(); // 'car_sales', 'real_estate', etc.
        $table->unsignedInteger('max_ads'); // العدد الأقصى للإعلانات في الصندوق
        $table->decimal('price_per_day', 8, 2); // سعر الترقية لليوم الواحد
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer_box_settings');
    }
};
