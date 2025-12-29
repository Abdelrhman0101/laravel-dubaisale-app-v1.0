<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Get all table names in a database-agnostic way
     */
    private function getAllTables(): array
    {
        $driver = DB::connection()->getDriverName();
        
        if ($driver === 'sqlite') {
            $tables = DB::select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'");
            return collect($tables)->pluck('name')->toArray();
        } elseif ($driver === 'mysql') {
            $tables = DB::select('SHOW TABLES');
            return collect($tables)->map(function ($table) {
                return array_values((array)$table)[0];
            })->toArray();
        } elseif ($driver === 'pgsql') {
            $tables = DB::select("SELECT tablename FROM pg_tables WHERE schemaname = 'public'");
            return collect($tables)->pluck('tablename')->toArray();
        }
        
        // Fallback for other drivers - try using Schema facade (Laravel 10+)
        if (method_exists(Schema::class, 'getTables')) {
            return collect(Schema::getTables())->pluck('name')->toArray();
        }
        
        return [];
    }

    public function up(): void
    {
        $tables = $this->getAllTables();

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
        $tables = $this->getAllTables();

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
