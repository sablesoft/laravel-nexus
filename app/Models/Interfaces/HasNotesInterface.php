<?php

namespace App\Models\Interfaces;

use App\Models\Note;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * @property-read Collection $notes
 */
interface HasNotesInterface
{
    public function notes(): MorphToMany;

    public function note(string $code): ?Note;
}
