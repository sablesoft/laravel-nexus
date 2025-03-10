<?php

namespace App\Livewire;

use Flux\Flux;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use App\Models\Mask;
use App\Crud\Traits\HandlePaginate;

class Hero extends Component
{
    use HandlePaginate;

    public ?Mask $mask = null;

    public function render(): mixed
    {
        return view('livewire.hero', [
            'models' => $this->paginator()
        ]);
    }

    public function className(): string
    {
        return Mask::class;
    }

    public function show(int $id): void
    {
        $this->mask = Mask::findOrFail($id);
        Flux::modal('details')->show();
    }

    protected function filterByOwner(Builder $query): Builder
    {
        return $query;
    }

    protected function modifyQuery(Builder $query): Builder
    {
        return $query->where('is_public', true)
            ->with('image');
    }
}
