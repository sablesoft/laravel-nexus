<?php

namespace App\Logic\Effect;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Symfony\Component\Yaml\Yaml;

/**
 * Custom Laravel validation rule that parses and validates a raw DSL string
 * (YAML or JSON) as a list of effects. Ensures that the content is syntactically
 * and semantically valid before storing or executing it.
 *
 * Context:
 * - Used in request/form validation when editing effect blocks (e.g., in controls or steps).
 * - Relies on `EffectValidator` for recursive structure checks.
 * - Supports both YAML and JSON formats for flexibility in input.
 */
class EffectRule implements ValidationRule
{
    /**
     * Language format of the input string: "yaml" or "json"
     */
    protected string $lang;

    public function __construct(string $lang = 'yaml')
    {
        $this->lang = $lang;
    }

    /**
     * Validate the attribute as a stringified list of effects.
     */
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
