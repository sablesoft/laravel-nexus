<?php

namespace App\Logic\Effect\Definitions;

use App\Logic\Contracts\EffectDefinitionContract;
use App\Logic\Rules\ExpressionOrArrayRule;
use App\Logic\Rules\ExpressionOrEnumRule;

/**
 * Defines the structure, validation, and editor schema for the `chat.completion` effect.
 * This effect sends a chat completion request to OpenAI API (via openai-php client)
 * and optionally supports tool-calling behavior with dynamic routing of tool responses
 * and message responses to effect blocks.
 *
 * Context:
 * - Registered via EffectDefinitionRegistry.
 * - Used by EffectsValidator for compile-time validation.
 * - Provides documentation and autocomplete hints inside the Codemirror DSL editor.
 * - Internally resolved and executed via ChatCompletionHandler.
 *
 * Examples:
 * - Basic usage with tool schema and response handler:
 *   ```yaml
 *   - chat.completion:
 *       model: 'gpt-4'
 *       messages:
 *         - role: 'user'
 *           content: '>>Hi!'
 *       async: true
 *       tools:
 *         get_weather:
 *           description: '>>Get weather info'
 *           parameters:
 *             type: '>>object'
 *             properties:
 *               location:
 *                 type: '>>string'
 *                 description: '>>City name'
 *             required: ['>>location']
 *       calls:
 *         get_weather: get_weather_effects
 *       content: content_effects
 *   ```
 * - Dynamic mode using variables:
 *   ```yaml
 *   - chat.completion:
 *       model: ai_model
 *       messages: messages_history
 *       tools: tools_schemas
 *       calls: calls_effects
 *       content: content_effects_var
 *   ```
 */
class ChatCompletionDefinition implements EffectDefinitionContract
{
    public const KEY = 'chat.completion';

    public static function key(): string
    {
        return self::KEY;
    }

    /**
     * Describes the structure of the effect for documentation and DSL editor support.
     * Returns schema-like definition of expected fields and sample usage examples.
     */
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
                'content' => [
                    'type' => 'expression',
                    'description' => 'Fallback handler for content. Either scenario code or effect list.',
                ],
                'async' => [
                    'type' => 'expression',
                    'description' => 'If true, the completion is sent asynchronously and effects will not wait for a response.',
                ],
            ],
            'examples' => [
                [
                    'openai.chat' => [
                        'model' => 'gpt-4',
                        'messages' => [
                            ['role' => 'user', 'content' => '>>Hi!']
                        ],
                        'async' => 'asyncFlag',
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
                            'get_weather' => 'get_weather_effects'
                        ],
                        'content' => 'content_effects',
                    ]
                ],
                [
                    'openai.chat' => [
                        'model' => 'ai_model_var',
                        'messages' => 'messages_history_var',
                        'tools' => 'tools_schema_var',
                        'calls' => 'calls_effects_var',
                        'content' => 'content_effects_var',
                        'async' => true,
                    ]
                ]
            ],
        ];
    }

    public static function rules(): array
    {
        return [
            'model' => [
                'sometimes',
                'nullable',
                'string',
                new ExpressionOrEnumRule(config('openai.gpt_models', ['gpt-4o']))
            ],

            'messages' => ['required', new ExpressionOrArrayRule([
                'value' => 'array|min:1',
                'value.*' => [
                    'required', new ExpressionOrArrayRule([
                        'role' => [
                            'required',
                            'string',
                            new ExpressionOrEnumRule(['user', 'system', 'assistant', 'tool'])
                        ],
                        'content' => 'required|string'
                    ]),
                ],
            ])],

            'temperature' => 'sometimes|numeric',
            'tool_choice' => ['sometimes', 'string'],
            'max_tokens' => 'sometimes|integer|min:1',
            'top_p' => 'sometimes|numeric',
            'stop' => 'sometimes|array',
            'stop.*' => 'string',
            'presence_penalty' => 'sometimes|numeric',
            'frequency_penalty' => 'sometimes|numeric',
            'async' => ['sometimes'],

            'tools' => ['sometimes', 'nullable', new ExpressionOrArrayRule([
                '*' => ['required', new ExpressionOrArrayRule([
                    'description' => 'required|string',
                    'parameters' => 'required|array',
                    'parameters.type' => 'required|string',
                    'parameters.properties' => 'required|array',
                    'parameters.required' => 'required|array',
                ])]
            ])],

            'calls' => ['sometimes', 'nullable', new ExpressionOrArrayRule([
                '*' => ['required', new ExpressionOrArrayRule(['value' => 'array|min:1'])]
            ])],
            'content' => ['sometimes', 'nullable', new ExpressionOrArrayRule([
                'value' => 'array|min:1'
            ])],
        ];
    }

    public static function nestedEffects(array $params): array
    {
        $nested = [];
        if (!empty($params['calls']) && is_array($params['calls'])) {
            foreach ($params['calls'] as $key => $value) {
                if (is_array($value)) {
                    $nested["calls.$key"] = $value;
                }
            }
        }

        if (!empty($params['content']) && is_array($params['content'])) {
            $nested['content'] = $params['content'];
        }

        return $nested;
    }
}
