<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CarSalesAdSpec;

class CarSalesAdSpecSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specifications = [
            [
                'field_name' => 'specs',
                'display_name' => 'Specifications',
                'options' => [
                    'Basic',
                    'Standard',
                    'Premium',
                    'Luxury',
                    'Sport',
                    'other'
                ],
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'field_name' => 'carType',
                'display_name' => 'Car Type',
                'options' => [
                    'Sedan',
                    'SUV',
                    'Hatchback',
                    'Coupe',
                    'Convertible',
                    'Wagon',
                    'Pickup Truck',
                    'Van',
                    'Crossover',
                    'other'
                ],
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'field_name' => 'transType',
                'display_name' => 'Transmission Type',
                'options' => [
                    'Manual',
                    'Automatic',
                    'CVT',
                    'Semi-Automatic',
                    'other'
                ],
                'is_active' => true,
                'sort_order' => 3
            ],
            [
                'field_name' => 'fuelType',
                'display_name' => 'Fuel Type',
                'options' => [
                    'Petrol',
                    'Diesel',
                    'Hybrid',
                    'Electric',
                    'CNG',
                    'LPG',
                    'other'
                ],
                'is_active' => true,
                'sort_order' => 4
            ],
            [
                'field_name' => 'color',
                'display_name' => 'Exterior Color',
                'options' => [
                    'White',
                    'Black',
                    'Silver',
                    'Gray',
                    'Red',
                    'Blue',
                    'Green',
                    'Yellow',
                    'Orange',
                    'Brown',
                    'Gold',
                    'Purple',
                    'other'
                ],
                'is_active' => true,
                'sort_order' => 5
            ],
            [
                'field_name' => 'interiorColor',
                'display_name' => 'Interior Color',
                'options' => [
                    'Black',
                    'Beige',
                    'Gray',
                    'Brown',
                    'White',
                    'Red',
                    'Blue',
                    'other'
                ],
                'is_active' => true,
                'sort_order' => 6
            ],
            [
                'field_name' => 'warranty',
                'display_name' => 'Warranty',
                'options' => [
                    'No Warranty',
                    '1 Year',
                    '2 Years',
                    '3 Years',
                    '4 Years',
                    '5 Years',
                    'Extended Warranty',
                    'other'
                ],
                'is_active' => true,
                'sort_order' => 7
            ],
            [
                'field_name' => 'engineCapacity',
                'display_name' => 'Engine Capacity',
                'options' => [
                    '1.0L',
                    '1.2L',
                    '1.4L',
                    '1.6L',
                    '1.8L',
                    '2.0L',
                    '2.4L',
                    '2.5L',
                    '3.0L',
                    '3.5L',
                    '4.0L',
                    '5.0L+',
                    'other'
                ],
                'is_active' => true,
                'sort_order' => 8
            ],
            [
                'field_name' => 'cylinders',
                'display_name' => 'Number of Cylinders',
                'options' => [
                    '3 Cylinders',
                    '4 Cylinders',
                    '5 Cylinders',
                    '6 Cylinders',
                    '8 Cylinders',
                    '10 Cylinders',
                    '12 Cylinders',
                    'other'
                ],
                'is_active' => true,
                'sort_order' => 9
            ],
            [
                'field_name' => 'horsePower',
                'display_name' => 'Horse Power',
                'options' => [
                    'Under 100 HP',
                    '100-150 HP',
                    '150-200 HP',
                    '200-250 HP',
                    '250-300 HP',
                    '300-400 HP',
                    '400-500 HP',
                    'Over 500 HP',
                    'other'
                ],
                'is_active' => true,
                'sort_order' => 10
            ],
            [
                'field_name' => 'doorsNo',
                'display_name' => 'Number of Doors',
                'options' => [
                    '2 Doors',
                    '3 Doors',
                    '4 Doors',
                    '5 Doors',
                    'other'
                ],
                'is_active' => true,
                'sort_order' => 11
            ],
            [
                'field_name' => 'seatsNo',
                'display_name' => 'Number of Seats',
                'options' => [
                    '2 Seats',
                    '4 Seats',
                    '5 Seats',
                    '7 Seats',
                    '8 Seats',
                    '9+ Seats',
                    'other'
                ],
                'is_active' => true,
                'sort_order' => 12
            ],
            [
                'field_name' => 'steeringSide',
                'display_name' => 'Steering Side',
                'options' => [
                    'Left Hand Drive (LHD)',
                    'Right Hand Drive (RHD)',
                    'other'
                ],
                'is_active' => true,
                'sort_order' => 13
            ],
            [
                'field_name' => 'advertiserType',
                'display_name' => 'Advertiser Type',
                'options' => [
                    'Individual',
                    'Dealer',
                    'Showroom',
                    'Company',
                    'other'
                ],
                'is_active' => true,
                'sort_order' => 14
            ]
        ];

        foreach ($specifications as $spec) {
            CarSalesAdSpec::updateOrCreate(
                ['field_name' => $spec['field_name']],
                $spec
            );
        }
    }
}