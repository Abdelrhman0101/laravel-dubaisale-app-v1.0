<?php
namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\OfferBoxSetting;
use Illuminate\Http\Request;

class OfferBoxSettingsController extends Controller
{
    // عرض كل الإعدادات الحالية
    public function index() {
        return response()->json(OfferBoxSetting::all());
    }

    // إضافة أو تحديث إعدادات قسم معين
    public function store(Request $request) {
        $data = $request->validate([
            'category_slug' => 'required|string',
            'max_ads' => 'required|integer|min:1',
            'price_per_day' => 'required|numeric|min:0',
        ]);

        // دالة ذكية: إذا كان الإعداد موجودًا، قم بتحديثه. إذا لم يكن، قم بإنشائه.
        $setting = OfferBoxSetting::updateOrCreate(
            ['category_slug' => $data['category_slug']],
            ['max_ads' => $data['max_ads'], 'price_per_day' => $data['price_per_day']]
        );

        return response()->json([
            'message' => "Settings for '{$setting->category_slug}' saved successfully.",
            'setting' => $setting,
        ], 200);
    }
}