<?php
namespace App\Livewire\Workshop\Application;

use App\Models\Control;
use App\Models\Group;
use App\Models\GroupRole;
use App\Models\Role;
use App\Models\Services\StoreService;
use Flux\Flux;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

class Groups extends Component
{
    #[Locked]
    public int $applicationId;
    #[Locked]
    public array $groups = [];
    #[Locked]
    public array $roles;
    #[Locked]
    public string $action;
    #[Locked]
    public ?int $groupId = null;
    public array $state;

    public function mount(int $applicationId): void
    {
        $this->applicationId = $applicationId;
        /** @var Collection<int, Control> $groups */
        $groups = Group::where('application_id', $applicationId)->orderBy('number')->with('groupRoles')->get();
        foreach ($groups as $group) {
            $this->groups[$group->id] = $this->prepareGroup($group);
        }
        $this->refreshRoles();
        $this->resetForm();
    }

    #[On('refresh-roles')]
    public function refreshRoles(): void
    {
        $this->roles = Role::where('user_id', auth()->id())
            ->whereNotIn('id', GroupRole::where('application_id', $this->applicationId)->pluck('role_id'))
            ->select(['id', 'name'])->get()->toArray();
        $this->dispatch('roles-updated', roles: $this->roles);
    }

    public function render(): mixed
    {
        return view('livewire.workshop.application.groups');
    }

    protected function codeMirrorFields(): array
    {
        return ['beforeString', 'afterString'];
    }

    public function resetForm(): void
    {
        $this->action = 'create';
        $this->groupId = null;
        foreach (array_keys($this->rules()) as $field) {
            $this->state[$field] = null;
        }
    }

    public function edit(int $id): void
    {
        $this->groupId = $id;
        $this->action = 'edit';
        $group = $this->groups[$id];
        foreach (array_keys($this->rules()) as $field) {
            $this->state[$field] = $group[$field];
        }
        Flux::modal('form-group')->show();
    }

    public function submit(): void
    {
        if (!$this->groupId) {
            $this->state['number'] = $this->getNextNumber();
        }
        $data = $this->validate(\Arr::prependKeysWith($this->rules(), 'state.'));
        $group = $this->getModel();
        /** @var Group $group */
        $group = StoreService::handle($data['state'], $group);
        $this->groups[$group->id] = $this->prepareGroup($group);
        $this->resetForm();
        Flux::modal('form-group')->close();
        $this->dispatch('flash', message: 'Group' . ($this->groupId ? ' updated' : ' created'));
    }

    public function delete(int $id): void
    {
        $this->groupId = $id;
        $group = $this->getModel();
        $group->delete();
        unset($this->groups[$id]);
        $this->renumber();
        $this->dispatch('flash', message: 'Group deleted');
        $this->resetForm();
    }

    public function moveUp(int $id): void
    {
        $group = Group::findOrFail($id);
        $prev = Group::where('application_id', $this->applicationId)
            ->where('number', '<', $group->number)
            ->orderByDesc('number')
            ->first();

        if ($prev) {
            $this->swapGroupNumbers($group, $prev);
        }
    }

    public function moveDown(int $id): void
    {
        $group = Group::findOrFail($id);
        $next = Group::where('application_id', $this->applicationId)
            ->where('number', '>', $group->number)
            ->orderBy('number')
            ->first();

        if ($next) {
            $this->swapGroupNumbers($group, $next);
        }
    }

    protected function swapGroupNumbers(Group $a, Group $b): void
    {
        $tempA = $a->number;
        $tempB = $b->number;
        $a->number = 0;
        $a->save();
        $b->number = $tempA;
        $b->save();
        $a->number = $tempB;
        $a->save();

        $this->groups[$a->id] = $this->prepareGroup($a);
        $this->groups[$b->id] = $this->prepareGroup($b);
        $this->sortGroups();
    }

    protected function getModel(): Group
    {
        return $this->groupId ?
            Group::findOrFail($this->groupId) :
            new Group(['application_id' => $this->applicationId]);
    }

    protected function prepareGroup(Group $group): array
    {
        return [
            'id' => $group->id, // ??
            'number' => $group->number,
            'application_id' => $group->scenario_id,
            'name' => $group->name,
            'description' => $group->description,
            'is_required' => $group->is_required,
            'roles_per_member' => $group->roles_per_member,
        ];
    }

    protected function getNextNumber(): int
    {
        return Group::where('application_id', $this->applicationId)->max('number') + 1;
    }

    protected function renumber(): void
    {
        $groups = Group::where('application_id', $this->applicationId)
            ->orderBy('number')
            ->get();

        foreach ($groups as $index => $group) {
            $newNumber = $index + 1;
            if ($group->number !== $newNumber) {
                $group->number = $newNumber;
                $group->save();
            }
            $this->groups[$group->id] = $this->prepareGroup($group);
        }

        $this->sortGroups();
    }

    protected function sortGroups(): void
    {
        $this->groups = collect($this->groups)
            ->sortBy('number')
            ->toArray();
    }

    protected function rules(): array
    {
        return [
            'number'        => ['required', 'integer'],
            'name'          => ['required', 'string'],
            'description'   => ['nullable', 'string'],
            'is_required'   => ['nullable', 'bool'],
            'roles_per_member'   => ['nullable', 'int'],
        ];
    }
}
