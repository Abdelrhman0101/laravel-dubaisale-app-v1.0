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
        Schema::create('user_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->integer('premium_star_ads')->default(0);
            $table->integer('premium_ads')->default(0);
            $table->integer('featured_ads')->default(0);

            $table->integer('premium_star_used')->default(0);
            $table->integer('premium_used')->default(0);
            $table->integer('featured_used')->default(0);

            $table->integer('days')->default(30);

            $table->timestamp('start_date')->useCurrent();

            $table->timestamp('expire_date')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_packages');
    }
};
