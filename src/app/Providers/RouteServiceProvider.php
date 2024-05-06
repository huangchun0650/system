<?php

namespace YFDev\System\App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Route as Routing;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();

        $this->canAny();
        $this->footprint();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('admin/api')
            ->middleware('admin')
            ->namespace($this->namespace)
            ->group(base_path('routes/admin.php'));

        Route::prefix('api')
            ->middleware('customer')
            ->namespace($this->namespace)
            ->group(base_path('routes/customer.php'));
    }

    /**
     * 滿足其一的 can 判斷
     *
     * @return void
     */
    protected function canAny()
    {
        Routing::macro('canAny', function (array $abilities, $models = []) {
            return collect($abilities)->contains(function ($ability) use ($models) {
                /** @var Routing $this */
                return $this->can($ability, $models);
            });
        });
    }

    /**
     * 用戶足跡紀錄
     *
     * @return void
     */
    protected function footprint()
    {
        Routing::macro('footprint', function (array $arguments) {
            $action = $arguments[0];
            return $this->middleware("user.footprint:{$action}");
        });
    }
}
