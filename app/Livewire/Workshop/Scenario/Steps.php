<?php
namespace App\Livewire\Workshop\Scenario;

use App\Models\Control;
use App\Models\Enums\Command;
use App\Models\Scenario;
use App\Models\Services\StoreService;
use App\Models\Step;
use Flux\Flux;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Steps extends Component
{
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
    public bool $switcher = false;

    public function mount(int $scenarioId): void
    {
        $this->scenarioId = $scenarioId;
        $this->scenarios = Scenario::where('user_id', auth()->id())
            ->select(['id', 'title as name'])->get()->toArray();
        /** @var Collection<int, Control> $steps */
        $steps = Step::where('scenario_id', $scenarioId)->orderBy('number')->with('nestedScenario')->get();
        foreach ($steps as $step) {
            $this->steps[$step->id] = $this->prepareStep($step);
        }
        $this->resetForm();
    }

    public function render(): mixed
    {
        return view('livewire.workshop.scenario.steps');
    }

    public function updatedSwitcher(): void
    {
        if ($this->switcher) {
            $this->state['command'] = null;
        } else {
            $this->state['nested_id'] = null;
        }
    }

    public function resetForm(): void
    {
        $this->action = 'create';
        $this->stepId = null;
        foreach (array_keys($this->rules()) as $field) {
            $this->state[$field] = null;
        }
    }

    public function edit(int $id): void
    {
        $this->stepId = $id;
        $this->action = 'edit';
        $step = $this->steps[$id];
        foreach (array_keys($this->rules()) as $field) {
            $this->state[$field] = $step[$field];
        }
        $this->switcher = !empty($step['nested_id']);
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
        $this->dispatch('flash', message: 'Step deleted');
        $this->resetForm();
    }

    public function moveUp(int $id): void
    {
        $step = Step::findOrFail($id);
        $prev = Step::where('scenario_id', $this->scenarioId)
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
        $next = Step::where('scenario_id', $this->scenarioId)
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
            new Step(['scenario_id' => $this->scenarioId]);
    }

    protected function prepareStep(Step $step): array
    {
        return [
            'id' => $step->number,
            'number' => $step->number,
            'nested_id' => $step->nested_id,
            'nestedTitle' => $step->nestedScenario?->title,
            'command' => $step->command?->value,
            'commandTitle' => $step->command ? ucfirst($step->command->value) : null,
            'active' => $step->active,
            'setup' => $step->setup,
        ];
    }

    protected function getNextNumber(): int
    {
        return Step::where('scenario_id', $this->scenarioId)->max('number') + 1;
    }

    protected function renumber(): void
    {
        $steps = Step::where('scenario_id', $this->scenarioId)
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
        $rules = [
            'active'        => ['nullable', 'json'],
            'setup'     => ['nullable', 'json'],
            'number' => [
                'required',
                'integer',
            ],
        ];

        return array_merge($rules, $this->switcher ? [
            'nested_id'   => ['required', 'int'],
            'command' => ['nullable', 'string']
        ] : [
            'command'       => ['required', 'string', Rule::enum(Command::class)],
            'nested_id' => ['nullable', 'int']
        ]);
    }
}
