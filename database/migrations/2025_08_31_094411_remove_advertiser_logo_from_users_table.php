<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * (ما سيحدث عند تنفيذ php artisan migrate)
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // هذا الأمر يقوم بحذف العمود المحدد
            $table->dropColumn('advertiser_logo');
        });
    }

    /**
     * Reverse the migrations.
     * (ما سيحدث عند التراجع عن الـ migration)
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // كأفضل ممارسة، نقوم بإعادة إنشاء العمود في حال احتجنا للتراجع
            // سنفترض أنه كان بعد advertiser_type بناءً على إضافاتنا السابقة
            $table->string('advertiser_logo')->nullable()->after('advertiser_type');
        });
    }
};