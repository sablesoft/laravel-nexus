<?php

namespace App\Models\Traits;

use JsonException;

/**
 * @property null|array $before
 * @property null|string $beforeString
 * @property null|array $after
 * @property null|string $afterString
 */
trait HasEffects
{
    use HasJson;

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
        return $this->getJsonAsString('before');
    }

    public function getAfterStringAttribute(): ?string
    {
        return $this->getJsonAsString('after');
    }

    /**
     * @throws JsonException
     */
    public function setBeforeStringAttribute(?string $value): void
    {
        $this->setStringAsJson('before', $value);
    }


    /**
     * @throws JsonException
     */
    public function setAfterStringAttribute(?string $value): void
    {
        $this->setStringAsJson('after', $value);
    }
}
