<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
{
    // تحقق مما إذا كان المستخدم مسجل دخوله ودوره هو 'admin'
    if ($request->user() && $request->user()->role === 'admin') {
        // إذا كان كذلك، اسمح للطلب بالمرور
        return $next($request);
    }

    // إذا لم يكن admin، امنعه وأرجع رسالة خطأ
    return response()->json(['error' => 'Unauthorized. Admin access required.'], 403); // 403 Forbidden
}
}
