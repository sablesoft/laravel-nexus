<?php

namespace App\Models\Traits;

use JsonException;

/**
 * @property null|array $behaviors
 * @property null|string $behaviorsString
 */
trait HasBehaviors
{
    use HasJson;

    public function getBehaviorsStringAttribute(): ?string
    {
        return $this->getJsonAsString('behaviors');
    }

    /**
     * @throws JsonException
     */
    public function setBehaviorsStringAttribute(?string $value): void
    {
        $this->setStringAsJson('behaviors', $value);
    }
}
