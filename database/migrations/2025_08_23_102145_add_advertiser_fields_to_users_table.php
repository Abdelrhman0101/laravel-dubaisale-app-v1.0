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
    Schema::table('users', function (Blueprint $table) {
        $table->string('advertiser_name')->nullable()->after('whatsapp');
        $table->string('advertiser_type')->nullable()->after('advertiser_name');
        $table->string('advertiser_logo')->nullable()->after('advertiser_type'); // لتخزين مسار الصورة
        $table->text('advertiser_location')->nullable()->after('advertiser_logo'); // لتخزين رابط أو بيانات JSON
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
