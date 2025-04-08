<?php

namespace App\Logic\Rules;

use App\Logic\Contracts\DslValidatorContract;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use InvalidArgumentException;
use Symfony\Component\Yaml\Yaml;

/**
 * Custom Laravel validation rule that parses and validates a DSL string
 * (YAML, JSON or raw) as a DSL-content. Ensures that the content is syntactically
 * and semantically valid before storing or executing it.
 *
 * Context:
 * - Used in request/form validation when editing behaviors blocks.
 * - Relies on specified dsl validator for recursive structure checks.
 * - Supports both YAML and JSON formats for flexibility in input.
 */
class DslRule implements ValidationRule
{
    /**
     * Language format of the input string: "yaml" or "json"
     */
    protected string $parser;

    protected array $allowedParsers = ['yaml', 'json', 'raw'];

    protected string|DslValidatorContract $validatorClass;

    public function __construct(string $validatorClass, string $parser = 'yaml')
    {
        if (!in_array($parser, $this->allowedParsers)) {
            throw new InvalidArgumentException('Invalid parser type');
        }
        $this->parser = $parser;
        if (class_exists($validatorClass) &&
            in_array(DslValidatorContract::class, class_implements($validatorClass))) {
            $this->validatorClass = $validatorClass;
        } else {
            throw new InvalidArgumentException('Invalid validator class');
        }
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
            $parsed = match ($this->parser) {
                'json' => json_decode($value, true, 512, JSON_THROW_ON_ERROR),
                'yaml' => Yaml::parse($value),
                'raw' => $value,
                default => throw new \RuntimeException("Unsupported DSL language: {$this->parser}"),
            };

            if ($this->parser !== 'raw' && !is_array($parsed)) {
                $fail('The :attribute must be an array.');
                return;
            }

            $this->validatorClass::validate($parsed);
        } catch (\Throwable $e) {
            $fail($e->getMessage());
        }
    }
}
