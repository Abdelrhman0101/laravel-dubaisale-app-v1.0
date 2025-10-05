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
            // Check if otp_phone column doesn't exist before adding it
            if (!Schema::hasColumn('users', 'otp_phone')) {
                $table->string('otp_phone')->nullable()->after('activation_code');
            }
            
            // Check if otp_verified column doesn't exist before adding it
            if (!Schema::hasColumn('users', 'otp_verified')) {
                $table->boolean('otp_verified')->nullable()->default(1)->after('otp_phone');
            }
            
            // Check if user_type column doesn't exist before adding it
            if (!Schema::hasColumn('users', 'user_type')) {
                $table->enum('user_type', ['guest', 'advertiser'])
                    ->default('advertiser');
            }
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('otp');
            $table->string('phone')->unique()->nullable()->change();
            $table->dropColumn('otp_verified');
            $table->dropColumn('user_type');
        });
    }
};
