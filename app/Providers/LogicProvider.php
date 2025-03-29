<?php

namespace App\Providers;

use App\Logic\Dsl\Dsl;
use App\Logic\Runners\LogicRunner;
use App\Logic\Runners\NodeRunner;
use App\Logic\Runners\SetupRunner;
use Illuminate\Support\ServiceProvider;

class LogicProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('dsl', function ($app) {
            return new Dsl();
        });
        $this->app->singleton('logic-runner', function ($app) {
            return new LogicRunner();
        });
        $this->app->singleton('node-runner', function ($app) {
            return new NodeRunner();
        });
        $this->app->singleton('setup-runner', function ($app) {
            return new SetupRunner();
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
