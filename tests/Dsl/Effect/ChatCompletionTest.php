<?php

use App\Logic\Effect\EffectValidator;

it('validates chat.completion with tools and handlers', function () {
    $effects = [
        ['chat.completion' => [
            'model' => '>>gpt-4',
            'messages' => [
                ['role' => '>>system', 'content' => '>>You are a bot'],
                ['role' => '>>user', 'content' => '>>Hello!'],
            ],
            'temperature' => 0.5,
            'tool_choice' => 'auto',
            'tools' => [
                'get_weather' => [
                    'description' => '>>Get weather for a city',
                    'parameters' => [
                        'type' => '>>object',
                        'properties' => [
                            'location' => [
                                'type' => '>>string',
                                'description' => '>>City name'
                            ]
                        ],
                        'required' => ['>>location']
                    ]
                ]
            ],
            'calls' => [
                'get_weather' => 'weather_call_var'
            ],
            'content' => [
                ['memory.create' => [
                    'type' => '>>message',
                    'data' => [
                        'content' => 'content'
                    ]
                ]]
            ]
        ]]
    ];

    EffectValidator::validate($effects);
    expect(true)->toBeTrue();
})->group('dsl', 'effect', 'effect-validate', 'effect:chat.completion');
