<?php

namespace App\Livewire\Workshop\Interfaces;

interface ResourceInterface
{
    /**
     * @return bool
     */
    public static function accessAllowed(): bool;
}
