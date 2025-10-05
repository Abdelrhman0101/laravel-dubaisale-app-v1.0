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
        JopAdValuesModel::updateOrCreate(
            ['field_name' => 'category_type'],
            [
                'display_name' => 'Category Type',
                'options'      => ['Job Offer', 'Job Seeker'],
                'sort_order'   => 1,
            ]
        );

        JopAdValuesModel::updateOrCreate(
            ['field_name' => 'section_type'],
            [
                'display_name' => 'Section Type',
                'options'      => ['Education', 'Engineering', 'Accounting', 'IT', 'Marketing'],
                'sort_order'   => 2,
            ]
        );
    }
}
