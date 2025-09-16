<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // إضافة فئة 'restaurant' إلى جدول restaurant_categories
        $now = now();
        DB::table('restaurant_categories')->insertOrIgnore([
            'name' => 'restaurant',
            'active' => true,
            'sort_order' => 0,
            'created_at' => $now,
            'updated_at' => $now
        ]);
    }

    public function down(): void
    {
        DB::table('restaurant_categories')->where('name', 'restaurant')->delete();
    }
};