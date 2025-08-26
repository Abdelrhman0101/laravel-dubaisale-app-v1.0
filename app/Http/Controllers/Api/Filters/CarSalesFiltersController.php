<?php

namespace App\Http\Controllers\Api\Filters;

use App\Http\Controllers\Controller;
use App\Models\CarMake;
use App\Models\CarYear;
use Illuminate\Http\Request;

class CarSalesFiltersController extends Controller
{
    /**
     * جلب كل فلاتر قسم بيع السيارات في رد واحد منظم.
     * هذا الـ Endpoint مصمم خصيصًا لتعبئة قوائم البحث المنسدلة (Dropdowns) في الواجهة الأمامية.
     */
    public function index()
{
    // جلب Makes, Models, Trims كما كان
    $filters = CarMake::with('carModels.carTrims')->orderBy('name')->get();
    
    // ==== التغيير هنا ====
    // بدلاً من إنشاء نطاق، نقوم بجلب السنوات من قاعدة البيانات
    // نستخدم pluck('year') لجلب مصفوفة من السنوات فقط [2023, 2022, ...] وهو ما تحتاجه الواجهة
    $years = CarYear::orderBy('year', 'desc')->pluck('year');

    return response()->json([
        'makes' => $filters,
        'years' => $years,
    ]);
}
}