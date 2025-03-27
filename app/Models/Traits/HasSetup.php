<?php

namespace App\Models\Traits;

use JsonException;

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
            $this->$field = $value;
            return;
        }
        $decoded = json_decode($value, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            $this->$field = $decoded;
        } else {
            throw new JsonException('Invalid json decoding for field '. $field . ': ' . $value);
        }
    }

    protected function getSetupString(string $field): ?string
    {
        return $this->$field ? json_encode($this->$field, JSON_PRETTY_PRINT) : null;
    }
}
