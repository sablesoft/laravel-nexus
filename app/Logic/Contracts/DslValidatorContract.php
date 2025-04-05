<?php

namespace App\Logic\Contracts;

interface DslValidatorContract
{
    public static function validate(array $dsl): void;
}
