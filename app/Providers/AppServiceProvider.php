<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\UrlGenerator; // ← AGREGAR ESTA LÍNEA

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(UrlGenerator $url): void // ← AGREGAR $url como parámetro
    {
        // Forzar HTTPS en producción (Render)
        if (env('APP_ENV') === 'production') {
            $url->forceScheme('https');
        }
    }
}