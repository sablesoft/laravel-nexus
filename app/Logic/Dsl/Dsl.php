<?php

namespace App\Logic\Dsl;

use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Illuminate\Database\Eloquent\Builder;

/**
 * Dsl is the core interpreter service for user-defined DSL expressions.
 * It is based on Symfony ExpressionLanguage and extended with additional functions,
 * including the ability to transform expressions into SQL queries via ExpressionQueryParser.
 *
 * The Dsl service is used throughout the platform wherever users can define
 * logical conditions, expressions, filters, or executable instructions.
 * For example, it's heavily used to execute before/after DSL blocks and logic
 * inside user-created scenarios, steps, and controls.
 * It can be used directly or accessed via the Dsl facade.
 *
 * Main responsibilities:
 * - Interpret expressions like: "member.id == 5 and memory.type == 'idea'"
 * - Apply such expressions to Laravel model queries (via Dsl::apply)
 * - Evaluate runtime values from expressions (via Dsl::evaluate)
 *
 * The DSL syntax supports variables, function calls, and full context access.
 * All data types are supported, including arrays, strings, numbers, booleans, null, enums, etc.
 *
 * ---
 * Environment:
 * - Used in EffectsRunner to evaluate values, conditions, and logic
 * - Applied to filtering Memory records (and others) via Dsl::apply in Livewire\Chat\Play
 * - Can be used in any before/after DSL instructions or other structured configurations
 * - Exposed via the App\Logic\Facades\Dsl facade
 */
class Dsl
{
    protected ExpressionLanguage $el;
    protected ExpressionQueryParser $queryParser;

    public function __construct()
    {
        $this->el = $this->makeExpressionLanguage();
        $this->queryParser = new ExpressionQueryParser();
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
}
