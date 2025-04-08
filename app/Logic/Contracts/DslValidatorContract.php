<?php

namespace App\Logic\Contracts;

interface DslValidatorContract
{
    public static function validate(mixed $dsl): void;
}
