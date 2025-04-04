<?php

namespace App\Models\Traits;

use JsonException;

/**
 * @property null|array $states
 * @property null|string $statesString
 */
trait HasStates
{
    use HasJson;

    public function getStatesStringAttribute(): ?string
    {
        return $this->getJsonAsString('states');
    }

    /**
     * @throws JsonException
     */
    public function setStatesStringAttribute(?string $value): void
    {
        $this->setStringAsJson('states', $value);
    }
}
