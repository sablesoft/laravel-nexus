<?php

namespace App\Logic\Contracts;

interface HasEffectsContract
{
    public function getBefore(): ?array;
    public function getAfter(): ?array;
    public function getCode(): string;
}
