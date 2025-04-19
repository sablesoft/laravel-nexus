<?php

namespace App\Logic\Rules;

trait ExpressionTrait
{

    protected function validateExpression(string $attribute, mixed $value, \Closure $fail): bool
    {
        if (is_string($value)) {
            // Reject prefixed string literals (e.g., >>text)
            if ($this->isPrefixedString($value)) {
                $fail("The {$attribute} field must be a dsl expression (without string prefix) when contains string.");
                return true;
            }
            // todo - validate dsl expression

            return true;
        }

        return false;
    }

    protected function isPrefixedString(mixed $value): bool
    {
        return is_string($value) && str_starts_with($value, $this->stringPrefix());
    }

    protected function stringPrefix(): string
    {
        return config('dsl.string_prefix', '>>');
    }
}
