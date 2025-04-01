<?php

namespace App\Logic\Effect\Definitions;

use App\Logic\Contracts\EffectDefinitionContract;
use App\Logic\Rules\StringOrArrayRule;

class ChatRefreshDefinition implements EffectDefinitionContract
{
    public const KEY = 'chat.refresh';

    public static function key(): string
    {
        return self::KEY;
    }

    public static function describe(): array
    {
        return [
            'title' => 'Refresh Chat',
            'description' => 'Triggers a chat refresh for selected screens. If parameter omitted, all screens are refreshed.',
            'fields' => [],
            'examples' => [
                ['chat.refresh' => 'screens'],
                ['chat.refresh' => ['>>main', '>>lobby']],
            ],
        ];
    }

    public static function rules(): array
    {
        return [
            'value' => ['sometimes', new StringOrArrayRule([
                'value' => 'array|min:1',
                'value.*' => 'string'
            ])],
        ];
    }

    public static function nestedEffects(array $params): array
    {
        return [];
    }
}
