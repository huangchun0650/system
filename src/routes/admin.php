<?php

use YFDev\System\App\Http\Controllers\TestController;
use YFDev\System\App\Http\Controllers\AuthController;
use YFDev\System\App\Http\Controllers\MediaController;
use YFDev\System\App\Http\Controllers\AdminController;
use YFDev\System\App\Http\Controllers\MenuController;
use YFDev\System\App\Http\Controllers\SettingController;
use YFDev\System\App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

/**
 * 測試用api
 */
Route::group(['prefix' => 'test'], function () {
    Route::get('ping', [TestController::class, 'ping']);
    Route::get('redis', [TestController::class, 'testRedis']);
    Route::get('meiliSearch', [TestController::class, 'testMeilisearch']);
});

Route::get('captcha', [AuthController::class, 'getCaptcha']);

Route::post('login', [AuthController::class, 'login']);

// Has Authenticate
Route::group(['middleware' => ['auth:admin']], function () {
    // Auth API
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);

    // Self Data API
    Route::group(['prefix' => 'self'], function () {
        Route::get('profile', [AuthController::class, 'profile']);
        Route::get('menuList', [AuthController::class, 'menuList']);
    });

    // Upload Media API
    Route::post('uploadMedia/{type}', [MediaController::class, 'upload'])
        ->can('product.create');

    // Admin User API
    Route::group(['prefix' => 'admin'], function () {
        Route::get('/', [AdminController::class, 'list'])
            ->can('admin.read.list');
        Route::get('{admin}', [AdminController::class, 'detail'])
            ->can('admin.read.detail');
        Route::post('/', [AdminController::class, 'store'])
            ->can('admin.create');
        Route::patch('{admin}', [AdminController::class, 'update'])
            ->can('admin.update');
        Route::delete('{admin}', [AdminController::class, 'destroy'])
            ->can('admin.delete');
    });

    // Menu API
    Route::group(['prefix' => 'menu'], function () {

        Route::get('options', [MenuController::class, 'options'])
            ->can('role.create');

        Route::get('/', [MenuController::class, 'tree'])
            ->can('menu.read.list');
        Route::post('/', [MenuController::class, 'store'])
            ->can('menu.create');
        Route::patch('{menu}', [MenuController::class, 'update'])
            ->can('menu.update');
        Route::delete('{menu}', [MenuController::class, 'destroy'])
            ->can('menu.delete');
    });

    // Setting For BackEnd Developers
    Route::group(['prefix' => 'setting', 'middleware' => 'can:setting'], function () {
        Route::get('method/options', [SettingController::class, 'methodOptions']);
        Route::get('permission/options', [SettingController::class, 'permissionOptions']);
        Route::get('rule/options', [SettingController::class, 'ruleOptions']);
        // 選單規則
        Route::group(['prefix' => 'menuRule'], function () {
            Route::get('/', [SettingController::class, 'menuRules']);
            Route::patch('{menu}', [SettingController::class, 'updateMenuRules']);
        });
        // 規則設定
        Route::group(['prefix' => 'rule'], function () {
            Route::post('/', [SettingController::class, 'createRule']);
            Route::get('/', [SettingController::class, 'ruleList']);
            Route::get('{rule}', [SettingController::class, 'ruleDetail']);
            Route::patch('{rule}', [SettingController::class, 'updateRule']);
            Route::delete('{rule}', [SettingController::class, 'deleteRule']);
        });

    });

    // Role API
    Route::group(['prefix' => 'role'], function () {
        Route::get('options', [RoleController::class, 'options']);

        Route::post('/', [RoleController::class, 'store'])
            ->can('role.create');
        Route::get('', [RoleController::class, 'list'])
            ->can('role.read.list');
        Route::get('{role}', [RoleController::class, 'detail'])
            ->can('role.read.detail');
        Route::patch('{role}', [RoleController::class, 'update'])
            ->can('role.update');
        Route::delete('{role}', [RoleController::class, 'destroy'])
            ->can('role.delete');
    });
});