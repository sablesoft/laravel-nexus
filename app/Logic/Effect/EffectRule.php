<?php

namespace App\Logic\Effect;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Symfony\Component\Yaml\Yaml;

class EffectRule implements ValidationRule
{
    protected string $lang;

    public function __construct(string $lang = 'yaml')
    {
        $this->lang = $lang;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_string($value)) {
            $fail('The :attribute must be a string.');
            return;
        }

        try {
            $parsed = match ($this->lang) {
                'json' => json_decode($value, true, 512, JSON_THROW_ON_ERROR),
                'yaml' => Yaml::parse($value),
                default => throw new \RuntimeException("Unsupported DSL language: {$this->lang}"),
            };

            if (!is_array($parsed)) {
                $fail('The :attribute must be a list of effects.');
                return;
            }

            EffectValidator::validate($parsed);
        } catch (\Throwable $e) {
            $fail($e->getMessage());
        }
    }
}
