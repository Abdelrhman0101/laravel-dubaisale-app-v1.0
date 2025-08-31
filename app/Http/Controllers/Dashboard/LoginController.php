<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

     public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        
        // محاولة تسجيل دخول المستخدم
        if (Auth::attempt($credentials)) {
            // التحقق من أن المستخدم هو admin
            if (Auth::user()->role !== 'admin') {
                // إذا لم يكن admin، أخرجه وأعده برسالة خطأ
                Auth::logout();
                return back()->withErrors([
                    'email' => 'You do not have permission to access the dashboard.',
                ]);
            }
            
            // إذا كان admin، قم بإنشاء الجلسة ووجهه للداش بورد
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        // إذا فشلت المصادقة، أعده لصفحة الدخول مع رسالة خطأ
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
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