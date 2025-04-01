<?php

namespace App\Logic\Effect\Definitions;

use App\Logic\Contracts\EffectDefinitionContract;
use App\Logic\Rules\StringOrArrayRule;
use Illuminate\Validation\Rule;

class ChatCompletionDefinition implements EffectDefinitionContract
{
    public const KEY = 'chat.completion';

    public static function key(): string
    {
        return self::KEY;
    }

    public static function describe(): array
    {
        return [
            'title' => 'OpenAI Chat Completion',
            'description' => 'Sends a chat completion request to OpenAI, with optional tool-calling and response handling.',
            'fields' => [
                'model' => [
                    'type' => 'string',
                    'description' => 'The OpenAI model to use (e.g. gpt-4, gpt-3.5-turbo).',
                ],
                'messages' => [
                    'type' => 'list',
                    'description' => 'List of messages representing the chat history.',
                ],
                'temperature' => [
                    'type' => 'number',
                    'description' => 'Sampling temperature (optional).',
                ],
                'tool_choice' => [
                    'type' => 'string',
                    'description' => 'Specify how tools are used: auto, none, or specific tool name.',
                ],
                'max_tokens' => [
                    'type' => 'integer',
                    'description' => 'Maximum number of tokens to generate.',
                ],
                'top_p' => [
                    'type' => 'number',
                    'description' => 'Nucleus sampling parameter.',
                ],
                'stop' => [
                    'type' => 'list',
                    'description' => 'List of stop sequences.',
                ],
                'presence_penalty' => [
                    'type' => 'number',
                    'description' => 'Penalty for repeating new tokens.',
                ],
                'frequency_penalty' => [
                    'type' => 'number',
                    'description' => 'Penalty for frequent tokens.',
                ],
                'tools' => [
                    'type' => 'map',
                    'description' => 'Map of tool name to JSON schema definition.',
                ],
                'calls' => [
                    'type' => 'map',
                    'description' => 'Tool call handlers by name and optional "default". Each value is either scenario code (string) or effect list (array).',
                ],
                'response' => [
                    'type' => 'expression',
                    'description' => 'Fallback handler if no tool_call is present. Either scenario code or effect list.',
                ],
                'error' => [
                    'type' => 'expression',
                    'description' => 'Handler for errors (e.g. API/network). Either scenario code or effect list.',
                ],
            ],
            'examples' => [
                [
                    'openai.chat' => [
                        'model' => 'gpt-4',
                        'messages' => [
                            ['role' => 'user', 'content' => '>>Hi!']
                        ],
                        'tools' => [
                            'get_weather' => [
                                'description' => '>>Get weather info',
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
                            'get_weather' => '>>weather_scenario',
                            'default' => '>>fallback_scenario'
                        ],
                        'response' => '>>handle_response',
                        'error' => [
                            ['log' => ['message' => 'openai_error.message']]
                        ]
                    ]
                ],
                [
                    'openai.chat' => [
                        'model' => 'ai_model_var',
                        'messages' => 'messages_history_var',
                        'tools' => [
                            'get_weather' => 'get_weather_schema_var'
                        ],
                        'calls' => [
                            'get_weather' => '>>weather_scenario',
                            'default' => '>>fallback_scenario'
                        ],
                        'response' => '>>handle_response',
                        'error' => [
                            ['log' => ['message' => 'openai_error.message']]
                        ]
                    ]
                ]
            ],
        ];
    }

    public static function rules(): array
    {
        return [
            'model' => ['required', 'string', Rule::in(config('openai.gpt_models', ['gpt-4-turbo']))],

            'messages' => 'required|array|min:1',
            'messages.*.role' => ['required', 'string', Rule::in(['user', 'system', 'assistant', 'tool'])],
            'messages.*.content' => 'required|string',

            'temperature' => 'sometimes|numeric',
            'tool_choice' => ['sometimes', 'string', Rule::in(['none', 'auto', 'required', /* tool name allowed */])],
            'max_tokens' => 'sometimes|integer|min:1',
            'top_p' => 'sometimes|numeric',
            'stop' => 'sometimes|array',
            'stop.*' => 'string',
            'presence_penalty' => 'sometimes|numeric',
            'frequency_penalty' => 'sometimes|numeric',

            'tools' => 'sometimes|array',
            'tools.*.description' => 'required|string',
            'tools.*.parameters' => 'required|array',

            'calls' => 'sometimes|array',
            'calls.*' => [
                'required',
                new StringOrArrayRule(['*' => 'array|min:1'])
            ],
            'response' => [
                'sometimes',
                new StringOrArrayRule(['value' => 'array|min:1'])
            ],
            'error' => [
                'sometimes',
                new StringOrArrayRule(['value' => 'array|min:1'])
            ],
        ];
    }


    public static function nestedEffects(array $params): array
    {
        $nested = [];
        foreach ($params['calls'] ?? [] as $key => $value) {
            if (is_array($value)) {
                $nested["calls.$key"] = $value;
            }
        }

        if (isset($params['response']) && is_array($params['response'])) {
            $nested['response'] = $params['response'];
        }

        if (isset($params['error']) && is_array($params['error'])) {
            $nested['error'] = $params['error'];
        }

        return $nested;
    }
}
