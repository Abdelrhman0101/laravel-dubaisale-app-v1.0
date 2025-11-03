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
                'value' => 'real_estates/thumbnails/jyWyAf4NxG6GtcmWo5eco7D5PyZgK89vtnOXnYqT.jpg',
                'type' => 'string',
                'description' => 'الصورة الافتراضية لإعلانات Job Offer.'
            ]
        );

        DB::table('system_settings')->updateOrInsert(
            ['key' => 'job_seeker_main_image'],
            [
                'value' => 'real_estates/main/AvewzsQUEuWJU9mOfNU2k7JENkqPgTgNyVXoXs84.jpg',
                'type' => 'string',
                'description' => 'الصورة الافتراضية لإعلانات Job Seeker.'
            ]
        );

        DB::table('system_settings')->updateOrInsert(
            ['key' => 'free_ads_limit'],
            [
                'value' => 3,
                'type' => 'integer',
                'description' => 'الحد الأقصى لعدد الإعلانات المجانية لكل مستخدم.'
            ]
        );
    }
}
