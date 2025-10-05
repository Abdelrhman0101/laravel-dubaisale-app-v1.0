<?php

namespace Database\Seeders;

use App\Models\CarMake;
use App\Models\CarModel;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $makes = [
            'Toyota' => ['Corolla', 'Camry', 'Land Cruiser'],
            'Honda' => ['Civic', 'Accord', 'CR-V'],
            'BMW' => ['3 Series', '5 Series', 'X5'],
            'Mercedes' => ['C-Class', 'E-Class', 'GLA'],
            'Hyundai' => ['Elantra', 'Sonata', 'Tucson'],
        ];

        foreach ($makes as $make => $models) {
            $carMake = CarMake::create(['name' => $make]);

            foreach ($models as $model) {
                CarModel::create([
                    'car_make_id' => $carMake->id,
                    'name' => $model,
                ]);
            }
        }
    }
}
