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
        Schema::create('other_service_ads', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('add_category')->default('Other Services');
            $table->enum('add_status', ['Valid', 'Pending', 'Expired', 'Rejected'])->default('Valid');
            $table->boolean('admin_approved')->default(true);
            $table->unsignedBigInteger('views')->default(0);
            $table->integer('rank')->default(0);

            // == Plan Info ==
            $table->string('plan_type')->nullable();
            $table->integer('plan_days')->nullable();
            $table->timestamp('plan_expires_at')->nullable();

            // == Service Ad Data ==
            // Location
            $table->string('emirate', 100);
            $table->string('district', 100)->nullable();
            $table->string('area', 150)->nullable();

            // Price
            $table->decimal('price', 12, 2)->nullable();

            // Service Info
            $table->string('service_name', 150);
            $table->string('section_type', 150)->nullable();
            $table->string('title');
            $table->string('advertiser_name')->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->string('whatsapp_number', 20)->nullable();
            $table->text('description')->nullable();

            // Images
            $table->string('main_image')->nullable();
            // $table->json('thumbnail_images')->nullable();

            // Location map 
            $table->string('address')->nullable();
            // $table->decimal('latitude', 10, 7)->nullable();
            // $table->decimal('longitude', 10, 7)->nullable();

            // == Active Offers Box ==
            $table->boolean('active_offers_box_status')->default(false);
            $table->integer('active_offers_box_days')->nullable();
            $table->timestamp('active_offers_box_expires_at')->nullable();
            $table->integer('active_offers_box_rank')->default(0);

            $table->index(['emirate', 'district', 'area']);
            $table->index(['add_status', 'admin_approved']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('other_service_ads');
    }
};
