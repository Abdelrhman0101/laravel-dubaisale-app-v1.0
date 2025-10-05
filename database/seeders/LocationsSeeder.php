<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SystemSetting;

class LocationsSeeder extends Seeder
{
    private const SETTING_KEY = 'locations_emirates';

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // بيانات الإمارات والمناطق الأساسية
        $emiratesData = [
            [
                'name' => 'dubai',
                'display_name' => 'Dubai',
                'districts' => [
                    'Downtown Dubai',
                    'Dubai Marina',
                    'Jumeirah',
                    'Business Bay',
                    'DIFC',
                    'Dubai Mall Area',
                    'Palm Jumeirah',
                    'JBR',
                    'Dubai Sports City',
                    'Motor City',
                    'Arabian Ranches',
                    'The Springs',
                    'The Meadows',
                    'Emirates Hills',
                    'Jumeirah Village Circle',
                    'Dubai Investment Park',
                    'Al Barsha',
                    'Mall of the Emirates',
                    'Deira',
                    'Bur Dubai',
                    'Karama',
                    'Satwa',
                    'Oud Metha',
                    'Al Qusais',
                    'International City',
                    'Dragon Mart',
                    'Dubai Silicon Oasis',
                    'Dubailand',
                    'Al Mizhar',
                    'Mirdif'
                ]
            ],
            [
                'name' => 'abu_dhabi',
                'display_name' => 'Abu Dhabi',
                'districts' => [
                    'Abu Dhabi City',
                    'Al Reem Island',
                    'Saadiyat Island',
                    'Yas Island',
                    'Al Raha Beach',
                    'Khalifa City',
                    'Mohammed Bin Zayed City',
                    'Al Shamkha',
                    'Al Reef',
                    'Marina Village',
                    'Al Bateen',
                    'Al Karamah',
                    'Tourist Club Area',
                    'Corniche Area',
                    'Electra Street',
                    'Hamdan Street',
                    'Al Zahiyah',
                    'Al Markaziyah',
                    'Al Mushrif',
                    'Al Khalidiyah'
                ]
            ],
            [
                'name' => 'sharjah',
                'display_name' => 'Sharjah',
                'districts' => [
                    'Sharjah City',
                    'Al Nahda',
                    'Al Qasimia',
                    'Al Majaz',
                    'Al Khan',
                    'Al Taawun',
                    'Al Qadisiya',
                    'Al Salam',
                    'Al Ramtha',
                    'Al Ghubaiba',
                    'Industrial Area',
                    'University City',
                    'Muwailih',
                    'Al Dhaid',
                    'Kalba',
                    'Khor Fakkan',
                    'Dibba Al Hisn'
                ]
            ],
            [
                'name' => 'ajman',
                'display_name' => 'Ajman',
                'districts' => [
                    'Ajman City',
                    'Al Nuaimiya',
                    'Al Rashidiya',
                    'Al Jurf',
                    'Al Hamidiyah',
                    'Al Tallah',
                    'Al Rawda',
                    'Al Helio',
                    'Masfout',
                    'Manama'
                ]
            ],
            [
                'name' => 'ras_al_khaimah',
                'display_name' => 'Ras Al Khaimah',
                'districts' => [
                    'Ras Al Khaimah City',
                    'Al Nakheel',
                    'Al Hamra',
                    'Al Marjan Island',
                    'Al Rams',
                    'Digdaga',
                    'Al Jazirah Al Hamra',
                    'Khuzam',
                    'Al Qawasim',
                    'Mamoura'
                ]
            ],
            [
                'name' => 'fujairah',
                'display_name' => 'Fujairah',
                'districts' => [
                    'Fujairah City',
                    'Dibba Al Fujairah',
                    'Al Bidya',
                    'Masafi',
                    'Al Hayl',
                    'Qidfa',
                    'Mirbah',
                    'Rul Dadna'
                ]
            ],
            [
                'name' => 'umm_al_quwain',
                'display_name' => 'Umm Al Quwain',
                'districts' => [
                    'Umm Al Quwain City',
                    'Al Salamah',
                    'Falaj Al Mualla',
                    'Al Raas',
                    'Al Dur'
                ]
            ]
        ];

        // تطبيع البيانات باستخدام نفس المنطق الموجود في LocationsController
        $normalizedEmirates = [];
        foreach ($emiratesData as $emirate) {
            $normalizedEmirates[] = [
                'name' => $this->normalizeName($emirate['name']),
                'display_name' => $emirate['display_name'],
                'districts' => array_values(array_unique(array_map(fn ($d) => $this->normalizeName($d), $emirate['districts'])))
            ];
        }

        // إنشاء أو تحديث الإعداد في قاعدة البيانات
        SystemSetting::updateOrCreate(
            ['key' => self::SETTING_KEY],
            [
                'value' => json_encode($normalizedEmirates, JSON_UNESCAPED_UNICODE),
                'type' => 'json',
                'description' => 'List of UAE emirates and their districts for locations management.',
            ]
        );

        $this->command->info('✅ تم إنشاء بيانات الإمارات والمناطق بنجاح!');
        $this->command->info('📍 تم إضافة ' . count($normalizedEmirates) . ' إمارات مع مناطقها');
        
        // عرض إحصائيات
        $totalDistricts = array_sum(array_map(fn($e) => count($e['districts']), $normalizedEmirates));
        $this->command->info('🏘️ إجمالي المناطق: ' . $totalDistricts);
    }

    /**
     * تطبيع الأسماء - نفس المنطق الموجود في LocationsController
     */
    private function normalizeName(string $name): string
    {
        $name = trim($name);
        // Title case for Latin words, keep Arabic as-is
        $name = preg_replace_callback('/([A-Za-z][A-Za-z\s\'-]*)/u', function ($m) {
            return ucwords(strtolower($m[1]));
        }, $name);
        return $name;
    }
}