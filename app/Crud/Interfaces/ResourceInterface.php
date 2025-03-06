<?php

namespace App\Crud\Interfaces;

interface ResourceInterface
{
    /**
     * @return bool
     */
    public static function accessAllowed(): bool;
}
