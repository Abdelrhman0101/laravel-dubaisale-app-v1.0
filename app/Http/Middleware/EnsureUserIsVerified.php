<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized attempt detected.'
            ], 401);
        }

        if ($user->role == "user" && !$user->otp_verified) {
            return response()->json([
                'message' => 'Your account is not verified.'
            ], 403);
        }

        return $next($request);

    }
}
