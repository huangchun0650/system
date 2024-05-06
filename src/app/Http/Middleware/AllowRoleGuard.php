<?php

namespace YFDev\System\App\Http\Middleware;

use Illuminate\Http\Request;
use YFDev\System\App\Constants\ErrorCode;
use YFDev\System\App\Exceptions\Auth\AllowRoleException;

/**
 * 允許的角色 Guard
 *
 * Class AllowRoleGuard
 */
class AllowRoleGuard
{
    public function handle(Request $request, \Closure $next, ...$allowGuards)
    {
        if (! $request->route()->hasParameter('role')) {
            return $next($request);
        }

        $role = $request->role;

        if (! in_array($role->guard_name, $allowGuards)) {
            throw new AllowRoleException("The parameters {$role->id} invalid", ErrorCode::INVALID_REQUEST);
        }

        return $next($request);
    }
}
