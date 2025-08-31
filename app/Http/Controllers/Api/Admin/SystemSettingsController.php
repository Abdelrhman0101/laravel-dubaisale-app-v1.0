<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class SystemSettingsController extends Controller
{
    /**
     * [Admin] عرض كل متغيرات النظام.
     */
    public function index()
    {
        // نستخدم keyBy('key') لتحويل المصفوفة إلى كائن يسهل الوصول إليه في الواجهة الأمامية
        // e.g., settings.free_ad_cycle_days.value
        return response()->json(SystemSetting::all()->keyBy('key'));
    }

    /**
     * [Admin] تحديث متغيرات النظام.
     * يقبل مصفوفة من الإعدادات لتحديثها دفعة واحدة.
     */
    public function store(Request $request)
    {
        // التحقق من أن البيانات القادمة هي مصفوفة من المفاتيح والقيم
        $validatedData = $request->validate([
            'settings' => 'required|array',
            'settings.*.key' => 'required|string|exists:system_settings,key',
            'settings.*.value' => 'required|string',
        ]);

        foreach ($validatedData['settings'] as $settingData) {
            SystemSetting::where('key', $settingData['key'])
                         ->update(['value' => $settingData['value']]);
        }
        cache()->forget('setting_manual_approval_mode');

        return response()->json([
            'message' => 'System settings updated successfully.'
        ]);
    }

    /**
     * [Admin] تحديث إعداد واحد معين.
     * يستخدم الـ Key Binding للعثور على الإعداد تلقائيًا.
     */
    public function update(Request $request, SystemSetting $setting)
    {
        $validatedData = $request->validate([
            'value' => 'required|string',
        ]);
        
        $setting->update(['value' => $validatedData['value']]);
        cache()->forget('setting_manual_approval_mode');

        return response()->json([
            'message' => "Setting '{$setting->key}' updated successfully.",
            'setting' => $setting
        ]);
    }
}