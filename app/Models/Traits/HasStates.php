<?php

namespace App\Models\Traits;

use App\Models\Enums\StateType;
use App\Models\Interfaces\Stateful;
use Illuminate\Database\Eloquent\Model;
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

    public function getState(string $key): mixed
    {
        if (!array_key_exists($key, $this->states)) {
            throw new \DomainException("State '{$key}' is not defined for model " . class_basename($this));
        }

        $entry = $this->states[$key];
        $this->validateState($key, $entry);

        return $entry['value'];
    }

    public function setState(string $key, mixed $value): void
    {
        if (!array_key_exists($key, $this->states)) {
            throw new \DomainException("Cannot set undefined state '{$key}' on model " . class_basename($this));
        }

        $state = $this->states[$key];

        if (!empty($state['constant'])) {
            throw new \LogicException("State '{$key}' is constant and cannot be modified");
        }

        $state['value'] = $value;

        $this->validateState($key, $state);

        $this->states[$key]['value'] = $value;
        $this->save();
    }

    public function getAllStates(): array
    {
        return $this->states ?: [];
    }

    public function validateState(string $key, array $state): void
    {
        if (!isset($state['value'], $state['type'])) {
            throw new \UnexpectedValueException("State '{$key}' must have both 'value' and 'type'");
        }

        try {
            $type = StateType::from($state['type']);
        } catch (\ValueError) {
            throw new \UnexpectedValueException("Unknown state type '{$state['type']}' for key '{$key}'");
        }

        if (!$type->isValid($state)) {
            throw new \UnexpectedValueException("Invalid value for state '{$key}' of type '{$type->value}'");
        }
    }

    public static function savingAllStates(Model|Stateful $model): void
    {
        if ($model->isDirty('states') && !empty($model->states)) {
            foreach ($model->states['has'] as $key => $state) {
                $model->validateState($key, $state);
            }
        }
    }
}
