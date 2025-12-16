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
        Schema::create('section_banners', function (Blueprint $table) {
            $table->id();
            $table->string('category'); // e.g., car-sale, real-estate
            $table->string('lang', 2); // ar, en
            $table->string('type'); // main, detail
            $table->string('content_type'); // image, text
            $table->text('content'); // image path or text content
            $table->json('style_options')->nullable(); // for text styling (color, bg, etc.)
            $table->timestamps();

            // Ensure unique banner per slot
            $table->unique(['category', 'lang', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('section_banners');
    }
};
