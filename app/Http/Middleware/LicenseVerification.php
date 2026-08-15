<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;

class LicenseVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // License check bypassed
        return $next($request);
    }
}
