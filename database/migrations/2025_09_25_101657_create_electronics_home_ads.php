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
        Schema::create('electronics_home_ads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('add_category')->default('Electronics');
            $table->enum('add_status', ['Valid', 'Pending', 'Expired', 'Rejected'])->default('Valid');
            $table->boolean('admin_approved')->default(true);
            $table->unsignedBigInteger('views')->default(0);
            $table->integer('rank')->default(0);
            $table->timestamps();

            // == Plan Info ==
            $table->string('plan_type')->nullable();
            $table->integer('plan_days')->nullable();
            $table->timestamp('plan_expires_at')->nullable();

            // == Electronics Data ==
            // Location
            $table->string('emirate', 100);
            $table->string('district', 100)->nullable();
            $table->string('area', 150)->nullable();
            $table->string('address', 500);


            // Product Info
            $table->string('product_name', 255);
            $table->string('section_type', 100); // FK to options table
            $table->decimal('price', 12, 2);

            // Info
            $table->string('title');
            $table->string('advertiser_name');
            $table->string('phone_number', 20)->nullable();
            $table->string('whatsapp_number', 20)->nullable();
            $table->text('description')->nullable();

            // Images
            $table->string('main_image')->nullable();
            $table->json('thumbnail_images')->nullable();

            // == Active Offers Box ==
            $table->boolean('active_offers_box_status')->default(false);
            $table->integer('active_offers_box_days')->nullable();
            $table->timestamp('active_offers_box_expires_at')->nullable();
            $table->integer('active_offers_box_rank')->default(0);

            // Indexes
            $table->index(['emirate', 'district', 'area']);
            $table->index(['section_type']);
            $table->index(['add_status', 'admin_approved']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('electronics_home_ads');
    }
};
