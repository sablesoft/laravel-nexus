<?php

namespace App\Livewire\Workshop\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\CursorPaginator;
use Livewire\WithPagination;
use App\Models\Interfaces\HasOwnerInterface;

trait HandlePaginate
{
    use WithPagination;

    protected ?CursorPaginator $models = null;

    public string $search = '';

    public int $perPage = 10;
    public string $orderBy = 'id';
    public string $orderDirection = 'desc';

    public int $totalRecords = 0;

    public function apply(): void
    {
        $this->resetCursor();
    }

    /**
     * @return void
     */
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
     * @return CursorPaginator
     */
    protected function loadModels(): CursorPaginator
    {
        $query = $this->initQuery();
        if ($this->search) {
            $query->where($this->orderBy, 'ilike', "%$this->search%");
        }

        $this->totalRecords = $query->count();

        $this->models = $this->modifyQuery($query)
            ->orderBy($this->orderBy, $this->orderDirection)->cursorPaginate($this->perPage);

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
