<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('restaurant_ads', function (Blueprint $table) {
            $table->string('category', 100)->nullable()->index()->after('price_range');
        });
    }

    public function down(): void
    {
        Schema::table('restaurant_ads', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }
};