<?php

namespace App\Logic\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Validator;

/**
 * Description:
 * Validates that the value is either a variable reference (string without DSL prefix)
 * or a literal array. This is useful for cases where both dynamic inputs and inline
 * configurations are allowed.
 *
 * Context:
 * - Used in effects where "array or variable" is acceptable — e.g., tools, calls.
 * - When an array is provided, it will be validated using standard Laravel rules.
 */
class VariableOrArrayRule implements ValidationRule
{
    use VariableTrait, ArrayTrait;

    /**
     * @param array<string, mixed> $rules Laravel-style rules to apply if the value is an array
     */
    public function __construct(
        protected array $rules = []
    ) {}

    /**
     * Validate the attribute as either a variable name (without prefix) or a literal array.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->validateVariable($attribute, $value, $fail)) {
            return;
        }

        $this->validateArray($attribute, $value, $fail);
    }
}
