<?php
namespace App\Livewire;

use App\Crud\Traits\HandlePaginate;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use App\Models\Image;

class ImageSelector extends Component
{
    use HandlePaginate;

    public $aspectRatio = 'all';
    public $isPublic = 'all';
    public $hasArtifacts = 'all';

    public function render(): mixed
    {
        return view('livewire.image-selector', [
            'models' => $this->paginator()
        ]);
    }

    public function className(): string
    {
        return Image::class;
    }

    public function orderByFields(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'aspect' => 'Ratio',
            'has_glitches' => 'Glitches'
        ];
    }

    protected function modifyQuery(Builder $query): Builder
    {
        if ($this->aspectRatio !== 'all') {
            $query->where('aspect', $this->aspectRatio);
        }
        if ($this->isPublic !== 'all') {
            $query->where('is_public', (bool) $this->isPublic);
        }
        if ($this->hasArtifacts !== 'all') {
            $query->where('has_glitches', (bool) $this->hasArtifacts);
        }
        if ($this->search) {
            $query->where('title', 'ilike', '%'.$this->search.'%');
        }

        return $query;
    }

    public function resetFilters(): void
    {
        $this->aspectRatio = 'all';
        $this->isPublic = 'all';
        $this->hasArtifacts = 'all';
        $this->search = '';
        $this->perPage = 10;
        $this->orderBy = 'id';
        $this->orderDirection = 'desc';
    }

    public function selectImage(int $id): void
    {
        $this->dispatch('imageSelected', imageId: $id);
    }
}
