<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // إضافة متغيرات النظام الخاصة بقسم car_services
        DB::table('system_settings')->insert([
            // -- الإعلانات المجانية لقسم خدمات السيارات --
            [
                'key' => 'free_ads_limit_car_services', 
                'value' => '3', 
                'type' => 'integer', 
                'description' => 'عدد الإعلانات المجانية المتاحة للمستخدم شهريًا في قسم خدمات السيارات.'
            ],
            [
                'key' => 'max_price_free_ad_car_services', 
                'value' => '500', 
                'type' => 'price', 
                'description' => 'أقصى سعر لإعلان خدمة سيارة مجاني. أي إعلان أغلى يتطلب باقة مدفوعة.'
            ],
            
            // -- Offers Box لقسم خدمات السيارات --
            [
                'key' => 'offer_box_price_per_day_car_services', 
                'value' => '5.00', 
                'type' => 'price', 
                'description' => 'تكلفة اليوم الواحد لوضع إعلان في صندوق عروض خدمات السيارات.'
            ],
            [
                'key' => 'offer_box_max_ads_car_services', 
                'value' => '10', 
                'type' => 'integer', 
                'description' => 'العدد الأقصى للإعلانات في صندوق عروض خدمات السيارات.'
            ],
            
            // -- إعدادات عامة لقسم خدمات السيارات --
            [
                'key' => 'manual_approval_mode_car_services', 
                'value' => 'false', 
                'type' => 'boolean', 
                'description' => 'تفعيل الموافقة اليدوية للإعلانات في قسم خدمات السيارات.'
            ],
            [
                'key' => 'car_services_section_active', 
                'value' => 'true', 
                'type' => 'boolean', 
                'description' => 'تفعيل قسم خدمات السيارات في التطبيق.'
            ]
        ]);
        
        // إضافة إعدادات offer box لقسم car_services
        DB::table('offer_box_settings')->insert([
            'category_slug' => 'car_services',
            'max_ads' => 10,
            'price_per_day' => 5.00,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // حذف متغيرات النظام الخاصة بقسم car_services
        DB::table('system_settings')->whereIn('key', [
            'free_ads_limit_car_services',
            'max_price_free_ad_car_services',
            'offer_box_price_per_day_car_services',
            'offer_box_max_ads_car_services',
            'manual_approval_mode_car_services',
            'car_services_section_active'
        ])->delete();
        
        // حذف إعدادات offer box لقسم car_services
        DB::table('offer_box_settings')->where('category_slug', 'car_services')->delete();
    }
};