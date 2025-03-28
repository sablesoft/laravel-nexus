<?php

namespace App\Providers;

use App\Services\AppIseed;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('iseed', function($app) {
            return new AppIseed;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Validator::extend('yaml', function ($attribute, $value, $parameters, $validator) {
            try {
                Yaml::parse($value);
                return true;
            } catch (ParseException) {
                return false;
            }
        }, 'The :attribute must contain valid YAML.');
    }
}
