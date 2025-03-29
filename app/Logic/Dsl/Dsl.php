<?php

namespace App\Logic\Dsl;

use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Illuminate\Database\Eloquent\Builder;

class Dsl
{
    protected ExpressionLanguage $el;

    protected ExpressionQueryParser $queryParser;

    public function __construct()
    {
        $this->el = $this->makeExpressionLanguage();
        $this->registerBuiltins();
        $this->queryParser = new ExpressionQueryParser();
    }

    public function apply(Builder $query, string $expression, array $context = []): Builder
    {
        return $this->queryParser->apply($query, $expression, $context);
    }

    public function evaluate(string $expression, array $context = []): mixed
    {
        return $this->el->evaluate($expression, $context);
    }

    protected function registerBuiltins(): void
    {
        // join(array, separator)
        $this->el->register('join', fn($arr, $sep) => '', function ($args, $arr, $sep) {
            return implode($sep, $arr);
        });

        // append(array, value)
        $this->el->register('append', fn($arr, $val) => '', function ($args, $arr, $val) {
            $arr[] = $val;
            return $arr;
        });

        // merge(a, b)
        $this->el->register('merge', fn($a, $b) => '', function ($args, $a, $b) {
            return array_merge($a, $b);
        });

        // has(key)
        $this->el->register('has', fn($key) => '', function ($args, $key) {
            return array_key_exists($key, $args);
        });

        // get(key, default)
        $this->el->register('get', fn($key, $default) => '', function ($args, $key, $default = null) {
            return $args[$key] ?? $default;
        });
    }

    protected function makeExpressionLanguage(): ExpressionLanguage
    {
        $cacheEnabled = config('dsl.cache.enabled');

        return new ExpressionLanguage( $cacheEnabled ? app('cache.psr6') : null);
    }
}
