<?php

namespace Database\Seeders;

use App\Models\JopAdValues as JopAdValuesModel;
use Illuminate\Database\Seeder;

class JopAdValuesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        JopAdValuesModel::create([
            'field_name'   => 'category_type',
            'display_name' => 'Category Type',
            'options'      => ['Job Offer', 'Job Wanted'],
            'sort_order'   => 1,
        ]);

        JopAdValuesModel::create([
            'field_name'   => 'section_type',
            'display_name' => 'Section Type',
            'options'      => ['Cleaning Services', 'Construction', 'Driver', 'IT', 'Marketing'],
            'sort_order'   => 2,
        ]);
    }
}
