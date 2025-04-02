<?php

namespace App\Logic\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PrefixedInRule implements ValidationRule
{
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
        if (!is_string($value) || !str_starts_with($value, $this->prefix)) {
            return;
        }
        $stripped = substr($value, strlen($this->prefix));
        if (!in_array($stripped, $this->allowed, true)) {
            $fail("The value [$stripped] is not in the list of supported options.");
        }
    }
}
