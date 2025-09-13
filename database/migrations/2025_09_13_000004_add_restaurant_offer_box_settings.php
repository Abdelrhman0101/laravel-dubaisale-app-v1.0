<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // إضافة إعدادات offer box لقسم المطاعم
        DB::table('offer_box_settings')->updateOrInsert(
            ['category_slug' => 'restaurant'],
            [
                'max_ads' => 10,
                'price_per_day' => 5.00,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    public function down(): void
    {
        DB::table('offer_box_settings')->where('category_slug', 'restaurant')->delete();
    }
};