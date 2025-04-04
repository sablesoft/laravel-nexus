<?php

namespace App\Livewire\Filters;

use Illuminate\Database\Eloquent\Builder;

trait FilterIsFlag
{
    public string $filterIsFlag = 'all';

    public function filterIsFlagLabel(): string
    {
        return 'Is Flag';
    }

    protected function applyFilterIsFlag(Builder $query, string $field): Builder
    {
        if ($this->filterIsFlag !== 'all') {
            $query->where($field, $this->filterIsFlag === 'yes');
        }

        return $query;
    }

    public function filterIsFlagTemplates(): array
    {
        return ['filter.is-flag'];
    }

    protected function filterIsFlagProperties(): array
    {
        return ['filterIsFlag'];
    }
}
