<?php

namespace YFDev\System\App\Http\Middleware;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

/**
 * 驗證 Model 是否已經 Delete
 */
class VerifyDeleteModel
{
    public function handle(Request $request, \Closure $next)
    {
        foreach ($request->route()->parameters() as $param) {
            if ($param instanceof Model && $param->getAttribute('status') === 1) {
                throw (new ModelNotFoundException())->setModel(class_basename($param), $param->id);
            }
        }

        return $next($request);
    }
}
