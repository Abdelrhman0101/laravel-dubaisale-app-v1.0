<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $tables = collect(DB::select('SHOW TABLES'))->map(function ($table) {
            return array_values((array)$table)[0];
        })->toArray();

        $excluded = ['migrations', 'best_advertisers', 'system_settings', 'offer_box_settings'];

        foreach ($tables as $tableName) {
            if (in_array($tableName, $excluded)) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                if (!Schema::hasColumn($tableName, 'latitude')) {
                    $table->decimal('latitude', 10, 7)->nullable();
                }
                if (!Schema::hasColumn($tableName, 'longitude')) {
                    $table->decimal('longitude', 10, 7)->nullable();
                }
            });
        }
    }

    public function down(): void
    {
        $tables = collect(DB::select('SHOW TABLES'))->map(function ($table) {
            return array_values((array)$table)[0];
        })->toArray();

        $excluded = ['migrations', 'best_advertisers', 'system_settings', 'offer_box_settings'];

        foreach ($tables as $tableName) {
            if (in_array($tableName, $excluded)) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) {
                if (Schema::hasColumn($table->getTable(), 'latitude')) {
                    $table->dropColumn('latitude');
                }
                if (Schema::hasColumn($table->getTable(), 'longitude')) {
                    $table->dropColumn('longitude');
                }
            });
        }
    }
};
