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
        Schema::create('car_services_ads', function (Blueprint $table) {
            // == Basic Ad Info ==
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('add_category')->default('Car Services');
            $table->enum('add_status', ['Valid', 'Pending', 'Expired', 'Rejected'])->default('Pending');
            $table->boolean('admin_approved')->default(false);
            $table->unsignedBigInteger('views')->default(0);
            $table->integer('rank')->default(0);
            $table->timestamps();

            // == Plan Info ==
            $table->string('plan_type')->nullable();
            $table->integer('plan_days')->nullable();
            $table->timestamp('plan_expires_at')->nullable();
            
            // == Service Data ==
            $table->string('title');
            $table->text('description');
            $table->string('emirate');
            $table->string('district');
            $table->string('area');
            $table->string('service_type'); // Will reference car_service_types table
            $table->string('service_name');
            $table->decimal('price', 10, 2);
            
            // == Contact Info (from UserContactInfo) ==
            $table->string('advertiser_name');
            $table->string('phone_number');
            $table->string('whatsapp');
            
            // == Images ==
            $table->string('main_image');
            $table->json('thumbnail_images')->nullable(); // JSON array of image paths
            
            // == Location ==
            $table->string('location')->nullable();
            
            // == Offers Box ==
            $table->boolean('active_offers_box_status')->default(false);
            $table->timestamp('active_offers_box_expires_at')->nullable();
            
            // == Indexes for better performance ==
            $table->index(['add_status', 'admin_approved']);
            $table->index(['service_type']);
            $table->index(['emirate', 'district', 'area']);
            $table->index(['active_offers_box_status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_services_ads');
    }
};