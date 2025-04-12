<?php
namespace App\Livewire;

use App\Crud\Traits\HandlePaginate;
use App\Models\Chat;
use App\Models\Mask;
use Flux\Flux;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

class MaskSelector extends Component
{
    use HandlePaginate;

    public $owner = 'all';
    public $hasImage = 'yes';
    #[Locked]
    public array $excludedIds;
    #[Locked]
    public bool $isOwner;

    public function mount(array $maskIds, bool $isOwner = false): void
    {
        $this->excludedIds = $maskIds;
        $this->isOwner = $isOwner;
        $this->orderBy = 'id';
    }

    public function render(): mixed
    {
        return view('livewire.mask-selector', [
            'models' => $this->paginator()
        ]);
    }

    public function className(): string
    {
        return Mask::class;
    }

    public function orderByFields(): array
    {
        return [
            'id' => 'ID',
            'is_public' => 'Is Public',
        ];
    }

    protected function modifyQuery(Builder $query): Builder
    {
        $query->whereNotIn('id', $this->excludedIds);
        if ($this->isOwner) {
            if ($this->owner === 'all') {
                $query->where(function($q) {
                    $q->where('is_public', true)
                        ->orWhere('user_id', auth()->id());
                });
            } elseif ($this->owner === 'you') {
                $query->where('user_id', auth()->id());
            } else {
                $query->whereNot('user_id', auth()->id())
                    ->where('is_public', true);
            }
        } else {
            $query->where('is_public', true);
        }
        if ($this->hasImage === 'yes') {
            $query->whereNotNull('image_id');
        } elseif($this->hasImage === 'no') {
            $query->whereNull('image_id');
        }
        if ($this->search) {
            $query->where('name', 'ilike', '%'.$this->search.'%');
        }

        return $query;
    }

    public function resetFilters(): void
    {
        $this->owner = 'all';
        $this->search = '';
        $this->perPage = 10;
        $this->orderBy = 'id';
        $this->orderDirection = 'desc';
    }

    #[On('maskSelector')]
    public function openModal(): void
    {
        Flux::modal('select-mask')->show();
    }

    public function selectMask(int $maskId): void
    {
        $this->excludedIds[] = $maskId;
        Flux::modal('select-mask')->close();
        $this->dispatch('maskSelected', maskId: $maskId);
    }

    #[On('maskRemoved')]
    public function includeMask(int $maskId): void
    {
        $this->excludedIds = array_diff($this->excludedIds, [$maskId]);
    }
}
