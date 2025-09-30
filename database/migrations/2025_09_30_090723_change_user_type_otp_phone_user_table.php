<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('otp_verified')->default(false)->change();
            $table->string('user_type')->default('guest')->change();


        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('otp_verified')->nullable()->default(true)->change();
            $table->string('user_type')->nullable()->default('advertiser')->change();
        });
    }
};
