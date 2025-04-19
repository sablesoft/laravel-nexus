<?php
namespace App\Livewire\Workshop\Screen;

use App\Crud\Traits\HandlePaginate;
use App\Livewire\Workshop\HasCodeMirror;
use App\Logic\Rules\DslRule;
use App\Logic\Validators\EffectsValidator;
use App\Logic\Validators\QueryExpressionValidator;
use App\Models\Control;
use App\Models\Screen;
use App\Models\Services\StoreService;
use App\Models\Transfer;
use Arr;
use Flux\Flux;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Throwable;

class Transfers extends Component
{
    use HandlePaginate, HasCodeMirror;

    #[Locked]
    public int $screenId;
    #[Locked]
    public int $applicationId;
    #[Locked]
    public ?int $transferId = null;
    public array $transfers = [];
    public array $state = [];

    public function mount(int $screenId): void
    {
        $this->screenId = $screenId;
        $this->applicationId = Screen::findOrFail($screenId)->application_id;
        /** @var Collection<int, Transfer> $transfers */
        $transfers = Transfer::where('screen_from_id', $screenId)->with('screenTo')->get();
        foreach ($transfers as $transfer) {
            $this->transfers[$transfer->id] = $this->prepareTransfer($transfer);
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

    public function model(int $id): Transfer
    {
        return Transfer::findOrFail($id);
    }

    protected function codeMirrorFields(): array
    {
        return ['beforeString'];
    }

    public function orderByFields(): array
    {
        return [
            'id' => 'ID',
//            'title' => __('Title') TODO
        ];
    }

    public function selectScreen(int $id): void
    {
        $screen = Screen::with('image')->findOrFail($id);
        $this->state = [
            'screen_to_id' => $id,
            'title' => $screen->title,
            'tooltip' => null,
            'description' => null,
            'beforeString' => null,
            'screenTitle' => $screen->title,
            'imageUrlSm' => $screen->imageUrlSm,
        ];
        Flux::modal('form-transfer')->show();
    }

    public function edit(int $id): void
    {
        $this->transferId = $id;
        $transfer = $this->transfers[$id];
        foreach (array_keys($this->rules()) as $field) {
            $this->state[$field] = $transfer[$field];
        }
        foreach (['screenTitle', 'imageUrlSm'] as $field) {
            $this->state[$field] = $transfer[$field];
        }
        $this->dispatchCodeMirror();
        Flux::modal('form-transfer')->show();
    }

    /**
     * @throws Throwable
     */
    public function submit(): void
    {
        $data = $this->validate(Arr::prependKeysWith($this->rules(), 'state.'));
        $transfer = $this->getModel();
        /** @var Transfer $transfer */
        $transfer = StoreService::handle($data['state'], $transfer);
        $this->transfers[$transfer->id] = $this->prepareTransfer($transfer);
        Flux::modal('form-transfer')->close();
        $this->dispatch('flash', message: 'Transfer' . ($this->transferId ? ' updated' : ' created'));
        $this->resetForm();
    }

    public function delete(int $id): void
    {
        $this->transferId = $id;
        $transfer = $this->getModel();
        $transfer->delete();
        unset($this->transfers[$id]);
        $this->dispatch('flash', message: 'Transfer deleted');
        $this->resetForm();
    }

    public function resetForm(): void
    {
        $this->transferId = null;
        foreach (array_keys($this->rules()) as $field) {
            $this->state[$field] = null;
        }
        $this->dispatchCodeMirror();
    }

    protected function prepareTransfer(Transfer $transfer): array
    {
        return [
            'screen_from_id' => $this->screenId,
            'screen_to_id' => $transfer->screen_to_id,
            'title' => $transfer->title,
            'tooltip' => $transfer->tooltip,
            'description' => $transfer->description,
            'beforeString' => $transfer->beforeString,
            'enabled_condition' => $transfer->enabled_condition,
            'visible_condition' => $transfer->visible_condition,
            'screenTitle' => $transfer->screenTo->title,
            'imageUrlSm' => $transfer->screenTo->imageUrlSm,
        ];
    }

    protected function getModel(): Transfer
    {
        return $this->transferId ?
            Transfer::with('screenTo')->findOrFail($this->transferId) :
            new Transfer(['screen_from_id' => $this->screenId]);
    }

    protected function modifyQuery(Builder $query): Builder
    {
        $query->where('application_id', $this->applicationId);
        $excludeIds = array_merge([$this->screenId], collect($this->transfers)->pluck('screen_to_id')->toArray());
        $query->whereNotIn('id', $excludeIds);

        return $query;
    }

    protected function rules(): array
    {
        $dslEditor = config('dsl.editor');
        return [
            'screen_to_id'      => ['required', 'int'],
            'title'             => ['string', 'required'],
            'tooltip'           => ['nullable', 'string'],
            'description'       => ['nullable', 'string'],
            'beforeString'      => ['nullable', $dslEditor, new DslRule(EffectsValidator::class, $dslEditor)],
            'enabled_condition' => ['nullable', 'string', new DslRule(QueryExpressionValidator::class, 'raw')],
            'visible_condition' => ['nullable', 'string', new DslRule(QueryExpressionValidator::class, 'raw')],
        ];
    }
}
