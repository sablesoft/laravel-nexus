<?php

namespace App\Logic\Effect\Definitions;

use App\Logic\Contracts\EffectDefinitionContract;
use App\Logic\Rules\ExpressionOrArrayRule;
use App\Logic\Rules\ExpressionOrBoolRule;
use App\Logic\Rules\ExpressionOrEnumRule;
use App\Logic\Rules\ExpressionOrTokenRule;

class ActionDefinition implements EffectDefinitionContract
{
    public const KEY = 'action';

    const HANDLERS = ['before', 'always', 'default'];

    public static function key(): string
    {
        return self::KEY;
    }

    public static function describe(): array
    {
        return [
            'title' => 'Classify and Interpret Player Action',
            'description' => 'Runs classification via OpenAI, converts result to Act, and matches against case filters with optional fallback.',
            'fields' => [
                'character' => [
                    'type' => 'expression',
                    'description' => 'Character performing the action (optional, taken from context if omitted).'
                ],
                'instruction' => [
                    'type' => 'expression',
                    'description' => 'The custom instruction for classify task (optional, taken from system views if ommited).'
                ],
                'ask' => [
                    'type' => 'expression',
                    'description' => 'The raw user message to classify (optional, taken from context if omitted).'
                ],
                'messages' => [
                    'type' => 'expression',
                    'description' => 'The chat history or context messages (optional, defaults to screen.messages()).'
                ],
                'allowed' => [
                    'type' => 'list',
                    'description' => 'Optional filter of allowed verbs (do-list) to include in behaviorsInfo().'
                ],
                'async' => [
                    'type' => 'expression',
                    'description' => 'Whether to perform classification asynchronously (default: false).'
                ],
                'before' => [
                    'type' => 'list',
                    'description' => 'Effect list that will run before all calls handling.'
                ],
                'pipeFlag' => [
                    'type' => 'expression',
                    'description' => 'Name of variable for pipe mode (default: null).'
                ],
                'always' => [
                    'type' => 'list',
                    'description' => 'Effect list that will run everytime before cases and default.'
                ],
                'default' => [
                    'type' => 'list',
                    'description' => 'Fallback effect list if no case matches.'
                ],
            ],
            'examples' => [
                [
                    'character.act' => [
                        'character' => 'character',
                        'ask' => 'ask',
                        'instruction' => 'special_instruction',
                        'messages' => 'messages',
                        'allowed' => ['look', 'open', 'take'],
                        'pipeFlag' => 'canContinue',
                        'always' => [
                            // effects to run every time
                        ],
                        'default' => [
                            // effects to run if no any other cases matched
                        ]
                    ]
                ]
            ]
        ];
    }

    public static function rules(): array
    {
        $handlers = [];
        foreach (self::HANDLERS as $handler) {
            $handlers[$handler] = ['sometimes', 'nullable', new ExpressionOrArrayRule([
                'value' => 'array|min:1'
            ])];
        }
        return [
            'character' => 'sometimes|nullable',
            'instruction' => 'sometimes|nullable|string',
            'ask' => 'sometimes|nullable',
            'pipeFlag' => 'sometimes|nullable|string',
            'model' => [
                'sometimes',
                'nullable',
                'string',
                new ExpressionOrEnumRule(config('openai.gpt_models', ['gpt-4o']))
            ],
            'messages' => ['sometimes', 'nullable', new ExpressionOrArrayRule([
                'value' => 'array|min:1',
                'value.*.role' => [
                    'required',
                    'string',
                    new ExpressionOrEnumRule(['user', 'system', 'assistant', 'tool'])
                ],
                'value.*.content' => 'required|string',
            ])],
            'allowed' => ['sometimes', 'nullable', new ExpressionOrArrayRule([
                'value' => 'array|min:1',
                'value.*' => [
                    'required',
                    new ExpressionOrTokenRule()
                ],
            ])],
            'async' => ['sometimes', 'nullable', new ExpressionOrBoolRule()],
            ...$handlers
        ];
    }

    public static function nestedEffects(array $params): array
    {
        $nested = [];
        foreach(self::HANDLERS as $handler) {
            if (!empty($params[$handler]) && is_array($params[$handler])) {
                $nested[$handler] = $params[$handler];
            }
        }

        return $nested;
    }
}
