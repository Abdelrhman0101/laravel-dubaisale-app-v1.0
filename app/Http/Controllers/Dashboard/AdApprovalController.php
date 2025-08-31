<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\AdApprovalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdApprovalController extends Controller
{
    public function index(Request $request)
    {
        // لم نعد بحاجة لإنشاء توكن هنا
        // $adminUser = Auth::user(); 
        // $adminToken = $adminUser->createToken('dashboard-token')->plainTextToken;

        // سنقوم بجلب البيانات فقط
        // ملاحظة: بما أننا سنعتمد على API بالكامل، يمكننا إزالة هذا المنطق
        // وجعل الـ JavaScript يقوم بجلب كل شيء عند تحميل الصفحة
        $isManualApprovalActive = true; // قيمة ابتدائية
        $pendingAds = ['car_sales' => []]; // مصفوفة فارغة ابتدائية

        return view('ads-approval', [
            'isManualApprovalActive' => $isManualApprovalActive,
            'pendingAds' => $pendingAds,
        ]);
    }
}