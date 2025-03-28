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
trait HasSetup
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
        $class = self::class;
        $parts = explode('\\', $class);
        $code = $this->code ? '.'. $this->code : '';

        return strtolower(end($parts)) . $code;
    }

    public function getBeforeStringAttribute(): ?string
    {
        return $this->getSetupString('before');
    }

    public function getAfterStringAttribute(): ?string
    {
        return $this->getSetupString('after');
    }

    /**
     * @throws JsonException
     */
    public function setBeforeStringAttribute(?string $value): void
    {
        $this->setSetupStringAttribute('before', $value);
    }

    /**
     * @throws JsonException
     */
    public function setAfterStringAttribute(?string $value): void
    {
        $this->setSetupStringAttribute('after', $value);
    }

    /**
     * @throws JsonException
     */
    protected function setSetupStringAttribute(string $field, ?string $value): void
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

    protected function getSetupString(string $field): ?string
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
