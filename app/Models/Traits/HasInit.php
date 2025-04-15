<?php

namespace App\Models\Traits;

use JsonException;

/**
 * @property null|array $init
 *
 * @property null|string $initString
 */
trait HasInit
{
    public function getInitStringAttribute(): ?string
    {
        return $this->getJsonAsString('init');
    }

    /**
     * @throws JsonException
     */
    public function setInitStringAttribute(?string $value): void
    {
        $this->setStringAsJson('init', $value);
    }
}
