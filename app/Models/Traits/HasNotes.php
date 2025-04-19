<?php

namespace App\Models\Traits;

use App\Models\Note;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasNotes
{
    public function notes(): MorphToMany
    {
        return $this->morphToMany(
            Note::class,
            'noteable',
            'note_usages'
        )->withPivot('code')->withTimestamps();
    }

    public function note(string $code): ?Note
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->notes()->wherePivot('code', $code)->first();
    }
}
