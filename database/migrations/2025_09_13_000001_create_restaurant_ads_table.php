<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('restaurant_ads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // User-provided fields
            $table->string('title');
            $table->text('description');
            $table->string('emirate', 100);
            $table->string('district', 100);
            $table->string('area', 100)->nullable();
            $table->string('price_range', 100);
            $table->string('main_image');
            $table->json('thumbnail_images')->nullable();
            $table->string('advertiser_name');
            $table->string('whatsapp_number', 20);
            $table->string('phone_number', 20)->nullable();
            $table->string('address', 500);

            // System-managed fields
            $table->string('add_category', 100)->default('restaurant');
            $table->string('add_status', 50)->default('Pending');
            $table->boolean('admin_approved')->default(false);
            $table->unsignedBigInteger('views')->default(0);
            $table->integer('rank')->default(0);
            $table->string('plan_type', 50)->nullable();
            $table->integer('plan_days')->default(0);
            $table->timestamp('plan_expires_at')->nullable();
            $table->boolean('active_offers_box_status')->default(false);

            $table->timestamps();

            // Indexes for frequent filters
            $table->index(['add_status', 'admin_approved']);
            $table->index(['emirate', 'district']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('restaurant_ads');
    }
};