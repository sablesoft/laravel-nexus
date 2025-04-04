<?php

namespace App\Logic\Effect\Definitions;

use App\Logic\Contracts\EffectDefinitionContract;

class CommentDefinition implements EffectDefinitionContract
{
    public const KEY = 'comment';

    public static function key(): string
    {
        return self::KEY;
    }

    public static function describe(): array
    {
        return [
            'title' => 'Comment / Annotation',
            'description' => 'Stores a non-executable annotation in the DSL logic. Used for documentation or debugging.',
            'fields' => [
                'value' => [
                    'type' => 'string',
                    'description' => 'Inline comment string',
                ],
            ],
            'examples' => [
                ['comment' => 'Entering battle phase'],
                ['comment' => 'Step 3: prepare magic boost'],
            ],
        ];
    }

    public static function rules(): array
    {
        return [
            'value' => ['required', 'string'],
        ];
    }

    public static function nestedEffects(array $params): array
    {
        return [];
    }
}
