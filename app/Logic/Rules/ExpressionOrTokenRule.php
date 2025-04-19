<?php

namespace App\Logic\Rules;

namespace App\Logic\Rules;

use App\Logic\Act;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Accepts either:
 * - a DSL variable reference (e.g. user.input or someVar)
 * - or a static prefixed token in kebab-case (e.g. '>>rusty-key', '>>open', '>>self')
 */
class ExpressionOrTokenRule implements ValidationRule
{
    use ExpressionTrait;

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_string($value)) {
            $this->fail($attribute, $fail);
            return;
        }

        if ($this->isPrefixedString($value)) {
            try {
                $token = substr($value, strlen($this->stringPrefix()));
                Act::validateToken($token);
            } catch (\InvalidArgumentException) {
                $this->fail($attribute, $fail);
            }
            return;
        }

        if (!$this->validateExpression($attribute, $value, $fail)) {
            $this->fail($attribute, $fail);
        }
    }

    protected function fail(string $attribute, Closure $fail): void
    {
        $fail("The {$attribute} field must be a prefixed kebab-case token (e.g. '>>rusty-key') or valid dsl expression.");
    }
}
