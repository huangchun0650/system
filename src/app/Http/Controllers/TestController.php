<?php

namespace YFDev\System\App\Http\Controllers;

use YFDev\System\App\Services\Test\TestService;

class TestController extends BaseController
{
    protected $testService;

    public function __construct(TestService $testService)
    {
        $this->testService = $testService;
    }

    public function ping()
    {
        return $this->testService->ping();
    }

    public function testRedis()
    {
        return $this->testService->testRedis();
    }

    public function testMeilisearch()
    {
        return $this->testService->testMeilisearch();
    }
}
