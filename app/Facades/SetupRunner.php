<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class SetupRunner extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'setup-runner';
    }
}
