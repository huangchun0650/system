<?php

namespace YFDev\System\App\Http\Middleware;

use Closure;
use YFDev\System\App\Constants\ErrorCode;
use YFDev\System\App\Exceptions\Auth\JwtException;
use YFDev\System\App\Exceptions\Auth\SessionExpiredException;

abstract class AuthMiddleware
{
    abstract protected function isAdmin(): bool;

    /**
     * @throws JwtException
     * @throws SessionExpiredException
     */
    public function handle($request, Closure $next)
    {
        $jwt = get_jwt();
        if (blank($jwt)) {
            throw new JwtException('empty jwt token', ErrorCode::JWT_EMPTY);
        }

        if (! \Auth::check()) {
            throw new SessionExpiredException('session expired', ErrorCode::JWT_INVALID);
        }

        return $next($request);
    }
}
