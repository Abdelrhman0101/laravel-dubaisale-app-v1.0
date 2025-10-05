<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // مهم لإضافة البيانات الأولية

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // المفتاح الفريد، مثل 'free_ads_limit_cars_sales'
            $table->text('value');         // القيمة، كنص لتكون مرنة
            $table->string('type')->default('string'); // للمساعدة في التعامل معها (integer, price, boolean, json)
            $table->text('description')->nullable(); // شرح وظيفة هذا الإعداد
            $table->timestamps();
        });

        // إضافة الإعدادات الأولية للنظام كبيانات افتراضية
        $this->seedInitialSettings();
    }

    public function down(): void
    {
        Schema::dropIfExists('system_settings');
    }

    /**
     * دالة مساعدة لإضافة البيانات الأولية
     */
    private function seedInitialSettings(): void
    {
        DB::table('system_settings')->insert([
            // -- الإعلانات المجانية --
            [
                'key' => 'free_ad_cycle_days', 
                'value' => '30', 
                'type' => 'integer', 
                'description' => 'مدة صلاحية باقة الإعلانات المجانية بالأيام.'
            ],
            [
                'key' => 'free_ads_limit_cars_sales', 
                'value' => '5', 
                'type' => 'integer', 
                'description' => 'عدد الإعلانات المجانية المتاحة للمستخدم شهريًا في قسم بيع السيارات.'
            ],
            [
                'key' => 'max_price_free_ad_cars_sales', 
                'value' => '150000', 
                'type' => 'price', 
                'description' => 'أقصى سعر لإعلان سيارة مجاني. أي إعلان أغلى يتطلب باقة مدفوعة.'
            ],
            // -- الباقات المدفوعة --
            ['key' => 'plan_price_premium_star', 'value' => '50.00', 'type' => 'price', 'description' => 'سعر باقة Premium Star.'],
            ['key' => 'plan_duration_premium_star', 'value' => '30', 'type' => 'integer', 'description' => 'مدة صلاحية باقة Premium Star بالأيام.'],
            ['key' => 'plan_price_premium', 'value' => '30.00', 'type' => 'price', 'description' => 'سعر باقة Premium.'],
            ['key' => 'plan_duration_premium', 'value' => '15', 'type' => 'integer', 'description' => 'مدة صلاحية باقة Premium بالأيام.'],
            ['key' => 'plan_price_featured', 'value' => '15.00', 'type' => 'price', 'description' => 'سعر باقة Featured.'],
            ['key' => 'plan_duration_featured', 'value' => '7', 'type' => 'integer', 'description' => 'مدة صلاحية باقة Featured بالأيام.'],
            // -- Offers Box --
            // سننقل سعر اليوم إلى هنا لتوحيد المتغيرات المالية
            [
                'key' => 'offer_box_price_per_day_cars_sales', 
                'value' => '10.00', 
                'type' => 'price', 
                'description' => 'تكلفة اليوم الواحد لوضع إعلان في صندوق عروض بيع السيارات.'
            ]
        ]);
    }
};