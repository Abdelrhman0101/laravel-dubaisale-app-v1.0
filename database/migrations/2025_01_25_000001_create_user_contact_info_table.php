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
        Schema::create('user_contact_info', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->json('advertiser_names')->nullable(); // JSON array of advertiser names
            $table->json('phone_numbers')->nullable(); // JSON array of phone numbers
            $table->json('whatsapp_numbers')->nullable(); // JSON array of WhatsApp numbers
            $table->timestamps();
            
            // Ensure one record per user
            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_contact_info');
    }
};