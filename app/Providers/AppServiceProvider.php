<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ZoomService;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(ZoomService::class, function ($app) {
            return new ZoomService();
        });
    }
}
