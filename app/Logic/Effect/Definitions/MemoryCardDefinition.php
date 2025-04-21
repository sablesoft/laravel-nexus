<?php

namespace App\Logic\Effect\Definitions;

use App\Logic\Contracts\EffectDefinitionContract;
use App\Logic\Rules\ExpressionOrBoolRule;
use App\Logic\Rules\ExpressionOrEnumRule;

class MemoryCardDefinition implements EffectDefinitionContract
{
    public const KEY = 'memory.card';

    public static function key(): string
    {
        return self::KEY;
    }

    public static function describe(): array
    {
        return [
            'title' => 'Generate Memory Card',
            'description' => 'Generates and stores a structured memory card using a task prompt and a predefined system template.',
            'fields' => [
                'type' => [
                    'type' => 'string',
                    'description' => 'Type of the generated memory card (place, item, etc, `card` by default).'
                ],
                'layout' => [
                    'type' => 'string',
                    'description' => 'Layout for generation task prompt.'
                ],
                'code' => [
                    'type' => 'string',
                    'description' => 'Unique code for the generated memory card (used for indexing in meta.card).'
                ],
                'title' => [
                    'type' => 'string',
                    'description' => 'Title of the card that will be visible to the user.'
                ],
                'task' => [
                    'type' => 'expression',
                    'description' => 'User-defined instructions describing what the card should contain.'
                ],
                'model' => [
                    'type' => 'string',
                    'description' => 'Model used for completion (e.g. gpt-4o, gpt-3.5-turbo).'
                ],
                'async' => [
                    'type' => 'expression',
                    'description' => 'Whether the request should be processed asynchronously.'
                ]
            ],
            'examples' => [
                [
                    'memory.card' => [
                        'type' => '>>place',
                        'layout' => 'layout_place',
                        'code' => '>>room',
                        'title' => '>>Room Description',
                        'task' => '>>Describe the interior of the room as it would be known to the system.',
                        'model' => '>>gpt-4o',
                        'async' => false
                    ]
                ]
            ]
        ];
    }

    public static function rules(): array
    {
        return [
            'type' => ['sometimes', 'nullable', 'string'],
            'layout' => ['required', 'string'],
            'code' => ['required', 'string'],
            'title' => ['required', 'string'],
            'task' => ['required', 'string'],
            'model' => ['sometimes', 'nullable', 'string', new ExpressionOrEnumRule(config('openai.gpt_models', ['gpt-4o']))],
            'async' => ['sometimes', 'nullable', new ExpressionOrBoolRule()],
        ];
    }

    public static function nestedEffects(array $params): array
    {
        return [];
    }
}
