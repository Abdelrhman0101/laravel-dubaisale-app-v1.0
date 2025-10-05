<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('car_rent_ads', function (Blueprint $table) {
            // Basic
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('add_category')->default('Car Rent');
            $table->enum('add_status', ['Valid', 'Pending', 'Expired', 'Rejected'])->default('Pending');
            $table->boolean('admin_approved')->default(false);
            $table->unsignedBigInteger('views')->default(0);
            $table->integer('rank')->default(0);
            $table->timestamps();

            // Plan
            $table->string('plan_type')->nullable();
            $table->integer('plan_days')->nullable();
            $table->timestamp('plan_expires_at')->nullable();

            // Ad data
            $table->string('title');
            $table->text('description');
            $table->string('emirate');
            $table->string('district')->nullable();
            $table->string('area')->nullable();

            $table->string('make')->nullable();
            $table->string('model')->nullable();
            $table->string('trim')->nullable();
            $table->year('year')->nullable();

            $table->decimal('day_rent', 10, 2)->nullable();
            $table->decimal('month_rent', 10, 2)->nullable();
            $table->decimal('price', 10, 2)->nullable();

            // Contact
            $table->string('advertiser_name');
            $table->string('phone_number');
            $table->string('whatsapp')->nullable();

            // Media & Location
            $table->string('main_image');
            $table->json('thumbnail_images')->nullable();
            $table->string('location')->nullable();

            // Offers Box
            $table->boolean('active_offers_box_status')->default(false);
            $table->integer('active_offers_box_days')->nullable();
            $table->timestamp('active_offers_box_expires_at')->nullable();
            $table->integer('active_offers_box_rank')->default(0);

            // Indexes
            $table->index(['add_status', 'admin_approved']);
            $table->index(['make', 'model', 'year']);
            $table->index(['emirate', 'district', 'area']);
            $table->index(['active_offers_box_status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('car_rent_ads');
    }
};