<?php

namespace App\Crud\Traits;

use App\Models\Interfaces\HasOwnerInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
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

    public int $totalRecords = 0;

    #[On('updated:orderBy', 'updated:orderDirection', 'updated:perPage', 'updated:search')]
    protected function resetCursor(): void
    {
        $this->paginators['cursor'] = '';
    }

    /**
     * @return array
     */
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

    /**
     * @return LengthAwarePaginator
     */
    protected function loadModels(): LengthAwarePaginator
    {
        $query = $this->initQuery();
        if ($this->search) {
            $query->where($this->orderBy, 'ilike', "%$this->search%");
        }

        $this->totalRecords = $query->count();

        $this->models = $this->modifyQuery($query)
            ->orderBy($this->orderBy, $this->orderDirection)->paginate($this->perPage);

        return $this->models;
    }

    /**
     * @param string $className
     * @return Builder
     * @noinspection PhpUndefinedMethodInspection
     */
    protected function filteredQuery(string $className): Builder
    {
        $query = $className::query();
        if (in_array(HasOwnerInterface::class, class_implements($className))) {
            $query = $query->where('user_id', auth()->id());
        }

        return $query;
    }

    /**
     * @return Builder
     */
    protected function initQuery(): Builder
    {
        /** @var Model $className */
        $className = $this->className();
//        if (auth()->user()->isAdmin()) {
//            return $className::query();
//        }

        return $this->filteredQuery($className);
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
