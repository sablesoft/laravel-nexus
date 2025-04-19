<?php

namespace App\Logic\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Accepts either:
 * - a DSL variable reference (e.g. user.input or someVar)
 * - or a static token in kebab-case (e.g. rusty-key, open, self)
 */
class ExpressionOrEnumRule implements ValidationRule
{
    use ExpressionTrait;

    /**
     * @param array<int, string> $allowed List of allowed values
     * @param null|string $prefix DSL string prefix
     */
    public function __construct(
        protected array $allowed,
        protected ?string $prefix = null
    ) {
        $this->prefix ??= config('dsl.string_prefix', '>>');
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        if ($this->isPrefixedString($value)) {
            $value = substr($value, strlen($this->prefix));
            if (!in_array($value, $this->allowed, true)) {
                $this->fail($attribute, $fail);
            }
            return;
        }

        if ($this->validateExpression($attribute, $value, $fail)) {
            return;
        }

        if (!in_array($value, $this->allowed, true)) {
            $this->fail($attribute, $fail);
        }
    }

    protected function fail(string $attribute, Closure $fail): void
    {
        $fail("The {$attribute} field must be a valid expression or value in enum list.");
    }
}
