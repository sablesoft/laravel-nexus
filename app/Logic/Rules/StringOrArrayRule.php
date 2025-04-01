<?php

namespace App\Logic\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Validator;

/**
 * Flexible validation rule that accepts either a raw DSL string or a literal array.
 * Useful when input can be provided in DSL format (YAML/JSON string) or directly
 * as a parsed array (e.g., from programmatic configuration or dynamic UI).
 *
 * If the value is a string, validation passes by default (assumed to be parsed later).
 * If the value is an array and additional rules are provided, those rules are applied
 * using Laravel's standard validation system.
 *
 * Environment:
 * - Used in effect parameter validation when supporting both string-based and structured input.
 * - Commonly combined with YAML-based editors or backend-driven overrides.
 */
class StringOrArrayRule implements ValidationRule
{
    /**
     * Additional Laravel validation rules to apply if value is an array.
     */
    public function __construct(protected array $rules = []) {}

    /**
     * Validate the attribute as either a string or an array.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (is_string($value)) {
            return;
        }

        if (!is_array($value)) {
            $fail("The {$attribute} field must be a string (DSL) or an array (literal).");
            return;
        }

        if (empty($this->rules)) {
            return;
        }

        $data = array_is_list($value) ? ['value' => $value] : $value;

        $validator = Validator::make($data, $this->rules);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $message) {
                $fail($message);
            }
        }
    }
}
