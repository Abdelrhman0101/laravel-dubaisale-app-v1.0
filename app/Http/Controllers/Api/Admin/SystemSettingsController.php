<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SystemSettingsController extends Controller
{
    // Cache keys for better performance
    private const CACHE_KEY_ALL_SETTINGS = 'system_settings_all';
    private const CACHE_KEY_PLANS = 'system_settings_plans';
    private const CACHE_TTL = 3600; // 1 hour

    /**
     * [Admin] عرض كل متغيرات النظام.
     */
    public function index()
    {
        // استخدام cache لتحسين الأداء
        $settings = Cache::remember(self::CACHE_KEY_ALL_SETTINGS, self::CACHE_TTL, function () {
            return SystemSetting::all()->keyBy('key');
        });

        return response()->json($settings);
    }

    /**
     * [Admin] عرض إعدادات الباقات فقط.
     */
    public function getPlansSettings()
    {
        $planSettings = Cache::remember(self::CACHE_KEY_PLANS, self::CACHE_TTL, function () {
            return SystemSetting::where('key', 'like', 'plan_%')
                ->orWhere('key', 'like', 'free_%')
                ->orWhere('key', 'like', 'max_price_%')
                ->orWhere('key', 'like', 'offer_box_%')
                ->get()
                ->keyBy('key');
        });

        return response()->json($planSettings);
    }

    /**
     * [Admin] تحديث متغيرات النظام.
     * يقبل مصفوفة من الإعدادات لتحديثها دفعة واحدة.
     */
    public function store(Request $request)
    {
        // تحسين validation مع رسائل خطأ أوضح
        $validator = Validator::make($request->all(), [
            'settings' => 'required|array|min:1',
            'settings.*.key' => [
                'required',
                'string',
                Rule::exists('system_settings', 'key')
            ],
            'settings.*.value' => 'required|string|max:1000',
        ], [
            'settings.required' => 'يجب إرسال إعدادات للتحديث.',
            'settings.array' => 'الإعدادات يجب أن تكون في شكل مصفوفة.',
            'settings.min' => 'يجب إرسال إعداد واحد على الأقل.',
            'settings.*.key.required' => 'مفتاح الإعداد مطلوب.',
            'settings.*.key.exists' => 'مفتاح الإعداد غير موجود في النظام.',
            'settings.*.value.required' => 'قيمة الإعداد مطلوبة.',
            'settings.*.value.max' => 'قيمة الإعداد طويلة جداً (الحد الأقصى 1000 حرف).',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'خطأ في البيانات المرسلة.',
                'errors' => $validator->errors()
            ], 422);
        }

        $validatedData = $validator->validated();
        $updatedSettings = [];

        try {
            foreach ($validatedData['settings'] as $settingData) {
                // التحقق من نوع البيانات وتطبيق validation إضافي
                $setting = SystemSetting::where('key', $settingData['key'])->first();
                
                if ($this->validateSettingValue($setting, $settingData['value'])) {
                    $setting->update(['value' => $settingData['value']]);
                    $updatedSettings[] = $setting->key;
                } else {
                    return response()->json([
                        'message' => "قيمة غير صحيحة للإعداد: {$setting->key}",
                        'error' => $this->getValidationErrorMessage($setting)
                    ], 422);
                }
            }

            // مسح cache بعد التحديث
            $this->clearSettingsCache();

            return response()->json([
                'message' => 'تم تحديث إعدادات النظام بنجاح.',
                'updated_settings' => $updatedSettings
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'حدث خطأ أثناء تحديث الإعدادات.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * [Admin] تحديث إعداد واحد معين.
     * يستخدم الـ Key Binding للعثور على الإعداد تلقائيًا.
     */
    public function update(Request $request, SystemSetting $setting)
    {
        $validator = Validator::make($request->all(), [
            'value' => 'required|string|max:1000',
        ], [
            'value.required' => 'قيمة الإعداد مطلوبة.',
            'value.max' => 'قيمة الإعداد طويلة جداً (الحد الأقصى 1000 حرف).',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'خطأ في البيانات المرسلة.',
                'errors' => $validator->errors()
            ], 422);
        }

        $validatedData = $validator->validated();

        try {
            // التحقق من صحة القيمة حسب نوع الإعداد
            if (!$this->validateSettingValue($setting, $validatedData['value'])) {
                return response()->json([
                    'message' => "قيمة غير صحيحة للإعداد: {$setting->key}",
                    'error' => $this->getValidationErrorMessage($setting)
                ], 422);
            }

            $setting->update(['value' => $validatedData['value']]);
            
            // مسح cache بعد التحديث
            $this->clearSettingsCache();

            return response()->json([
                'message' => "تم تحديث الإعداد '{$setting->key}' بنجاح.",
                'setting' => $setting
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'حدث خطأ أثناء تحديث الإعداد.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * [Admin] إضافة إعداد جديد للنظام.
     */
    public function createSetting(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'key' => 'required|string|unique:system_settings,key|max:255',
            'value' => 'required|string|max:1000',
            'type' => 'required|string|in:string,integer,price,boolean,json',
            'description' => 'nullable|string|max:500',
        ], [
            'key.required' => 'مفتاح الإعداد مطلوب.',
            'key.unique' => 'مفتاح الإعداد موجود بالفعل.',
            'key.max' => 'مفتاح الإعداد طويل جداً.',
            'value.required' => 'قيمة الإعداد مطلوبة.',
            'value.max' => 'قيمة الإعداد طويلة جداً.',
            'type.required' => 'نوع الإعداد مطلوب.',
            'type.in' => 'نوع الإعداد غير صحيح.',
            'description.max' => 'وصف الإعداد طويل جداً.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'خطأ في البيانات المرسلة.',
                'errors' => $validator->errors()
            ], 422);
        }

        $validatedData = $validator->validated();

        try {
            $setting = SystemSetting::create($validatedData);
            
            // مسح cache بعد الإضافة
            $this->clearSettingsCache();

            return response()->json([
                'message' => 'تم إضافة الإعداد بنجاح.',
                'setting' => $setting
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'حدث خطأ أثناء إضافة الإعداد.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * [Admin] حذف إعداد من النظام.
     */
    public function deleteSetting(SystemSetting $setting)
    {
        try {
            // التحقق من أن الإعداد ليس من الإعدادات الأساسية
            $criticalSettings = [
                'manual_approval_mode',
                'free_ad_cycle_days',
                'locations_emirates'
            ];

            if (in_array($setting->key, $criticalSettings)) {
                return response()->json([
                    'message' => 'لا يمكن حذف هذا الإعداد لأنه من الإعدادات الأساسية للنظام.',
                ], 403);
            }

            $setting->delete();
            
            // مسح cache بعد الحذف
            $this->clearSettingsCache();

            return response()->json([
                'message' => "تم حذف الإعداد '{$setting->key}' بنجاح.",
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'حدث خطأ أثناء حذف الإعداد.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Helper method للتحقق من صحة قيمة الإعداد حسب نوعه.
     */
    private function validateSettingValue(SystemSetting $setting, string $value): bool
    {
        switch ($setting->type) {
            case 'integer':
                return is_numeric($value) && (int)$value >= 0;
            
            case 'price':
                return is_numeric($value) && (float)$value >= 0;
            
            case 'boolean':
                return in_array(strtolower($value), ['true', 'false', '1', '0']);
            
            case 'json':
                json_decode($value);
                return json_last_error() === JSON_ERROR_NONE;
            
            case 'string':
            default:
                return true; // أي string صحيح
        }
    }

    /**
     * Helper method للحصول على رسالة خطأ validation حسب نوع الإعداد.
     */
    private function getValidationErrorMessage(SystemSetting $setting): string
    {
        switch ($setting->type) {
            case 'integer':
                return 'يجب أن تكون القيمة رقم صحيح أكبر من أو يساوي صفر.';
            
            case 'price':
                return 'يجب أن تكون القيمة رقم عشري أكبر من أو يساوي صفر.';
            
            case 'boolean':
                return 'يجب أن تكون القيمة true أو false.';
            
            case 'json':
                return 'يجب أن تكون القيمة في تنسيق JSON صحيح.';
            
            case 'string':
            default:
                return 'قيمة غير صحيحة.';
        }
    }

    /**
     * Helper method لمسح جميع cache الخاص بالإعدادات.
     */
    private function clearSettingsCache(): void
    {
        Cache::forget(self::CACHE_KEY_ALL_SETTINGS);
        Cache::forget(self::CACHE_KEY_PLANS);
        Cache::forget('setting_manual_approval_mode');
        
        // مسح أي cache إضافي قد يكون موجود
        $cacheKeys = [
            'locations_emirates',
            'system_settings_public'
        ];
        
        foreach ($cacheKeys as $key) {
            Cache::forget($key);
        }
    }
}
