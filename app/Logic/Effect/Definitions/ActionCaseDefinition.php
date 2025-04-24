<?php

namespace App\Logic\Effect\Definitions;

use App\Logic\Act;
use App\Logic\Contracts\EffectDefinitionContract;
use App\Logic\Rules\ExpressionOrArrayRule;
use App\Logic\Rules\ExpressionOrTokenRule;

class ActionCaseDefinition implements EffectDefinitionContract
{
    public const KEY = 'action.case';

    public static function key(): string
    {
        return self::KEY;
    }

    public static function describe(): array
    {
        $actFields = [];
        foreach (Act::properties() as $key => $desc) {
            $actFields[$key] = [
                'type' => 'expression',
                'description' => $desc
            ];
        }
        return [
            'title' => 'Classify Case for Character Action',
            'description' => 'Contains case filter for character action effect.',
            'fields' => [
                'name' => [
                    'type' => 'expression',
                    'description' => 'Expression with case name'
                ],
                'do' => [
                    'type' => 'expression',
                    'description' => 'The main match property - action verb'
                ],
                ... $actFields,
                'then' => [
                    'type' => 'list',
                    'description' => 'Effect list for this case'
                ],
            ],
            'examples' => [
                [
                    'character.action.case' => [
                        'name' => '>>look-door',
                        'do' => '>>look',
                        'what' => ['>>door'],
                        'then' => [
                            // effects to hande this case
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
            $actRules[$property] = ['sometimes', new ExpressionOrArrayRule([
                'value' => 'array|min:1',
                'value.*' => [
                    'required',
                    new ExpressionOrTokenRule()
                ]
            ])];
        }
        return [
            'name' => 'required|string',
            'do' => [
                'required',
                new ExpressionOrTokenRule()
            ],
            ...$actRules,
            'then' => [
                'required',
                new ExpressionOrArrayRule([
                    'value' => 'array|min:1'
                ]),
            ],
        ];
    }

    public static function nestedEffects(array $params): array
    {
        $nested = [];
        if (!empty($params['then']) && is_array($params['then'])) {
            $nested['then'] = $params['then'];
        }

        return $nested;
    }
}
