<?php

namespace App\Livewire\Filters;

use Illuminate\Database\Eloquent\Builder;

trait FilterImage
{
    public string $filterAspect = 'all';
    public string $filterHasGlitches = 'all';
    public string $filterStyle = 'all';
    public string $filterQuality = 'all';

    protected function applyFilterImage(Builder $query): Builder
    {
        if ($this->filterHasGlitches !== 'all') {
            $query->where('has_glitches', $this->filterHasGlitches === 'yes');
        }
        if ($this->filterAspect !== 'all') {
            $query->where('aspect', $this->filterAspect);
        }
        if ($this->filterStyle !== 'all') {
            $query->where('style', $this->filterStyle);
        }
        if ($this->filterQuality !== 'all') {
            $query->where('quality', $this->filterQuality);
        }

        return $query;
    }

    public function filterImageTemplates(): array
    {
        return ['filter.image'];
    }

    protected function filterImageProperties(): array
    {
        return ['filterAspect', 'filterHasGlitches', 'filterStyle', 'filterQuality'];
    }
}
