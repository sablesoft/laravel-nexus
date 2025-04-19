<?php

namespace App\Logic\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Validation rule that accepts either a variable reference (string without DSL prefix) or a raw bool value.
 * This hybrid input style is useful when a field may reference a dynamic variable
 * (via string DSL) or provide a literal bool directly.
 *
 * If the value is a variable, it is assumed to be a valid DSL expression and bypasses further checks.
 *
 * Context:
 * - Commonly used in effect definitions where a parameter can be either a literal (e.g. true)
 *   or a dynamic expression (e.g. `flagValue`).
 * - Integrated with YAML/JSON DSL editors where both forms may occur.
 */
class ExpressionOrBoolRule implements ValidationRule
{
    use ExpressionTrait;

    /**
     * Validate the attribute as either a variable or an integer.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->validateExpression($attribute, $value, $fail)) {
            return;
        }

        if (!is_bool($value)) {
            $fail("The {$attribute} field must be a variable (DSL) or an boolean.");
        }
    }
}
