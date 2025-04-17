<?php

namespace App\Models\Enums;

use App\Enums\EnumContract;
use App\Enums\EnumTrait;

enum ChatStatus: string implements EnumContract
{
    use EnumTrait;

    case Created = 'created';
    case Published = 'published';
    case Started = 'started';
    case Ended = 'ended';

    public static function getDefault(): ?self
    {
        return self::Created;
    }

    public static function options(?string $locale = null): array
    {
        return [
            self::Created->value => __('chat-status.created', [], $locale),
            self::Published->value => __('chat-status.published', [], $locale),
            self::Started->value => __('chat-status.started', [], $locale),
            self::Ended->value => __('chat-status.ended', [], $locale),
        ];
    }

    public static function publicValues(): array
    {
        return [
            self::Published->value,
            self::Started->value,
            self::Ended->value,
        ];
    }
}
