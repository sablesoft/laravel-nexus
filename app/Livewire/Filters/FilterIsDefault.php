<?php

namespace App\Livewire\Filters;

use Illuminate\Database\Eloquent\Builder;

trait FilterIsDefault
{
    public string $filterIsDefault = 'all';

    protected function applyFilterIsDefault(Builder $query): Builder
    {
        if ($this->filterIsDefault !== 'all') {
            $query->where('is_default', $this->filterIsDefault === 'yes');
        }

        return $query;
    }

    public function filterIsDefaultTemplates(): array
    {
        return ['filter.is-default'];
    }

    protected function filterIsDefaultProperties(): array
    {
        return ['filterIsDefault'];
    }
}
