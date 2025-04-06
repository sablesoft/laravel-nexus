<?php
namespace App\Livewire\Workshop\Application;

use App\Livewire\Workshop\HasCodeMirror;
use App\Logic\Rules\DslRule;
use App\Logic\Validators\BehaviorsValidator;
use App\Logic\Validators\StatesValidator;
use App\Models\GroupRole;
use App\Models\Services\StoreService;
use Flux\Flux;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;
use Symfony\Component\Yaml\Yaml;

class GroupRoles extends Component
{
    use HasCodeMirror;

    #[Locked]
    public string $selectKey;
    #[Locked]
    public int $applicationId;
    #[Locked]
    public int $groupId;
    #[Locked]
    public array $roles = [];
    #[Locked]
    public array $groupRoles = [];
    #[Locked]
    public string $action;
    #[Locked]
    public ?int $groupRoleId = null;
    public array $state;

    public function mount(): void
    {
        $this->setSelectKey();
        /** @var Collection<int, GroupRole> $groupRoles */
        $groupRoles = GroupRole::where('group_id', $this->groupId)->with('role')->get();
        foreach ($groupRoles as $groupRole) {
            $this->groupRoles[$groupRole->id] = $this->prepareGroupRole($groupRole);
        }
        $this->resetForm();
    }

    public function render(): mixed
    {
        return view('livewire.workshop.application.group-roles', [
            'selectRoles' => collect($this->roles)->map(fn($item) => [
                'id' => $item['id'],
                'name' => $item['name']
            ])->values()->toArray()
        ]);
    }
    #[On('roles-updated')]
    public function updateRoles(array $roles): void
    {
        $this->roles = $roles;
        $this->setSelectKey();
    }

    public function updatedStateRoleId(?int $id): void
    {
        if ($id && $role = $this->roles[$id] ?? null) {
            $this->state['name'] = $role['name'];
            $this->state['description'] = $role['description'];
            $this->state['statesString'] = $role['states'] ? Yaml::dump( $role['states'], 10, 2) : null;
            $this->state['behaviorsString'] = $role['behaviors'] ? Yaml::dump( $role['behaviors'], 10, 2) : null;
        } else {
            $this->state['name'] = null;
            $this->state['description'] = null;
            $this->state['statesString'] = null;
            $this->state['behaviorsString'] = null;
        }
        $this->dispatchCodeMirror();
    }

    protected function codeMirrorFields(): array
    {
        return ['behaviorsString', 'statesString'];
    }

    public function resetForm(): void
    {
        $this->action = 'create';
        $this->groupRoleId = null;
        foreach (array_keys($this->rules()) as $field) {
            $this->state[$field] = null;
        }
        $this->state['limit'] = 0;
        $this->dispatchCodeMirror();
    }

    public function addRole(): void
    {
        $this->resetForm();
        Flux::modal('form-group-'.$this->groupId.'-role')->show();
    }

    public function edit(int $id): void
    {
        $this->groupRoleId = $id;
        $this->action = 'edit';
        $groupRole = $this->groupRoles[$id];
        foreach (array_keys($this->rules()) as $field) {
            $this->state[$field] = $groupRole[$field];
        }
        if ($groupRole['role_id']) {
            $this->setSelectKey();
            $this->roles[] = [
                'name' => $groupRole['roleName'],
                'id' => $groupRole['role_id']
            ];
        }
        $this->dispatchCodeMirror();
        Flux::modal('form-group-'.$this->groupId.'-role')->show();
    }

    public function submit(): void
    {
        $data = $this->validate(\Arr::prependKeysWith($this->rules(), 'state.'));
        $groupRole = $this->getModel();
        if ($this->submitRoleChanged($data['state'], $groupRole)) {
            $this->dispatch('refresh-roles');
        }
        /** @var GroupRole $groupRole */
        $groupRole = StoreService::handle($data['state'], $groupRole);
        $this->groupRoles[$groupRole->id] = $this->prepareGroupRole($groupRole);
        $this->resetForm();
        Flux::modal('form-group-'.$this->groupId.'-role')->close();
        $this->dispatch('flash', message: 'Group Role' . ($this->groupRoleId ? ' updated' : ' created'));
    }

    protected function submitRoleChanged(array $data, GroupRole $groupRole): bool
    {
        return ($this->action === 'create') || ($data['role_id'] !== $groupRole->role_id);
    }

    public function delete(int $id): void
    {
        $this->groupRoleId = $id;
        $groupRole = $this->getModel();
        $groupRole->delete();
        unset($this->groupRoles[$id]);
        $this->dispatch('flash', message: 'Group Role deleted');
        $this->dispatch('refresh-roles');
        $this->resetForm();
    }

    protected function getModel(): GroupRole
    {
        return $this->groupRoleId ?
            GroupRole::findOrFail($this->groupRoleId) :
            new GroupRole([
                'application_id' => $this->applicationId,
                'group_id' => $this->groupId
            ]);
    }

    protected function prepareGroupRole(GroupRole $groupRole): array
    {
        return [
            'application_id' => $groupRole->application_id,
            'group_id' => $groupRole->group_id,
            'role_id' => $groupRole->role_id,
            'roleName' => $groupRole->role?->name,
            'name' => $groupRole->name,
            'code' => $groupRole->code,
            'description' => !empty($groupRole->description) ?
                $groupRole->description :
                $groupRole->role?->description,
            'allowed' => $groupRole->allowed,
            'limit' => $groupRole->limit,
            'statesString' => $groupRole->statesString,
            'behaviorsString' => $groupRole->behaviorsString,
        ];
    }

    protected function rules(): array
    {
        $dslEditor = config('dsl.editor');
        return [
            'limit'             => ['nullable', 'int'],
            'name'              => ['string', 'required'],
            'code'              => [
                'string',
                'required',
                Rule::unique('group_roles')
                    ->where(fn ($query) => $query->where('application_id', $this->applicationId))
                    ->ignore($this->groupRoleId),
            ],
            'description'       => ['nullable', 'string'],
            'allowed'           => ['nullable', 'string'], // todo - dsl-expression
            'statesString'      => ['nullable', $dslEditor, new DslRule(StatesValidator::class, $dslEditor)],
            'behaviorsString'   => ['nullable', $dslEditor, new DslRule(BehaviorsValidator::class, $dslEditor)],
            'role_id'           => [ 'required', 'int'],
        ];
    }

    protected function setSelectKey(): void
    {
        $this->selectKey = 'GroupRoles' . uniqid();
    }
}
