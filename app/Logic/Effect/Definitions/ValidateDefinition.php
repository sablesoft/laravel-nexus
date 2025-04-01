<?php

namespace App\Logic\Effect\Definitions;

use App\Logic\Contracts\EffectDefinitionContract;

/**
 * Defines the `validate` effect, which applies Laravel-style validation rules
 * to the current process data. If validation fails, the execution is interrupted
 * with a validation error. This effect is useful for asserting preconditions
 * or enforcing data consistency between steps or scenarios.
 *
 * Only a limited and explicitly allowed set of validation rules is supported
 * to prevent abuse and ensure clarity in the DSL context.
 *
 * Environment:
 * - Registered in `EffectDefinitionRegistry` under the key `"validate"`.
 * - Executed by `ValidateHandler`, which runs Laravel's validator on the process data.
 * - Often used before branching or committing data to memory.
 */
class ValidateDefinition implements EffectDefinitionContract
{
    /**
     * Whitelisted Laravel validation rules supported in DSL.
     *
     * @var array<int, string>
     */
    const ALLOWED_RULES = [
        'required', 'string', 'integer', 'email', 'boolean',
        'min', 'max', 'in', 'nullable', 'array',
    ];

    public const KEY = 'validate';

    /**
     * Returns the DSL key that identifies this effect.
     */
    public static function key(): string
    {
        return self::KEY;
    }

    /**
     * Provides schema metadata for documentation and validation purposes.
     */
    public static function describe(): array
    {
        return [
            'title' => 'Validate Data',
            'description' => 'Applies validation rules to the current process data. Throws a validation error on failure.',
            'fields' => [
                '*' => [
                    'type' => 'string',
                    'description' => 'Validation rule string (e.g. "required|email")',
                ],
            ],
            'examples' => [
                ['validate' => ['email' => 'required|email', 'age' => 'integer|min:18']],
            ],
        ];
    }

    /**
     * Returns Laravel-compatible validation rules for validating the DSL block itself.
     *
     * Includes inline filtering to ensure that only allowed rules are used.
     */
    public static function rules(): array
    {
        return [
            '*' => [
                'required',
                'string',
                function (string $attribute, mixed $value, \Closure $fail) {
                    $rules = explode('|', $value);
                    foreach ($rules as $rule) {
                        $name = strtolower(trim(explode(':', $rule, 2)[0]));
                        if (!in_array($name, self::ALLOWED_RULES, true)) {
                            $fail("Rule [$name] is not allowed in [$attribute].");
                        }
                    }
                },
            ],
        ];
    }

    /**
     * This effect does not support nested effects.
     */
    public static function nestedEffects(array $params): array
    {
        return [];
    }
}
