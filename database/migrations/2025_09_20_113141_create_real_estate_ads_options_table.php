<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('real_estate_ads_options', function (Blueprint $table) {
            $table->id();
            $table->string('field_name')->unique(); // specs, carType, transType, etc.
            $table->string('display_name'); // Display name for the field
            $table->json('options'); // JSON array of available options
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('real_estate_ads_options');
    }
};
