<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // تحديث رقم الدعم الفني إلى الرقم الجديد
        DB::table('system_settings')
            ->where('key', 'support_number')
            ->update([
                'value' => '+971508236561',
                'description' => 'رقم دعم العملاء للنظام - يمكن للمدراء تعديله من لوحة التحكم.'
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // إعادة رقم الدعم الفني إلى الرقم القديم
        DB::table('system_settings')
            ->where('key', 'support_number')
            ->update([
                'value' => '+971545194553',
                'description' => 'رقم دعم العملاء للنظام.'
            ]);
    }
};
