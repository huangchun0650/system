<?php

namespace YFDev\System\App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $middleware = [];
        if (request()->has('channel_name')) {
            if (str_starts_with(request()->input('channel_name'), 'private-admin')) {
                $middleware = ['middleware' => ['auth:admin']];
            } elseif (str_starts_with(request()->input('channel_name'), 'private-customer')) {
                $middleware = ['middleware' => ['auth:customer']];
            }
        }

        Broadcast::routes($middleware);

        require base_path('routes/channels.php');
    }
}
