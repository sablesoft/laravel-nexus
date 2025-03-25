<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
class ScenarioService extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'scenario-service';
    }
}
