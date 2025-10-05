<?php

namespace Database\Seeders;

use App\Models\electronicAdOptions;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ElectronicAdsOptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        electronicAdOptions::updateOrCreate(
            ['field_name' => 'section_type'],
            [
                'display_name' => 'Section Type',
                'options' => [
                    'Mobile Phones',
                    'Laptops',
                    'Tablets',
                    'Televisions',
                    'Cameras',
                    'Accessories'
                ],
                'is_active' => true,
                'sort_order' => 1,
            ]
        );
    }
}
