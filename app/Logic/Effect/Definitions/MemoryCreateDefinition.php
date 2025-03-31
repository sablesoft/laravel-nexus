<?php

namespace App\Logic\Effect\Definitions;

namespace App\Logic\Effect\Definitions;

use App\Logic\Contracts\EffectDefinitionContract;

class MemoryCreateDefinition implements EffectDefinitionContract
{
    public const KEY = 'memory.create';

    public static function key(): string
    {
        return self::KEY;
    }

    public static function describe(): array
    {
        return [
            'type' => 'map',
            'title' => 'Create Memory Record',
            'description' => 'Stores a new memory record of type `screen.code` or explicitly defined.',
            'fields' => [
                'type' => [
                    'type' => 'string',
                    'description' => 'Optional type of memory (defaults to screen.code). Must be prefixed with the string prefix to be treated as a literal.',
                ],
                'data' => [
                    'type' => 'map',
                    'description' => 'Required structured data to be stored as meta, may include content, member_id, etc.',
                ],
            ],
            'examples' => [
                [
                    'memory.create' => [
                        'type' => '>>message',
                        'data' => [
                            'content' => 'ask',
                            'member_id' => 'member.id'
                        ]
                    ],
                ],
                [
                    'memory.create' => [
                        'data' => 'memory_data'
                    ],
                ]
            ],
        ];
    }

    public static function rules(): array
    {
        return [
            'type' => 'sometimes|string',
            'data' => 'required|array',
            'data.author_id' => 'sometimes|nullable|integer|exists:members,id',
            'data.member_id' => 'sometimes|nullable|integer|exists:members,id',
            'data.image_id' => 'sometimes|nullable|integer|exists:images,id',
            'data.title' => 'sometimes|nullable|string|max:300',
            'data.content' => 'sometimes|nullable|string|max:2000',
            'data.meta' => 'sometimes|nullable|array',
        ];
    }

    public static function nestedEffects(array $params): array
    {
        return [];
    }
}
