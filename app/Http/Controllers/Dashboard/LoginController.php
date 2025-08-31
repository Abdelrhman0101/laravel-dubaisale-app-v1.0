<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    /**
     * عرض صفحة تسجيل دخول الداش بورد.
     */
    public function showLoginForm()
    {
        // إذا كان المستخدم مسجل دخوله بالفعل، انقله للداش بورد
        if (auth()->check()) {
            return redirect('/dashboard');
        }
        // إذا لم يكن، اعرض الصفحة التي صممتها
        return view('auth.login-custom'); // سنقوم بإنشاء/نقل ملفك لهذا الاسم
    }

    /**
     * تسجيل خروج المستخدم من جلسة الويب.
     */
    public function logout()
    {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/login');
    }
}