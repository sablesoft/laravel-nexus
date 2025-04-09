<?php

namespace App\Models\Interfaces;

interface Stateful
{
    public function getState(string $key): mixed;

    public function setState(string $key, mixed $value): void;

    public function nextState(string $key): mixed;
    public function prevState(string $key): mixed;

    public function randomState(string $key): mixed;

    public function validateState(string $key, array $state): void;

    public function getAllStates(): array;
}

