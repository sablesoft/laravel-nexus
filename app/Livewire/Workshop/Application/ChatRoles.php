<?php
namespace App\Livewire\Workshop\Application;

use App\Livewire\Workshop\HasCodeMirror;
use App\Logic\Rules\DslRule;
use App\Logic\Validators\BehaviorsValidator;
use App\Logic\Validators\StatesValidator;
use App\Models\ChatRole;
use App\Models\Services\StoreService;
use Flux\Flux;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;
use Symfony\Component\Yaml\Yaml;

class ChatRoles extends Component
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
    public array $chatRoles = [];
    #[Locked]
    public string $action;
    #[Locked]
    public ?int $chatRoleId = null;
    public array $state;

    public function mount(): void
    {
        $this->setSelectKey();
        /** @var Collection<int, ChatRole> $chatRoles */
        $chatRoles = ChatRole::where('chat_group_id', $this->groupId)->with('role')->get();
        foreach ($chatRoles as $chatRole) {
            $this->chatRoles[$chatRole->id] = $this->prepareGroupRole($chatRole);
        }
        $this->resetForm();
    }

    public function render(): mixed
    {
        return view('livewire.workshop.application.chat-roles', [
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
        $this->chatRoleId = null;
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
        $this->chatRoleId = $id;
        $this->action = 'edit';
        $chatRole = $this->chatRoles[$id];
        foreach (array_keys($this->rules()) as $field) {
            $this->state[$field] = $chatRole[$field];
        }
        if ($chatRole['role_id']) {
            $this->setSelectKey();
            $this->roles[] = [
                'name' => $chatRole['roleName'],
                'id' => $chatRole['role_id']
            ];
        }
        $this->dispatchCodeMirror();
        Flux::modal('form-group-'.$this->groupId.'-role')->show();
    }

    protected function codeMirrorViewMap(): array
    {
        return [
            'codemirror-state-chat-role-' => 'state',
        ];
    }

    public function submit(): void
    {
        $data = $this->validate(\Arr::prependKeysWith($this->rules(), 'state.'));
        $chatRole = $this->getModel();
        if ($this->submitRoleChanged($data['state'], $chatRole)) {
            $this->dispatch('refresh-roles');
        }
        /** @var ChatRole $chatRole */
        $chatRole = StoreService::handle($data['state'], $chatRole);
        $this->chatRoles[$chatRole->id] = $this->prepareGroupRole($chatRole);
        $this->dispatchCodeMirrorView($chatRole->getKey());
        $this->resetForm();
        Flux::modal('form-group-'.$this->groupId.'-role')->close();
        $this->dispatch('flash', message: 'Group Role' . ($this->chatRoleId ? ' updated' : ' created'));
    }

    protected function submitRoleChanged(array $data, ChatRole $groupRole): bool
    {
        return ($this->action === 'create') || ($data['role_id'] !== $groupRole->role_id);
    }

    public function delete(int $id): void
    {
        $this->chatRoleId = $id;
        $chatRole = $this->getModel();
        $chatRole->delete();
        unset($this->chatRoles[$id]);
        $this->dispatch('flash', message: __('Chat Role deleted'));
        $this->dispatch('refresh-roles');
        $this->resetForm();
    }

    protected function getModel(): ChatRole
    {
        return $this->chatRoleId ?
            ChatRole::findOrFail($this->chatRoleId) :
            new ChatRole([
                'application_id' => $this->applicationId,
                'chat_group_id' => $this->groupId
            ]);
    }

    protected function prepareGroupRole(ChatRole $chatRole): array
    {
        return [
            'application_id' => $chatRole->application_id,
            'group_id' => $chatRole->chat_group_id,
            'role_id' => $chatRole->role_id,
            'roleName' => $chatRole->role?->name,
            'name' => $chatRole->name,
            'code' => $chatRole->code,
            'description' => !empty($chatRole->description) ?
                $chatRole->description :
                $chatRole->role?->description,
            'allowed' => $chatRole->allowed,
            'limit' => $chatRole->limit,
            'statesString' => $chatRole->statesString,
            'behaviorsString' => $chatRole->behaviorsString,
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
                // TODO
//                'required',
//                Rule::unique(ChatRole::class)
//                    ->where(fn ($query) => $query->where('application_id', $this->applicationId))
//                    ->ignore($this->chatRoleId),
            ],
            'description'       => ['nullable', 'string'],
            'allowed'           => ['nullable', 'string'], // todo - dsl-expression
            'statesString'      => ['nullable', $dslEditor, new DslRule(StatesValidator::class, $dslEditor)],
            'behaviorsString'   => ['nullable', $dslEditor, new DslRule(BehaviorsValidator::class, $dslEditor)],
            'role_id'           => [ 'nullable', 'int'],
        ];
    }

    protected function setSelectKey(): void
    {
        $this->selectKey = 'ChatRoles' . uniqid();
    }
}
