<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdminWeb
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }
        // إذا لم يكن admin، أخرجه من الجلسة وأعده لصفحة الدخول مع رسالة خطأ
        Auth::logout();
        return redirect('/login')->with('error', 'You do not have admin access.');
    }
}