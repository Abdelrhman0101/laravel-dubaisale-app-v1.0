<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class PublicSettingsController extends Controller
{
    /**
     * عرض كل متغيرات النظام للعامة (للقراءة فقط).
     */
    public function index()
    {
        // 1. اجلب كل الإعدادات من قاعدة البيانات.
        // 2. استخدم keyBy('key') لتحويل المصفوفة إلى كائن يسهل الوصول إليه في الواجهة الأمامية.
        //    (e.g., settings.free_ad_cycle_days.value)
        $settings = SystemSetting::all()->keyBy('key');

        return response()->json($settings);
    }
}