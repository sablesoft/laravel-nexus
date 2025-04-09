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
        $state = $this->states['has'][$key] ?? throw new \DomainException("State '{$key}' not found.");

        if (!empty($state['constant'])) {
            throw new \LogicException("State '{$key}' is constant and cannot be modified");
        }

        $state['value'] = $value;

        $this->validateState($key, $state);
        $states = $this->states;
        $states['has'][$key]['value'] = $value;
        $this->states = $states;
        $this->save();
    }

    public function randomState(string $key): mixed
    {
        $state = $this->states['has'][$key] ?? throw new \DomainException("State '{$key}' not found.");
        $this->validateState($key, $state);
        switch ($state['type']) {
            case 'bool':
                return fake()->boolean();
            case 'enum':
                $options = $state['options'] ?? [];
                if (empty($options)) {
                    throw new \UnexpectedValueException("Enum '{$key}' has no options.");
                }
                return fake()->randomElement($options);
            case 'int':
                $max = $state['max'] ?? null;
                $min = $state['min'] ?? 0;
                if (is_null($max)) {
                    throw new \LogicException("State '{$key}' has no max value for random.");
                }
                if ($min > $max) {
                    throw new \LogicException("State '{$key}' has invalid range: min > max.");
                }
                return fake()->numberBetween($min, $max);
            default:
                throw new \LogicException("Cannot randomize state '{$key}' with type '{$state['type']}'");
        }
    }

    public function nextState(string $key): mixed
    {
        $state = $this->states['has'][$key] ?? throw new \DomainException("State '{$key}' not found.");
        $this->validateState($key, $state);

        return match ($state['type']) {
            'bool' => !$state['value'],
            'int'  => $state['value'] + 1,
            'enum' => $this->cycleEnum($state['value'], $state['options'] ?? []),
            default => throw new \LogicException("Cannot advance state of type '{$state['type']}'"),
        };
    }

    public function prevState(string $key): mixed
    {
        $entry = $this->states[$key] ?? throw new \DomainException("State '{$key}' not found.");
        $this->validateState($key, $entry);

        return match ($entry['type']) {
            'bool' => !$entry['value'],
            'int'  => $entry['value'] - 1,
            'enum' => $this->cycleEnum($entry['value'], $entry['options'] ?? [], backward: true),
            default => throw new \LogicException("Cannot reverse state of type '{$entry['type']}'"),
        };
    }

    protected function cycleEnum(string $current, array $options, bool $backward = false): string
    {
        $index = array_search($current, $options, true);
        if ($index === false) {
            throw new \UnexpectedValueException("Value '{$current}' not found in enum options.");
        }

        $count = count($options);
        if ($count === 0) {
            throw new \UnexpectedValueException("Enum options are empty.");
        }

        $newIndex = ($backward)
            ? ($index - 1 + $count) % $count
            : ($index + 1) % $count;

        return $options[$newIndex];
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
