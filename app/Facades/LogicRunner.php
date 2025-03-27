<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class LogicRunner extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'logic-runner';
    }
}
