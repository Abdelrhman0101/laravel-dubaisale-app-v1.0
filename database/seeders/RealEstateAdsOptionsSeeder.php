<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RealEstateAdsOptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('real_estate_ads_options')->insert([
            [
                'field_name' => 'contract_type',
                'display_name' => 'Contract Type',
                'options' => json_encode(['Rent', 'Sale', 'Mortgage']),
                'is_active' => true,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'field_name' => 'property_type',
                'display_name' => 'Property Type',
                'options' => json_encode(['Villa', 'Apartment', 'Office', 'Land']),
                'is_active' => true,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
