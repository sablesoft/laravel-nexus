<?php

namespace App\Logic\Effect\Definitions;

use App\Logic\Act;
use App\Logic\Contracts\EffectDefinitionContract;
use App\Logic\Rules\ExpressionOrArrayRule;
use App\Logic\Rules\ExpressionOrBoolRule;
use App\Logic\Rules\ExpressionOrEnumRule;
use App\Logic\Rules\ExpressionOrTokenRule;

class CharacterActionDefinition implements EffectDefinitionContract
{
    public const KEY = 'character.action';

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
                'always' => [
                    'type' => 'list',
                    'description' => 'Effect list that will run everytime before cases and default.'
                ],
                'cases' => [
                    'type' => 'list',
                    'description' => 'List of action match filters and effect blocks. Only the first matching case will execute.',
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
                        'messages' => 'messages',
                        'allowed' => ['look', 'open', 'take'],
                        'always' => [
                            // effects to run every time
                        ],
                        'cases' => [
                            [
                                'do' => '>>look',
                                'what' => ['door'],
                                'then' => [
                                    // effects to hande this case
                                ]
                            ],
                            [
                                'do' => '>>take',
                                'what' => ['key'],
                                'from' => ['floor'],
                                'then' => [
                                    // effects to hande this case
                                ]
                            ]
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
        $actRules = [];
        foreach(Act::propertyKeys() as $property) {
            $actRules["value.*.$property"] = ['sometimes', new ExpressionOrArrayRule([
                'value' => 'array|min:1',
                'value.*' => [
                    'required',
                    new ExpressionOrTokenRule()
                ]
            ])];
        }
        return [
            'character' => 'sometimes|nullable',
            'ask' => 'sometimes|nullable',
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
            'always' => ['sometimes', 'nullable', new ExpressionOrArrayRule([
                'value' => 'array|min:1'
            ])],
            'cases' => ['sometimes', 'nullable', new ExpressionOrArrayRule([
                'value' => 'array|min:1',
                'value.*.do' => [
                    'required',
                    new ExpressionOrTokenRule()
                ],
                'value.*.then' => [
                    'required',
                    new ExpressionOrArrayRule([
                        'value' => 'array|min:1'
                    ]),
                ],
                ...$actRules
            ])],
            'default' => ['sometimes', 'nullable', new ExpressionOrArrayRule([
                'value' => 'array|min:1'
            ])]
        ];
    }

    public static function nestedEffects(array $params): array
    {
        $nested = [];

        foreach ($params['cases'] ?? [] as $i => $case) {
            if (isset($case['then']) && is_array($case['then'])) {
                $nested["cases.$i.then"] = $case['then'];
            }
        }
        foreach(['always', 'default'] as $handler) {
            if (!empty($params[$handler]) && is_array($params[$handler])) {
                $nested[$handler] = $params[$handler];
            }
        }

        return $nested;
    }
}
