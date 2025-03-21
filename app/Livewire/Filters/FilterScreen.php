<?php

namespace App\Livewire\Filters;

use App\Models\Screen;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Livewire\Attributes\Locked;

trait FilterScreen
{
    public int $filterScreenId = 0;
    #[Locked]
    public Collection $screens;

    public function mountFilterScreen(): void
    {
        $this->screens = Screen::where('user_id', $this->userId)->get(['id', 'title']);
    }

    protected function applyFilterScreen(Builder $query): Builder
    {
        if ($this->filterScreenId !== 0) {
            $query->where('screen_id', $this->filterScreenId);
        }

        return $query;
    }

    public function filterScreenTemplates(): array
    {
        return ['filter.screen'];
    }

    protected function filterScreenProperties(): array
    {
        return ['filterScreenId'];
    }
}
