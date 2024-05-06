<?php

namespace YFDev\System\App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class AfterMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $log = [
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'ip' => $request->getClientIp(),
            'headers' => $request->headers->all(),
            'input' => $request->toArray(),
            'response' => json_decode($response->getContent(), true),
        ];
        Log::channel('api_log')->info('request', $log);

        return $response;
    }
}
