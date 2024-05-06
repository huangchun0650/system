<?php

namespace YFDev\System\App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CustomerGuardMiddleware
{
    public function handle($request, Closure $next)
    {
        Auth::shouldUse('customer');

        return $next($request);
    }
}
