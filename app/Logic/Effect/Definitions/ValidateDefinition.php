<?php

namespace App\Logic\Effect\Definitions;

use App\Logic\Contracts\EffectDefinitionContract;

class ValidateDefinition implements EffectDefinitionContract
{
    const ALLOWED_RULES = [
        'required', 'string', 'integer', 'email', 'boolean',
        'min', 'max', 'in', 'nullable', 'array',
    ];

    public const KEY = 'validate';

    public static function key(): string
    {
        return self::KEY;
    }

    public static function describe(): array
    {
        return [
            'type' => 'map',
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

    public static function nestedEffects(array $params): array
    {
        return [];
    }
}
