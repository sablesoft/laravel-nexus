<?php

namespace App\Logic\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class StringOrBooleanRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_string($value) && !is_bool($value)) {
            $fail("The {$attribute} field must be a string (DSL) or a boolean (literal).");
        }
    }
}
