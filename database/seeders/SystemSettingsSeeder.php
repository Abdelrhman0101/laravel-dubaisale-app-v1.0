<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SystemSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('system_settings')->updateOrInsert(
            ['key' => 'job_offer_main_image'],
            [
                'value' => 'electronics/main/mBcY8sq6r6nJDAIaXy6f3JxvT8lBFRHG6hSymmve.png',
                'type' => 'string',
                'description' => 'الصورة الافتراضية لإعلانات Job Offer.'
            ]
        );

        DB::table('system_settings')->updateOrInsert(
            ['key' => 'job_seeker_main_image'],
            [
                'value' => 'electronics/main/uyTE1Cm86bJnTMjFzV6T3BCfdGw7PYyPIKIrrdRv.png',
                'type' => 'string',
                'description' => 'الصورة الافتراضية لإعلانات Job Seeker.'
            ]
        );
    }
}
