<?php

namespace App\Models\Traits;

use JsonException;
use Symfony\Component\Yaml\Yaml;

trait HasJson
{
    /**
     * @throws JsonException
     */
    protected function setStringAsJson(string $field, ?string $value): void
    {
        if (is_null($value)) {
            $this->$field = null;
            return;
        }

        $editor = config('dsl.editor', 'json');

        try {
            if ($editor === 'yaml') {
                $decoded = Yaml::parse($value);
            } else {
                $decoded = json_decode($value, true, 512, JSON_THROW_ON_ERROR);
            }

            $this->$field = $decoded;
        } catch (\Throwable $e) {
            throw new JsonException("Invalid $editor decoding for field $field: " . $e->getMessage(), previous: $e);
        }
    }

    protected function getJsonAsString(string $field): ?string
    {
        $value = $this->$field;

        if (!$value) {
            return null;
        }

        $editor = config('dsl.editor', 'json');

        return $editor === 'yaml'
            ? Yaml::dump($value, 10, 2)
            : json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}
