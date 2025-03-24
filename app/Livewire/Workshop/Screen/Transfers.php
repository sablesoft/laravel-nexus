<?php
namespace App\Livewire\Workshop\Screen;

use App\Crud\Traits\HandlePaginate;
use App\Models\Screen;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Transfers extends Component
{
    use HandlePaginate;

    #[Locked]
    public int $screenId;
    #[Locked]
    public int $applicationId;
    public array $transfers = [];

    public function mount(int $screenId): void
    {
        $this->screenId = $screenId;
        $this->applicationId = Screen::findOrFail($screenId)->application_id;
        /** @var Collection<int, \App\Models\Transfer> $transfers */
        $transfers = \App\Models\Transfer::where('screen_from_id', $screenId)->with('screenTo')->get();
        foreach ($transfers as $transfer) {
            $this->transfers[$transfer->screen_to_id] = [
                'screen_from_id' => $this->screenId,
                'screen_to_id' => $transfer->screen_to_id,
                'code' => $transfer->code,
                'title' => $transfer->title,
                'tooltip' => $transfer->tooltip,
                'active' => $transfer->active ?
                    json_encode($transfer->active, JSON_PRETTY_PRINT) :
                    null,
                'screenTitle' => $transfer->screenTo->title,
                'imageUrlSm' => $transfer->screenTo->imageUrlSm,
            ];
        }
    }

    public function render(): mixed
    {
        return view('livewire.workshop.screen.transfers', [
            'models' => $this->paginator()
        ]);
    }

    public function className(): string
    {
        return Screen::class;
    }

    public function orderByFields(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Title'
        ];
    }

    protected function modifyQuery(Builder $query): Builder
    {
        $query->where('application_id', $this->applicationId);
        $excludeIds = array_merge([$this->screenId], array_keys($this->transfers));
        $query->whereNotIn('id', $excludeIds);

        return $query;
    }

    public function selectScreen(int $id): void
    {
        $screen = Screen::with('image')->findOrFail($id);
        $this->transfers[$id] = [
            'screen_from_id' => $this->screenId,
            'screen_to_id' => $id,
            'code' => $this->screenId . '|' . $id,
            'title' => $screen->title, // by default
            'tooltip' => null,
            'active' => null,
            'screenTitle' => $screen->title,
            'imageUrlSm' => $screen->imageUrlSm,
        ];
        $this->dispatch('transferAdded', transfer: $this->transfers[$id]);
    }

    public function removeScreen(int $id): void
    {
        $this->dispatch('transferRemoved', screenToId: $id);
        unset($this->transfers[$id]);
    }

    public function updated(string $property): void
    {
        if (in_array($property, ['orderBy', 'orderDirection', 'perPage', 'search'] )) {
            $this->resetCursor();
        }
        $property = explode('.', $property);
        if (reset($property) === 'transfers') {
            $this->dispatch('transferUpdated', transfer: $this->transfers[$property[1]]);
        }
    }
}
