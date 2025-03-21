<?php

namespace App\Livewire\Filters;

use App\Models\Application;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Livewire\Attributes\Locked;

trait FilterApplication
{
    public int $filterApplicationId = 0;
    #[Locked]
    public Collection $applications;

    public function mountFilterApplication(): void
    {
        $this->applications = Application::where('user_id', $this->userId)->get(['id', 'title']);
    }

    protected function applyFilterApplication(Builder $query): Builder
    {
        if ($this->filterApplicationId !== 0) {
            $query->where('application_id', $this->filterApplicationId);
        }

        return $query;
    }

    public function filterApplicationTemplates(): array
    {
        return ['filter.application'];
    }

    protected function filterApplicationProperties(): array
    {
        return ['filterApplicationId'];
    }
}
