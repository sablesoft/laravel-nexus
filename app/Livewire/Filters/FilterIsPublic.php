<?php

namespace App\Livewire\Filters;

use Illuminate\Database\Eloquent\Builder;

trait FilterIsPublic
{
    public string $filterIsPublic = 'all';

    protected function applyFilterIsPublic(Builder $query): Builder
    {
        if ($this->filterIsPublic !== 'all') {
            $query->where('is_public', $this->filterIsPublic === 'yes');
        }

        return $query;
    }

    public function filterIsPublicTemplates(): array
    {
        return ['crud.filter-is-public'];
    }

    protected function filterIsPublicProperties(): array
    {
        return ['filterIsPublic'];
    }
}
