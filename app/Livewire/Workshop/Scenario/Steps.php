<?php
namespace App\Livewire\Workshop\Scenario;

use App\Livewire\Workshop\HasCodeMirror;
use App\Logic\Rules\DslRule;
use App\Logic\Validators\EffectsValidator;
use App\Models\Control;
use App\Models\Scenario;
use App\Models\Services\StoreService;
use App\Models\Step;
use Flux\Flux;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Steps extends Component
{
    use HasCodeMirror;

    #[Locked]
    public int $scenarioId;
    #[Locked]
    public array $scenarios;
    #[Locked]
    public array $steps = [];
    #[Locked]
    public string $action;
    #[Locked]
    public ?int $stepId = null;
    public array $state;
    public bool $addLogic = false;

    public function mount(int $scenarioId): void
    {
        $this->scenarioId = $scenarioId;
        $this->scenarios = Scenario::where('user_id', auth()->id())
            ->select(['id', 'title as name'])->get()->toArray();
        /** @var Collection<int, Control> $steps */
        $steps = Step::where('parent_id', $scenarioId)->orderBy('number')->with('scenario')->get();
        foreach ($steps as $step) {
            $this->steps[$step->id] = $this->prepareStep($step);
        }
        $this->resetForm();
    }

    public function render(): mixed
    {
        return view('livewire.workshop.scenario.steps');
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

    public function resetForm(): void
    {
        $this->action = 'create';
        $this->stepId = null;
        foreach (array_keys($this->rules()) as $field) {
            $this->state[$field] = null;
        }
        $this->addLogic = false;
        $this->dispatchCodeMirror();
    }

    public function edit(int $id): void
    {
        $this->stepId = $id;
        $this->action = 'edit';
        $step = $this->steps[$id];
        foreach (array_keys($this->rules()) as $field) {
            $this->state[$field] = $step[$field];
        }
        $this->addLogic = !empty($step['scenario_id']);
        $this->dispatchCodeMirror();
        Flux::modal('form-step')->show();
    }

    public function submit(): void
    {
        if (!$this->stepId) {
            $this->state['number'] = $this->getNextNumber();
        }
        $data = $this->validate(\Arr::prependKeysWith($this->rules(), 'state.'));
        $step = $this->getModel();
        /** @var Step $step */
        $step = StoreService::handle($data['state'], $step);
        $this->steps[$step->id] = $this->prepareStep($step);
        $this->resetForm();
        Flux::modal('form-step')->close();
        $this->dispatch('flash', message: 'Step' . ($this->stepId ? ' updated' : ' created'));
    }

    public function delete(int $id): void
    {
        $this->stepId = $id;
        $step = $this->getModel();
        $step->delete();
        unset($this->steps[$id]);
        $this->renumber();
        $this->dispatch('flash', message: __('Step deleted'));
        $this->resetForm();
    }

    public function moveUp(int $id): void
    {
        $step = Step::findOrFail($id);
        $prev = Step::where('parent_id', $this->scenarioId)
            ->where('number', '<', $step->number)
            ->orderByDesc('number')
            ->first();

        if ($prev) {
            $this->swapStepNumbers($step, $prev);
        }
    }

    public function moveDown(int $id): void
    {
        $step = Step::findOrFail($id);
        $next = Step::where('parent_id', $this->scenarioId)
            ->where('number', '>', $step->number)
            ->orderBy('number')
            ->first();

        if ($next) {
            $this->swapStepNumbers($step, $next);
        }
    }

    protected function swapStepNumbers(Step $a, Step $b): void
    {
        $tempA = $a->number;
        $tempB = $b->number;
        $a->number = 0;
        $a->save();
        $b->number = $tempA;
        $b->save();
        $a->number = $tempB;
        $a->save();

        $this->steps[$a->id] = $this->prepareStep($a);
        $this->steps[$b->id] = $this->prepareStep($b);
        $this->sortSteps();
    }

    protected function getModel(): Step
    {
        return $this->stepId ?
            Step::findOrFail($this->stepId) :
            new Step(['parent_id' => $this->scenarioId]);
    }

    protected function prepareStep(Step $step): array
    {
        return [
            'id' => $step->number,
            'number' => $step->number,
            'scenario_id' => $step->scenario_id,
            'scenarioTitle' => $step->scenario?->title,
            'description' => $step->description ?: $step->scenario?->description,
            'beforeString' => $step->beforeString,
            'afterString' => $step->afterString,
        ];
    }

    protected function getNextNumber(): int
    {
        return Step::where('parent_id', $this->scenarioId)->max('number') + 1;
    }

    protected function renumber(): void
    {
        $steps = Step::where('parent_id', $this->scenarioId)
            ->orderBy('number')
            ->get();

        foreach ($steps as $index => $step) {
            $newNumber = $index + 1;
            if ($step->number !== $newNumber) {
                $step->number = $newNumber;
                $step->save();
            }
            $this->steps[$step->id] = $this->prepareStep($step);
        }

        $this->sortSteps();
    }

    protected function sortSteps(): void
    {
        $this->steps = collect($this->steps)
            ->sortBy('number')
            ->toArray();
    }

    protected function rules(): array
    {
        $dslEditor = config('dsl.editor');
        return [
            'number'        => ['required', 'integer'],
            'description'   => ['nullable', 'string'],
            'beforeString'  => ['nullable', $dslEditor, new DslRule(EffectsValidator::class, $dslEditor)],
            'afterString'   => ['nullable', $dslEditor, new DslRule(EffectsValidator::class, $dslEditor)],
            'scenario_id'   => [ $this->addLogic ? 'required' : 'nullable', 'int'],
        ];
    }
}
