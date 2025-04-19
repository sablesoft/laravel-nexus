<?php
namespace App\Livewire\Workshop\Screen;

use App\Livewire\Workshop\HasCodeMirror;
use App\Logic\Rules\DslRule;
use App\Logic\Validators\EffectsValidator;
use App\Logic\Validators\QueryExpressionValidator;
use App\Models\Control;
use App\Models\Enums\ControlType;
use App\Models\Scenario;
use App\Models\Services\StoreService;
use Flux\Flux;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Controls extends Component
{
    use HasCodeMirror;

    #[Locked]
    public int $screenId;
    #[Locked]
    public array $scenarios;
    #[Locked]
    public array $controls = [];
    #[Locked]
    public string $action;
    #[Locked]
    public ?int $controlId = null;
    public array $state;
    public bool $addLogic = false;

    public function mount(int $screenId): void
    {
        $this->screenId = $screenId;
        $this->scenarios = Scenario::where('user_id', auth()->id())->get()
            ->map(fn(Scenario $scenario) => [
                'id' => $scenario->getKey(),
                'name' => $scenario->title
             ])->toArray();
        /** @var Collection<int, Control> $controls */
        $controls = Control::where('screen_id', $screenId)->with('scenario')->get();
        foreach ($controls as $control) {
            $this->controls[$control->id] = $this->prepareControl($control);
        }
        $this->resetForm();
    }

    public function render(): mixed
    {
        return view('livewire.workshop.screen.controls');
    }

    public function updatedAddLogic(): void
    {
        if (!$this->addLogic) {
            $this->state['scenario_id'] = null;
            $this->state['afterString'] = null;
        }
    }

    protected function codeMirrorFields(): array
    {
        return ['beforeString', 'afterString'];
    }

    public function model(int $id): Control
    {
        return Control::findOrFail($id);
    }

    public function resetForm(): void
    {
        $this->action = 'create';
        $this->controlId = null;
        foreach (array_keys($this->rules()) as $field) {
            $this->state[$field] = null;
        }
        $this->addLogic = false;
        $this->dispatchCodeMirror();
    }

    public function edit(int $id): void
    {
        $this->controlId = $id;
        $this->action = 'edit';
        $control = $this->controls[$id];
        foreach (array_keys($this->rules()) as $field) {
            $this->state[$field] = $control[$field];
        }
        $this->addLogic = !empty($control['scenario_id']);
        $this->dispatchCodeMirror();
        Flux::modal('form-control')->show();
    }

    public function submit(): void
    {
        $data = $this->validate(\Arr::prependKeysWith($this->rules(), 'state.'));
        $control = $this->getModel();
        /** @var Control $control */
        $control = StoreService::handle($data['state'], $control);
        $this->controls[$control->id] = $this->prepareControl($control);
        $this->resetForm();
        Flux::modal('form-control')->close();
        $this->dispatch('flash', message: 'Control' . ($this->controlId ? ' updated' : ' created'));
    }

    public function delete(int $id): void
    {
        $this->controlId = $id;
        $control = $this->getModel();
        $control->delete();
        unset($this->controls[$id]);
        $this->dispatch('flash', message: __('Control deleted'));
        $this->resetForm();
    }

    protected function getModel(): Control
    {
        return $this->controlId ?
            Control::findOrFail($this->controlId) :
            new Control(['screen_id' => $this->screenId]);
    }

    protected function prepareControl(Control $control): array
    {
        return [
            'scenario_id' => $control->scenario_id,
            'scenarioTitle' => $control->scenario?->title,
            'type' => $control->type->value,
            'title' => $control->title,
            'tooltip' => $control->tooltip,
            'description' => !empty($control->description) ?
                $control->description :
                $control->scenario?->description,
            'beforeString' => $control->beforeString,
            'afterString' => $control->afterString,
            'enabled_condition' => $control->enabled_condition,
            'visible_condition' => $control->visible_condition,
        ];
    }

    protected function rules(): array
    {
        $dslEditor = config('dsl.editor');
        return [
            'type'          => ['required', 'string', Rule::enum(ControlType::class)],
            'title'         => ['string', 'required'],
            'tooltip'       => ['nullable', 'string'],
            'description'   => ['nullable', 'string'],
            'enabled_condition' => ['nullable', 'string', new DslRule(QueryExpressionValidator::class, 'raw')],
            'visible_condition' => ['nullable', 'string', new DslRule(QueryExpressionValidator::class, 'raw')],
            'beforeString'  => ['nullable', $dslEditor, new DslRule(EffectsValidator::class, $dslEditor)],
            'afterString'   => ['nullable', $dslEditor, new DslRule(EffectsValidator::class, $dslEditor)],
            'scenario_id'   => [ $this->addLogic ? 'required' : 'nullable', 'int'],
        ];
    }
}
