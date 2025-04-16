<?php

namespace App\Models\Casts;

use App\Logic\Validators\BehaviorsValidator;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use InvalidArgumentException;

class Behaviors implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes): ?array
    {
        return $value ? json_decode($value, true) : null;
    }

    public function set($model, string $key, $value, array $attributes): array
    {
        if (is_string($value)) {
            $value = json_decode($value, true);
        }

        if (!is_array($value)) {
            throw new InvalidArgumentException("The value for '{$key}' must be a valid array or JSON string.");
        }

        BehaviorsValidator::validate($value);

        return [$key => json_encode($value, JSON_UNESCAPED_UNICODE)];
    }
}
