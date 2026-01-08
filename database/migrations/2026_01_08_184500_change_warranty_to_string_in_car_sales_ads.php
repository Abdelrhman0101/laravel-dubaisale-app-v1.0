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
        // 1. First, we need to ensure the column can hold string values if we want to migrate data.
        // However, standard SQL 'ALTER' might fail if data types are incompatible (e.g. strict mode).
        // Since boolean in MySQL is distinct (tinyint), it usually casts to string '0' or '1' fine.
        
        Schema::table('car_sales_ads', function (Blueprint $table) {
            // Change the column type to string. 
            // Note: This requires doctrine/dbal package usually, or MySQL 8+ / recent MariaDB support in Laravel.
            // Using ->change() method.
            $table->string('warranty', 255)->nullable()->change();
        });

        // 2. Optional: Transform old data (0 -> 'No Warranty', 1 -> 'Warranty Available') if needed.
        // For now, we will leave them as "0" and "1" strings or null, as the user didn't specify mapping logic,
        // but since the seeders suggest options like "No Warranty", "1 Year", etc., leaving it as string "1" might be confusing.
        // Let's just do the type change as requested.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('car_sales_ads', function (Blueprint $table) {
            // We can't easily convert random strings back to boolean safely without data loss.
            // But we try to revert the type definition.
            $table->boolean('warranty')->default(false)->change();
        });
    }
};
