<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    // protected $except = [
    //     // ==== أضف هذا السطر لاستثناء route تسجيل الدخول من حماية CSRF ====
    //     'api/login',
    //     // ====================================================================
    // ];
}