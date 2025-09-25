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
                'value' => '/defaults/job_offer.png',
                'type' => 'string',
                'description' => 'الصورة الافتراضية لإعلانات Job Offer.'
            ]
        );

        DB::table('system_settings')->updateOrInsert(
            ['key' => 'job_seeker_main_image'],
            [
                'value' => '/defaults/job_seeker.png',
                'type' => 'string',
                'description' => 'الصورة الافتراضية لإعلانات Job Seeker.'
            ]
        );
    }
}
