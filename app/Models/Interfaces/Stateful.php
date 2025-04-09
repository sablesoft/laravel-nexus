<?php

namespace App\Models\Interfaces;

interface Stateful
{
    public function getState(string $key): mixed;

    public function setState(string $key, mixed $value): void;

    public function validateState(string $key, array $state): void;

    public function getAllStates(): array;
}

