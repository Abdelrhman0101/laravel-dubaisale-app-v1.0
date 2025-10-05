<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecureEndpoint
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->header('X-API-KEY');
        $expected = env('SIMPLE_API_KEY');

        if (! $apiKey || ! hash_equals((string) $expected, (string) $apiKey)) {
            Log::warning('SimpleApiKeyMiddleware blocked request', [
                'ip' => $request->ip(),
                'path' => $request->path(),
            ]);

            return response()->json(['message' => 'Unauthorized attempt detected.'], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
