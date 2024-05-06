<?php

namespace YFDev\System\App\Http\Middleware;

use Illuminate\Support\Facades\Redis;

/**
 * 檢查重複提交 (防止重複提單表單，造成數據重複)
 */
class CheckRepeatPost
{
    /**
     * 重複POST請求間隔秒數
     */
    protected const POST_SUBMIT_DELAY = 2;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        if ($request->getRealMethod() == 'POST') {

            $redisKey = $this->getRedisKey($request->path());

            if (Redis::useWrite()->SETNX($redisKey, time())) {
                Redis::useWrite()->expire($redisKey, self::POST_SUBMIT_DELAY);
            } else {
                return json_response()->failedRepeatPost();
            }
        }

        return $next($request);
    }

    /**
     * 取得 Redis Key
     *
     * @return string
     */
    protected function getRedisKey(string $path)
    {
        $pathString = str_replace('-', '_', $path);
        $routes = explode('/', $pathString);
        $pathString = implode('_', $routes);
        $pathString .= '_'.strtolower(csrf_token());

        return 'cache:limit_submit:post:'.$pathString;
    }
}
