<?php

namespace App\Logic\Contracts;

interface DslAdapterContract
{
    public function __get(string $name): mixed;

    public function id(): ?int;
}
