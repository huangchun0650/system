<?php

namespace YFDev\System\App\Services\Test;

use Illuminate\Support\Facades\Redis;
use YFDev\System\App\Services\BaseService;
use MeiliSearch\Client;

class TestService extends BaseService
{
    public function __construct()
    {
    }

    /**
     * ping
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ping(): \Illuminate\Http\JsonResponse
    {
        $hash = exec("git rev-list --tags --max-count=1");
        $git_version = trim(exec("git describe --tags $hash"));
        return response()->json([
            'time'        => date('Y-m-d H:i:s'),
            'env'         => config('app.env'),
            'git_version' => $git_version,
        ]);
    }

    /**
     * testRedis
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function testRedis(): \Illuminate\Http\JsonResponse
    {
        Redis::set('test', 'success');
        return response()->json(Redis::get('test'));
    }

    /**
     * testMeilisearch
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function testMeilisearch(): \Illuminate\Http\JsonResponse
    {
        $client = new Client(config('scout.meilisearch.host'), config('scout.meilisearch.key'));
        $health = $client->health();
        return response()->json($health['status']);
    }
}
