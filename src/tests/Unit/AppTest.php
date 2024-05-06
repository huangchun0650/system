<?php

namespace Tests\Feature;

use Tests\TestCase;
use MeiliSearch\Client;
use Illuminate\Support\Facades\DB;

class AppTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_ping()
    {
        $response = $this->get('/admin/api/ping');

        $response->assertStatus(200);
    }

    /**
     * @test
     * @group buildTest
     *
    */
    public function it_can_connect_to_meilisearch()
    {
        $client = new Client(config('scout.meilisearch.host'), config('scout.meilisearch.key'));

        // 嘗試從Meilisearch獲取健康狀態
        $health = $client->health();

        $this->assertEquals('available', $health['status']);
    }

    /**
     * @test
     * @group buildTest
     *
    */
    public function it_can_connect_to_mysql()
    {
        // 簡單的數據庫查詢來檢查連接
        $this->assertTrue(DB::connection()->getPdo() instanceof \PDO);
    }
}
