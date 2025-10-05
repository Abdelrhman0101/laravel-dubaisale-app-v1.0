<?php

namespace Database\Seeders;

use App\Models\OtherServiceOptions;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OtherServiceOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        OtherServiceOptions::updateOrCreate(
            ['field_name' => 'section_type'],
            [
                'display_name' => 'Section Type',
                'options'      => [
                    'Financial Service',
                    'Legal Service',
                    'Cleaning Service',
                    'IT Service',
                    'Marketing Service',
                    'Consulting Service',
                    'Education & Training',
                ],
                'sort_order'   => 1,
            ]
        );
    }
}
