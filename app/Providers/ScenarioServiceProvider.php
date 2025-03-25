<?php

namespace App\Providers;

use App\Services\Scenario\ScenarioService;
use Illuminate\Support\ServiceProvider;

class ScenarioServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('scenario-service', function ($app) {
            return new ScenarioService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
