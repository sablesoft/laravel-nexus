<?php

namespace App\Models\Traits;

use JsonException;
use Symfony\Component\Yaml\Yaml;

/**
 * @property null|array $before
 * @property null|string $beforeString
 * @property null|array $after
 * @property null|string $afterString
 */
trait HasEffects
{
    public function getBefore(): ?array
    {
        return $this->before;
    }

    public function getAfter(): ?array
    {
        return $this->after;
    }

    public function getCode(): string
    {
        $code = $this->code ? ' ['. $this->code .']' : '';
        return class_basename(self::class) . $code .'#'. $this->getKey();
    }

    public function getBeforeStringAttribute(): ?string
    {
        return $this->getEffectsString('before');
    }

    public function getAfterStringAttribute(): ?string
    {
        return $this->getEffectsString('after');
    }

    /**
     * @throws JsonException
     */
    public function setBeforeStringAttribute(?string $value): void
    {
        $this->setEffectsStringAttribute('before', $value);
    }

    /**
     * @throws JsonException
     */
    public function setAfterStringAttribute(?string $value): void
    {
        $this->setEffectsStringAttribute('after', $value);
    }

    /**
     * @throws JsonException
     */
    protected function setEffectsStringAttribute(string $field, ?string $value): void
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

    protected function getEffectsString(string $field): ?string
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
