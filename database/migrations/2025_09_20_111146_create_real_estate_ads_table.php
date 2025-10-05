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
        Schema::create('real_estate_ads', function (Blueprint $table) {
            // == Basic Ad Info ==
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
            $table->string('add_category')->default('Real State');
            $table->enum('add_status', ['Valid', 'Pending', 'Expired', 'Rejected'])->default('Pending');
            $table->boolean('admin_approved')->default(false);
            $table->unsignedBigInteger('views')->default(0);
            $table->integer('rank')->default(0);
            $table->timestamps();

            // == Plan Info ==
            // == Plan Info ==
            $table->string('plan_type')->nullable();
            $table->integer('plan_days')->nullable();
            $table->timestamp('plan_expires_at')->nullable();

            // == Real State Data ==
            // Location
            $table->string('emirate', 100);
            $table->string('district', 100)->nullable();
            $table->string('area', 150)->nullable();

            // Price & Contract
            $table->decimal('price', 12, 2);
            $table->string('contract_type', 50)->nullable(); // Rent, Sale, Mortgage
            $table->string('property_type', 50)->nullable();

            // Info
            $table->string('title');
            $table->string('advertiser_name');
            $table->string('phone_number', 20)->nullable();
            $table->string('whatsapp_number', 20)->nullable();
            $table->text('description')->nullable();

            // Images
            $table->string('main_image')->nullable();
            $table->json('thumbnail_images')->nullable();

            // Location map 
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            // == Active Offers Box ==
            $table->boolean('active_offers_box_status')->default(false);
            $table->integer('active_offers_box_days')->nullable();
            $table->timestamp('active_offers_box_expires_at')->nullable();
            $table->integer('active_offers_box_rank')->default(0);


            $table->index(['emirate', 'district', 'area']);
            $table->index(['contract_type', 'property_type']);
            $table->index(['add_status', 'admin_approved']);

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('real_estate_ads');
    }
};
