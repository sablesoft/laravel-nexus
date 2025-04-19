<?php

namespace App\Logic\Facades;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Facade;

/**
 * Facade for Dsl service.
 *
 * @method static mixed evaluate(string $expression, array $context = [])
 * @see \App\Logic\Dsl\Dsl::evaluate()
 *
 * @method static Builder apply(Builder $query, string $expression, array $context = [])
 * @see \App\Logic\Dsl\Dsl::apply()
 *
 * @method static void debug(string $message, array $context = [], ?string $code = null)
 * @see \App\Logic\Dsl\Dsl::debug()
 *
 * @method static mixed prefixed(string|array $value)
 * @see \App\Logic\Dsl\Dsl::prefixed()
 */
class Dsl extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'dsl';
    }
}
