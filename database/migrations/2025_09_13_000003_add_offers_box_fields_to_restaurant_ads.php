<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('restaurant_ads', function (Blueprint $table) {
            if (!Schema::hasColumn('restaurant_ads', 'active_offers_box_days')) {
                $table->integer('active_offers_box_days')->nullable()->after('active_offers_box_status');
            }
            if (!Schema::hasColumn('restaurant_ads', 'active_offers_box_expires_at')) {
                $table->timestamp('active_offers_box_expires_at')->nullable()->after('active_offers_box_days');
            }
        });
    }

    public function down(): void
    {
        Schema::table('restaurant_ads', function (Blueprint $table) {
            if (Schema::hasColumn('restaurant_ads', 'active_offers_box_days')) {
                $table->dropColumn('active_offers_box_days');
            }
            if (Schema::hasColumn('restaurant_ads', 'active_offers_box_expires_at')) {
                $table->dropColumn('active_offers_box_expires_at');
            }
        });
    }
};