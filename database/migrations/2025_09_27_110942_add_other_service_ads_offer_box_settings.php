<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        DB::table('offer_box_settings')->updateOrInsert(
            ['category_slug' => 'other_services'],
            [
                'max_ads' => 10,
                'price_per_day' => 5.00,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        DB::table('offer_box_settings')->where('category_slug', 'other_services')->delete();
    }
};
