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
        Schema::table('job_ads', function (Blueprint $table) {
            //
            $table->string('main_image')->nullable()->change();
            $table->string('phone_number', 20)->nullable()->change();
            $table->text('contact_info')->nullable()->after('phone_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_ads', function (Blueprint $table) {
            //
            $table->string('main_image')->nullable(false)->change();
            $table->string('phone_number', 20)->nullable(false)->change();
            $table->dropColumn('contact_info');
        });
    }
};
