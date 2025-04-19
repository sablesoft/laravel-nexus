<?php

namespace App\Logic\Dsl;

use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Illuminate\Database\Eloquent\Builder;

/**
 * Dsl is the core interpreter service for user-defined DSL expressions.
 * It is based on Symfony ExpressionLanguage and extended with additional functions,
 * including the ability to transform expressions into SQL queries via QueryExpressionParser.
 *
 * The Dsl service is used throughout the platform wherever users can define
 * logical conditions, expressions, filters, or executable instructions.
 * For example, it's heavily used to execute before/after DSL blocks and logic
 * inside user-created scenarios, steps, and controls.
 * It can be used directly or accessed via the Dsl facade.
 *
 * Main responsibilities:
 * - Interpret expressions like: "character.id == 5 and memory.type == 'idea'"
 * - Apply such expressions to Laravel model queries (via Dsl::apply)
 * - Evaluate runtime values from expressions (via Dsl::evaluate)
 *
 * The DSL syntax supports variables, function calls, and full context access.
 * All data types are supported, including arrays, strings, numbers, booleans, null, enums, etc.
 *
 * ---
 * Context:
 * - Used in EffectRunner to evaluate values, conditions, and logic
 * - Applied to filtering Memory records (and others) via Dsl::apply in Livewire\Chat\Play
 * - Can be used in any before/after DSL instructions or other structured configurations
 * - Exposed via the App\Logic\Facades\Dsl facade
 */
class Dsl
{
    protected ExpressionLanguage $el;
    protected QueryExpressionParser $queryParser;

    public function __construct()
    {
        $this->el = $this->makeExpressionLanguage();
        $this->registerBuiltins();
        $this->queryParser = new QueryExpressionParser();
    }

    /**
     * @noinspection PhpMixedReturnTypeCanBeReducedInspection
     */
    public function prefixed(string|array $value): mixed
    {
        if (is_string($value)) {
            return config('dsl.string_prefix', '>>').$value;
        }
        if (is_array($value)) {
            $prefixed = [];
            foreach ($value as $i => $v) {
                $prefixed[$i] = $this->prefixed($v);
            }
            return $prefixed;
        }

        return $value;
    }

    public function debug(string $message, array $context = [], ?string $code = null): void
    {
        if (!config('app.debug')) {
            return;
        }
        if (!$code || config("app.debugging.$code")) {
            $prefix = '[DSL]' . ($code ? '['.ucfirst($code).']': '');
            logger()->debug("$prefix$message", $context);
        }
    }

    /**
     * Applies a DSL expression to an Eloquent query.
     * Used for model filtering.
     */
    public function apply(Builder $query, string $expression, array $context = []): Builder
    {
        return $this->queryParser->apply($query, $expression, $context);
    }

    /**
     * Evaluates an expression in the context of PHP runtime values.
     */
    public function evaluate(string $expression, array $context = []): mixed
    {
        return $this->el->evaluate($expression, $context);
    }

    /**
     * Creates an ExpressionLanguage instance, with caching if enabled.
     */
    protected function makeExpressionLanguage(): ExpressionLanguage
    {
        $cacheEnabled = config('dsl.cache.enabled');

        return new ExpressionLanguage(
            $cacheEnabled ? app('cache.psr6') : null
        );
    }

    protected function registerBuiltins(): void
    {
        // json_encode(array)
        $this->el->register('json_encode', fn($arr, $sep) => '', fn ($args, $arr) => json_encode($arr));
        // append(array, value)
        $this->el->register('array_keys', fn($arr) => '', fn ($args, $arr) => array_keys($arr));
        // array_has(key)
        $this->el->register('array_has', fn($key) => '', fn ($args, $key) => \Arr::has($args, $key));
        // array_get(key, default)
        $this->el->register('array_get', fn($key, $default) => '', fn ($args, $key, $default = null) =>
            \Arr::get($args, $key, $default)
        );
    }
}
