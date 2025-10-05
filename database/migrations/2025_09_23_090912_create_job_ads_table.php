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
        Schema::create('job_ads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('add_category')->default('Jop');
            $table->enum('add_status', ['Valid', 'Pending', 'Expired', 'Rejected'])->default('Valid');
            $table->boolean('admin_approved')->default(true);
            $table->unsignedBigInteger('views')->default(0);
            $table->integer('rank')->default(0);

            // == Media & Location ==
            $table->string('main_image');
            $table->string('address')->nullable();

            // == Active Offers Box ==
            $table->boolean('active_offers_box_status')->default(false);
            $table->integer('active_offers_box_days')->nullable();
            $table->timestamp('active_offers_box_expires_at')->nullable();
            $table->integer('active_offers_box_rank')->default(0);

            // Basic Info
            $table->string('emirate');
            $table->string('district')->nullable();

            $table->string('category_type');
            $table->string('section_type');

            // Job Details
            $table->string('job_name');
            $table->string('salary')->nullable();
            $table->string('title');
            $table->text('description')->nullable();

            // Contact
            $table->string('advertiser_name')->nullable();
            $table->string('phone_number');
            $table->string('whatsapp')->nullable();

            // Status
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_ads');
    }
};
