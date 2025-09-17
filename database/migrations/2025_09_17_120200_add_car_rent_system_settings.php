<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('system_settings')->insert([
            [
                'key' => 'manual_approval_mode_car_rent',
                'value' => 'true',
                'type' => 'boolean',
                'description' => 'تفعيل الموافقة اليدوية لإعلانات قسم تأجير السيارات.'
            ],
            [
                'key' => 'car_rent_section_active',
                'value' => 'true',
                'type' => 'boolean',
                'description' => 'تفعيل قسم تأجير السيارات في التطبيق.'
            ],
            // قيَم مرجعية للـ Offer Box الخاصة بالقسم (اختيارية، للتناسق مع car_services)
            [
                'key' => 'offer_box_price_per_day_car_rent',
                'value' => '5.00',
                'type' => 'price',
                'description' => 'تكلفة اليوم الواحد لوضع إعلان في صندوق عروض قسم تأجير السيارات.'
            ],
            [
                'key' => 'offer_box_max_ads_car_rent',
                'value' => '10',
                'type' => 'integer',
                'description' => 'العدد الأقصى للإعلانات في صندوق عروض قسم تأجير السيارات.'
            ],
        ]);
    }

    public function down(): void
    {
        DB::table('system_settings')->whereIn('key', [
            'manual_approval_mode_car_rent',
            'car_rent_section_active',
            'offer_box_price_per_day_car_rent',
            'offer_box_max_ads_car_rent',
        ])->delete();
    }
};