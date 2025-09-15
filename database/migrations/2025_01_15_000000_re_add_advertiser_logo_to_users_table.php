<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * إعادة إضافة عمود advertiser_logo إلى جدول users
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // إضافة العمود بعد advertiser_type
            $table->string('advertiser_logo')->nullable()->after('advertiser_type');
        });
    }

    /**
     * Reverse the migrations.
     * حذف العمود في حالة التراجع
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('advertiser_logo');
        });
    }
};