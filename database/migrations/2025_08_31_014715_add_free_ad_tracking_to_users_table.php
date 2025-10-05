<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            // لتتبع عدد الإعلانات المنشورة في الدورة الحالية
            $table->json('free_ad_usage')->nullable()->after('the_best'); 
            // لتحديد متى يتم إعادة تعيين العداد
            $table->timestamp('free_ad_reset_at')->nullable()->after('free_ad_usage'); 
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
