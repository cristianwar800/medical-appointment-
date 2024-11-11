<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CitasServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../Services/Citas/Views', 'citas');

    }
}
