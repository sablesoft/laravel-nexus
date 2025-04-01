<?php

namespace App\Logic\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Validator;


/**
 * Validation rule that accepts either a DSL expression string or a raw integer value.
 * This hybrid input style is useful when a field may reference a dynamic variable
 * (via string DSL) or provide a literal integer directly.
 *
 * If the value is a string, it is assumed to be a valid DSL expression and bypasses further checks.
 * If the value is an integer, optional validation rules can be applied using Laravel's validator.
 *
 * Environment:
 * - Commonly used in effect definitions where a parameter can be either a literal (e.g. ID)
 *   or a dynamic expression (e.g. `member.id`, `input.value`).
 * - Integrated with YAML/JSON DSL editors where both forms may occur.
 */
class StringOrIntRule implements ValidationRule
{
    /**
     * Additional Laravel validation rules applied when value is an integer.
     */
    public function __construct(protected array $rules = []) {}

    /**
     * Validate the attribute as either a string or an integer.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (is_string($value)) {
            return;
        }

        if (!is_int($value)) {
            $fail("The {$attribute} field must be a string (DSL) or an integer.");
            return;
        }

        if (empty($this->rules)) {
            return;
        }

        $data = ['value' => $value];

        $validator = Validator::make($data, $this->rules);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $message) {
                $fail($message);
            }
        }
    }
}
