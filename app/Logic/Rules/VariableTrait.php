<?php

namespace App\Logic\Rules;

trait VariableTrait
{
    protected function validateVariable(string $attribute, mixed $value, \Closure $fail): bool
    {
        $prefix = config('dsl.string_prefix', '>>');
        if (is_string($value)) {
            // Reject prefixed string literals (e.g., >>text)
            if (str_starts_with($value, $prefix)) {
                $fail("The {$attribute} field must be a variable (without {$prefix}) or an array.");
                return true;
            }

            // Optionally validate variable naming (e.g., a, a.b.c, user.name)
            if (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_.]*$/', $value)) {
                $fail("The {$attribute} field must be a valid variable name.");
            }

            return true;
        }

        return false;
    }
}
