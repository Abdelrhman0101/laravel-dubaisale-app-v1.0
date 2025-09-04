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
        Schema::table('car_services_ads', function (Blueprint $table) {
            $table->integer('active_offers_box_days')->nullable()->after('active_offers_box_status');
            $table->integer('active_offers_box_rank')->default(0)->after('active_offers_box_expires_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('car_services_ads', function (Blueprint $table) {
            $table->dropColumn(['active_offers_box_days', 'active_offers_box_rank']);
        });
    }
};