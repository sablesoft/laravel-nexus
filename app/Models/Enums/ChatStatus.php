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

    public static function options(): array
    {
        return [
            self::Created->value => __('chat-status.created'),
            self::Published->value => __('chat-status.published'),
            self::Started->value => __('chat-status.started'),
            self::Ended->value => __('chat-status.ended'),
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
