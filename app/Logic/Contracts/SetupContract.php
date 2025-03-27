<?php

namespace App\Logic\Contracts;

interface SetupContract
{
    public function getBefore(): ?array;
    public function getAfter(): ?array;
}
