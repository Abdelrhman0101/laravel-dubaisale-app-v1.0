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
        // --- هنا يجب عليك توفير توكن الـ Admin ---
        // الطريقة المثالية هي أن يكون للـ Admin توكن ثابت ومحفوظ
        // كحل مؤقت للتجربة، يمكنك وضعه هنا مباشرة
        $adminUser = Auth::user(); // افتراض أن المستخدم المسجل هو Admin
        
        // تحقق من وجود التوكن، إذا لم يكن، قم بإنشاء واحد
        // ملاحظة: هذا الكود سيعيد إنشاء التوكن في كل مرة، ليس مثاليًا للإنتاج
        $adminToken = $adminUser->createToken('dashboard-token')->plainTextToken;

        // إنشاء نسخة من الـ Service مع التوكن
        $approvalService = new AdApprovalService($adminToken);

        // جلب البيانات
        $isManualApprovalActive = $approvalService->getManualApprovalStatus();
        $pendingAds = $approvalService->getPendingAds();

        // تمرير البيانات إلى الـ View
        return view('ads-approval', [
            'isManualApprovalActive' => $isManualApprovalActive,
            'pendingAds' => $pendingAds,
            'adminToken' => $adminToken, // تمرير التوكن للـ Javascript
        ]);
    }
}