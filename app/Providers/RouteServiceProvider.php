<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    public static function home(): string
    {
        // Redirect users based on their role
        if (auth()->check()) {
            return auth()->user()->role === 'admin'
                ? '/admin/dashboard'
                : '/shop/home';
        }

        return '/shop/home';
    }
}
