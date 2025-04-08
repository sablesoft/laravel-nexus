<?php

namespace App\Logic\Dsl;

use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

class QueryExpressionRegistry
{
    public static function register(ExpressionLanguage $el): void
    {
        $el->register('like', fn($a, $b) => '', fn($args, $field, $pattern) => true);
        $el->register('ilike', fn($a, $b) => '', fn($args, $field, $pattern) => true);
        $el->register('between', fn($a, $b, $c) => '', fn($args, $field, $min, $max) => true);
        $el->register('is_null', fn($a) => '', fn($args, $field) => true);
        $el->register('is_not_null', fn($a) => '', fn($args, $field) => true);
        $el->register('has', fn($a, $b) => '', fn($args, $field, $key) => true);
        $el->register('has_any', fn($a, $b) => '', fn($args, $field, $keys) => true);
        $el->register('has_all', fn($a, $b) => '', fn($args, $field, $keys) => true);
    }
}
