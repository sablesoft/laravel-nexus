<?php

namespace App\Crud\Interfaces;

interface ShouldBelongsTo
{
    public function getBelongsToFields(): array;
}
