<?php

namespace App\Providers;

use App\Logic\Dsl\Dsl;
use App\Logic\Effect\EffectDefinitionRegistry;
use App\Logic\Effect\EffectHandlerRegistry;
use App\Logic\Runners\EffectRunner;
use App\Logic\Runners\LogicRunner;
use App\Logic\Runners\NodeRunner;
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
        $this->app->singleton('effect-runner', function ($app) {
            return new EffectRunner();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        EffectHandlerRegistry::boot();
        EffectDefinitionRegistry::boot();
    }
}
