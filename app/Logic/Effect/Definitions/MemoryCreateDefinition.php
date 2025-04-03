<?php

namespace App\Logic\Effect\Definitions;

use App\Logic\Contracts\EffectDefinitionContract;
use App\Logic\Rules\VariableOrArrayRule;
use App\Logic\Rules\VariableOrIntRule;
use App\Models\Image;
use App\Models\Member;
use Illuminate\Validation\Rules\Exists;

/**
 * Defines the `memory.create` effect, which persists a new memory record
 * into the database. Used to log contextual or narrative information tied
 * to the current screen, user, or logic flow.
 *
 * This effect is useful for storing traceable or retrievable information during
 * interactive scenarios — such as messages, annotations, or structured interactions.
 *
 * Context:
 * - Registered under the key `"memory.create"` in `EffectDefinitionRegistry`.
 * - Executed by `MemoryCreateHandler`, which persists data to the `memories` table.
 * - Supports both direct field assignment and references via DSL expressions.
 * - Uses Laravel-style validation, including existence checks for foreign keys.
 *
 * Examples:
 * - Basic memory creation with inline data:
 *   ```yaml
 *   - memory.create:
 *       type: '>>message'
 *       data:
 *         content: 'ask'
 *         member_id: member.id
 *   ```
 *
 * - Using a variable to hold the memory payload:
 *   ```yaml
 *   - memory.create:
 *       data: memory_payload
 *   ```
 *
 * - Creating a structured memory with nested metadata:
 *   ```yaml
 *   - memory.create:
 *       data:
 *         title: '>>Chapter 1'
 *         content: '>>The hero wakes up...'
 *         meta:
 *           tags: ['>>intro', '>>awakening']
 *           chapter: 1
 *   ```
 */
class MemoryCreateDefinition implements EffectDefinitionContract
{
    public const KEY = 'memory.create';

    /**
     * Returns the DSL key that identifies this effect.
     */
    public static function key(): string
    {
        return self::KEY;
    }

    /**
     * Provides a structured schema for documentation, autocompletion, and validation.
     */
    public static function describe(): array
    {
        return [
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

    /**
     * Validation rules for compile-time structure checking.
     *
     * Uses `StringOrIntRule` to support both DSL expressions and direct IDs.
     */
    public static function rules(): array
    {
        return [
            'type' => 'sometimes|string',
            'data' => ['required', new VariableOrArrayRule([
                'author_id' => [
                    'sometimes', 'nullable',
                    new VariableOrIntRule(['value' => new Exists(Member::class, 'id')])
                ],
                'member_id' => [
                    'sometimes', 'nullable',
                    new VariableOrIntRule(['value' => new Exists(Member::class, 'id')])
                ],
                'image_id' => [
                    'sometimes', 'nullable',
                    new VariableOrIntRule(['value' => new Exists(Image::class, 'id')])
                ],

                'title' => 'sometimes|nullable|string|max:300',
                'content' => 'sometimes|nullable|string|max:2000',
                'meta' => ['sometimes', 'nullable', new VariableOrArrayRule([])],
            ])],
        ];
    }

    /**
     * This effect does not support nesting.
     */
    public static function nestedEffects(array $params): array
    {
        return [];
    }
}
