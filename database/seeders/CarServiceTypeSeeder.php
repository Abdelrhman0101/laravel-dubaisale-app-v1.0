<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CarServiceType;

class CarServiceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $serviceTypes = [
            [
                'name' => 'maintenance',
                'display_name' => 'صيانة عامة - General Maintenance',
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'name' => 'repair',
                'display_name' => 'إصلاح - Repair',
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'name' => 'car_wash',
                'display_name' => 'غسيل السيارات - Car Wash',
                'is_active' => true,
                'sort_order' => 3
            ],
            [
                'name' => 'oil_change',
                'display_name' => 'تغيير الزيت - Oil Change',
                'is_active' => true,
                'sort_order' => 4
            ],
            [
                'name' => 'tire_service',
                'display_name' => 'خدمات الإطارات - Tire Service',
                'is_active' => true,
                'sort_order' => 5
            ],
            [
                'name' => 'ac_service',
                'display_name' => 'خدمات التكييف - AC Service',
                'is_active' => true,
                'sort_order' => 6
            ],
            [
                'name' => 'battery_service',
                'display_name' => 'خدمات البطارية - Battery Service',
                'is_active' => true,
                'sort_order' => 7
            ],
            [
                'name' => 'towing',
                'display_name' => 'سحب السيارات - Towing',
                'is_active' => true,
                'sort_order' => 8
            ],
            [
                'name' => 'inspection',
                'display_name' => 'فحص السيارات - Car Inspection',
                'is_active' => true,
                'sort_order' => 9
            ],
            [
                'name' => 'detailing',
                'display_name' => 'تنظيف تفصيلي - Car Detailing',
                'is_active' => true,
                'sort_order' => 10
            ],
            [
                'name' => 'other',
                'display_name' => 'أخرى - Other',
                'is_active' => true,
                'sort_order' => 999 // Always last
            ]
        ];

        foreach ($serviceTypes as $serviceType) {
            CarServiceType::create($serviceType);
        }
    }
}