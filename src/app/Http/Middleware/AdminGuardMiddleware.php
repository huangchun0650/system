<?php

namespace YFDev\System\App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminGuardMiddleware
{
    public function handle($request, Closure $next)
    {
        Auth::shouldUse('admin');

        return $next($request);
    }
}
