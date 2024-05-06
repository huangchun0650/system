<?php

namespace YFDev\System\App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class StorageAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (env('APP_ENV') === 'local') {
            if (str_starts_with($request->server('HTTP_USER_AGENT'), 'Postman')) {
                return $next($request);
            }
        }

        $referer = $request->header('Referer');

        if (is_null($referer)) {
            return response()->json(['message' => 'Access to this file is forbidden.'], 403);
        }

        $refererFound = false;

        foreach (config('white-ip')['allow_read_image'] as $allowedReferer) {
            if (strpos($referer, $allowedReferer) !== false) {
                $refererFound = true;
                break;
            }
        }

        if (! $refererFound) {
            Log::warning($referer.' try to load image');

            return response()->json(['message' => 'Access to this file is forbidden.'], 403);
        }

        return $next($request);
    }
}
