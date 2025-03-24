<?php
namespace App\Livewire;

use App\Crud\Traits\HandlePaginate;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Locked;
use Livewire\Component;
use App\Models\Image;

class ImageSelector extends Component
{
    use HandlePaginate;

    public $aspectRatio = 'all';
    public $isPublic = 'all';
    public $hasArtifacts = 'all';
    #[Locked]
    public string $field;
    #[Locked]
    public array $filter;
    #[Locked]
    public ?string $imagePath = null;

    public function mount(string $field, ?int $imageId = null, array $filter = []): void
    {
        $this->field = $field;
        $this->filter = $filter;
        if ($imageId) {
            $this->preparePath($imageId);
        }
    }

    public function render(): mixed
    {
        foreach (['aspectRatio', 'isPublic', 'hasArtifacts'] as $filter) {
            if (!empty($this->filter[$filter])) {
                $this->$filter = $this->filter[$filter];
            }
        }

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
        $this->preparePath($id);
        $this->dispatch('imageSelected', imageId: $id, field: $this->field);
    }

    protected function preparePath(int $id): void
    {
        /** @var Image $image */
        $image = Image::findOrFail($id);
        $this->imagePath = $image->path_md;
    }
}
