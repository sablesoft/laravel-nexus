<?php

namespace App\Models\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class LocaleString implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes): ?string
    {
        $locale = app()->getLocale();
        $data = json_decode($value ?: '{}', true);

        return $data[$locale] ?? null;
    }

    public function set($model, string $key, $value, array $attributes): array
    {
        $locale = app()->getLocale();
        $data = json_decode($attributes[$key] ?? '{}', true);
        $data[$locale] = $value;

        return [$key => json_encode($data)];
    }
}
