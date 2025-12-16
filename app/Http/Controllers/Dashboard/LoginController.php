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
        // إذا كان المستخدم مسجل دخوله بالفعل
        if (Auth::check()) {
            // تحقق مما إذا كان admin
            if (Auth::user()->role === 'admin') {
                return redirect()->route('dashboard');
            }

            // إذا لم يكن admin، قم بتسجيل الخروج لعرض صفحة الدخول
            Auth::logout();
        }
        // إذا لم يكن، اعرض الصفحة التي صممتها
        return view('auth.login-custom'); // سنقوم بإنشاء/نقل ملفك لهذا الاسم
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required'],
        ]);

        // محاولة تسجيل دخول المستخدم
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // التحقق من أن المستخدم نشط (غير محظور)
            if (!$user->is_active) {
                Auth::logout();
                $message = 'Your account is blocked.';

                if ($request->wantsJson()) {
                    return response()->json(['message' => $message], 403);
                }

                return back()->withErrors([
                    'username' => $message,
                ]);
            }

            // التحقق من أن المستخدم هو admin
            if ($user->role !== 'admin') {
                // إذا لم يكن admin، أخرجه وأعده برسالة خطأ
                Auth::logout();
                $message = 'You do not have permission to access the dashboard.';

                if ($request->wantsJson()) {
                    return response()->json(['message' => $message], 403);
                }

                return back()->withErrors([
                    'username' => $message,
                ]);
            }

            // إذا كان admin، قم بإنشاء الجلسة ووجهه للداش بورد
            $request->session()->regenerate();

            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Login successful.',
                    'redirect' => route('dashboard')
                ]);
            }

            return redirect()->intended('dashboard');
        }

        // إذا فشلت المصادقة، أعده لصفحة الدخول مع رسالة خطأ
        $message = 'The provided credentials do not match our records.';

        if ($request->wantsJson()) {
            return response()->json(['message' => $message], 401);
        }

        return back()->withErrors([
            'username' => $message,
        ]);
    }

    /**
     * تسجيل خروج المستخدم من جلسة الويب.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
