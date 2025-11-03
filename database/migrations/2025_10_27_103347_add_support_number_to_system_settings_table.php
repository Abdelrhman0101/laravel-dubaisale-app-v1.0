<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('system_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('system_settings', 'support_number')) {
                $table->string('support_number')->nullable()->after('description');
            }
        });

        DB::table('system_settings')->updateOrInsert([
            'key' => 'support_number',
           'value' => '+971545194553',
            'type' => 'string',
            'description' => 'رقم دعم العملاء للنظام.'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('system_settings', function (Blueprint $table) {
            $table->dropColumn('support_number');
        });
    }
};
