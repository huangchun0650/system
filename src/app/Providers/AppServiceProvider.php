<?php

namespace YFDev\System\App\Providers;

use Illuminate\Support\ServiceProvider;
use YFDev\System\App\Constants\ApiResponse;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('api.response', function () {
            return new ApiResponse();
        });
    }
}
