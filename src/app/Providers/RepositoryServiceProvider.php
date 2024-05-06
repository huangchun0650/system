<?php

namespace YFDev\System\App\Providers;

use YFDev\System\App\Repositories\Admin\AdminRepository;
use YFDev\System\App\Repositories\Admin\AdminRepositoryInterface;
use YFDev\System\App\Repositories\Auth\AuthRepository;
use YFDev\System\App\Repositories\Auth\AuthRepositoryInterface;
use YFDev\System\App\Repositories\Menu\MenuRepository;
use YFDev\System\App\Repositories\Menu\MenuRepositoryInterface;
use YFDev\System\App\Repositories\Role\RoleRepository;
use YFDev\System\App\Repositories\Role\RoleRepositoryInterface;
use YFDev\System\App\Repositories\Setting\PermissionRepository;
use YFDev\System\App\Repositories\Setting\PermissionRepositoryInterface;
use YFDev\System\App\Repositories\Setting\RuleRepository;
use YFDev\System\App\Repositories\Setting\RuleRepositoryInterface;
use YFDev\System\App\Repositories\Setting\MethodRepository;
use YFDev\System\App\Repositories\Setting\MethodRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * 指定提供者載入是否延緩
     *
     * @var bool
     */
    protected $defer = TRUE;

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            AdminRepositoryInterface::class,
            AdminRepository::class
        );

        $this->app->bind(
            AuthRepositoryInterface::class,
            AuthRepository::class
        );

        $this->app->bind(
            MenuRepositoryInterface::class,
            MenuRepository::class
        );

        $this->app->bind(
            PermissionRepositoryInterface::class,
            PermissionRepository::class
        );

        $this->app->bind(
            RuleRepositoryInterface::class,
            RuleRepository::class
        );

        $this->app->bind(
            MethodRepositoryInterface::class,
            MethodRepository::class
        );

        $this->app->bind(
            RoleRepositoryInterface::class,
            RoleRepository::class
        );

        $this->app->bind(
            CustomerRepositoryInterface::class,
            CustomerRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
