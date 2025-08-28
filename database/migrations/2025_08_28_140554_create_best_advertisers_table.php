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
        Schema::create('best_advertisers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('category_slug'); // e.g., 'car_sales', 'real_estate'
            $table->timestamps();
            // قيد فريد لمنع إضافة نفس المستخدم في نفس القسم مرتين
            $table->unique(['user_id', 'category_slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('best_advertisers');
    }
};
