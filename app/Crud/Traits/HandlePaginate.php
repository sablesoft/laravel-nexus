<?php

namespace App\Crud\Traits;

use App\Models\Interfaces\HasOwnerInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;
use Livewire\WithPagination;

trait HandlePaginate
{
    use WithPagination;

    protected ?LengthAwarePaginator $models = null;

    public string $search = '';
    public int $perPage = 10;
    public string $orderBy = 'id';
    public string $orderDirection = 'desc';

    #[On('updated:orderBy', 'updated:orderDirection', 'updated:perPage', 'updated:search')]
    protected function resetCursor(): void
    {
        $this->paginators['cursor'] = '';
    }

    public function orderByFields(): array
    {
        return [];
    }

    /**
     * @return int[]
     */
    public function perPageCounts(): array
    {
        return [5, 10, 25, 50, 100];
    }

    protected function builder(bool $filterByOwner = true): Builder
    {
        $query = $this->getQuery();
        if ($filterByOwner) {
            $query = $this->filterByOwner($query);
        }
        $query = $this->modifyQuery($query);
        if ($this->search) {
            $query->where($this->orderBy, 'ilike', "%$this->search%");
        }

        return $query->orderBy($this->orderBy, $this->orderDirection);
    }

    protected function paginator(): LengthAwarePaginator
    {
        return $this->models = $this->builder()->paginate($this->perPage);
    }

    protected function getQuery(?string $className = null): Builder
    {
        $className = $className ?: $this->className();
        /** @var Builder $query */
        $query = $className::query();

        return $query;
    }

    protected function filterByOwner(Builder $query): Builder
    {
        if (in_array(HasOwnerInterface::class, class_implements($query->getModel()))) {
            $query = $query->where('user_id', auth()->id());
        }

        return $query;
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    protected function modifyQuery(Builder $query): Builder
    {
        return $query;
    }
}
