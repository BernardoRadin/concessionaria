<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Site;
use Illuminate\Support\Facades\View;

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
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $site = Site::first(); // Ou ajuste conforme sua lógica
            $view->with('logo', $site->Logo);
        });
    
    }
}
