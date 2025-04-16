<?php
namespace App\Livewire;

use App\Models\Application;
use App\Models\Chat;
use App\Models\ChatRole;
use App\Models\Enums\ChatStatus;
use App\Models\Mask;
use App\Models\Character;
use Flux\Flux;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

class Characters extends Component
{
    #[Locked]
    public ?Chat $chat = null;
    #[Locked]
    public ?Application $application = null;
    #[Locked]
    public ?Mask $mask = null;
    /** @var Collection<int, Character> $characters **/
    #[Locked]
    public Collection $characters;
    #[Locked]
    public ?int $characterId = null;
    public array $state = [
        'roles' => []
    ];
    public array $selectRoles = [];

    public function mount(?Application $application = null, ?Chat $chat = null): void
    {
        $this->application = $application?->exists ? $application : null;
        $this->chat = $chat?->exists ? $chat : null;
        $source = $this->chat ?: $this->application;
        if (!$source) {
            throw new \DomainException('Characters component required chat or application');
        }
        $this->prepare();
    }

    public function render(): mixed
    {
        return view('livewire.characters');
    }

    #[On('refresh.chat')]
    public function prepare(): void
    {
        if ($this->application) {
            $this->selectRoles = ChatRole::where('application_id', $this->application->id)
                ->select(['id', 'name'])->get()->toArray();
        }
        $characters = $this->source()->characters;
        if ($this->isStarted()) {
            $characters = $characters->where('is_confirmed', true)->whereNotNull('user_id');
        }
        $this->characters = $characters->keyBy('id');
    }

    public function isOwner(): bool
    {
        return $this->source()->user_id === auth()->id();
    }

    public function isStarted(): bool
    {
        return $this->chat && !in_array($this->chat->status, [ChatStatus::Created, ChatStatus::Published]);
    }

    public function leave(int $id): void
    {
        $character = $this->findCharacter($id);
        if (!$character || $character->user_id !== auth()->id()) {
            return;
        }
        if (!$character->is_confirmed) {
            $character->delete();
        } else {
            $character->update(['user_id' => null]);
        }
        $messages = $character->user_id !== $this->chat->user_id ? [
            'owner' => __('User leaved your chat') . ': ' . $this->chat->title
        ] : [];
        $this->updateCharacter($character, $messages);
        $this->dispatch('flash', message: __('You leaved this chat'));
    }

    public function confirm(int $id): void
    {
        $character = $this->findCharacter($id);
        if (!$character || !$this->isOwner() || $character->is_confirmed) {
            return;
        }
        $character->update(['is_confirmed' => true]);
        $messages = $character->user_id ? [
            $character->user_id => __('Your seat was confirmed in the chat') . ': ' . $this->chat->title
        ] : [];
        $this->updateCharacter($character, $messages);
        $this->dispatch('flash', message: __('Character confirmed'));
    }

    public function canAddCharacter(): bool
    {
        if (!$this->isOwner() &&
            $this->characters->where('user_id', auth()->id())->count()) {
            return false;
        }

        if (!$this->chat) {
            return true;
        }

        return ($this->chat->seats - $this->characters->count()) > 0;
    }

    public function character(): void
    {
        if (!$this->canAddCharacter()) {
            return;
        }
        $this->dispatch('maskSelector');
    }

    #[On('maskSelected')]
    public function addCharacter(int $maskId): void
    {
        if (!$this->canAddCharacter()) {
            return;
        }
        $mask = Mask::findOrFail($maskId);
        $userId = $this->isOwner() ? null : auth()->id();
        $character = Character::create([
            'chat_id' => $this->chat?->id,
            'application_id' => $this->application?->id,
            'user_id' => $userId,
            'mask_id' => $mask->getKey(),
            'gender' => $mask->gender,
            'is_confirmed' => $this->isOwner()
        ]);
        // reload characters
        $messages = $userId ? [
            'owner' => __('Character added to your chat') .': '. $this->chat->title
        ] : [];
        $this->updateCharacter($character, $messages);
        $this->dispatch('flash', message: __('Character added to chat'));
    }

    public function deleteCharacter(int $id): void
    {
        $character = $this->findCharacter($id);
        if (!$character || !$this->isOwner()) {
            return;
        }
        $userId = $character->user_id;
        $messages = $userId && $userId !== auth()->id() ? [
            $userId => __('Your seat was deleted from chat') .': '. $this->chat->title
        ] : [];
        $character->delete();
        $this->updateCharacter($character, $messages);
        $this->dispatch('maskRemoved', maskId: $character->mask_id);
        $this->dispatch('flash', message: __('Character deleted from chat'));
    }

    public function isJoined(): bool
    {
        return !!$this->source()->characters->where('user_id', auth()->id())->count();
    }

    public function join(int $id): void
    {
        $character = $this->findCharacter($id);
        if (!$character || $character->user_id) {
            return;
        }
        $character->update(['user_id' => auth()->id()]);
        $messages = $character->user_id !== $this->chat->user_id ? [
            'owner' => __('User joined your chat') . ': ' . $this->chat->title
        ] : [];
        $this->updateCharacter($character, $messages);
        $this->dispatch('flash', message: __('You joined this chat'));
    }

    public function manageRoles(int $characterId): void
    {
        $this->characterId = $characterId;
        $character = Character::findOrFail($characterId);
        $this->state['roles'] = $character->roles->pluck('id')->toArray();
        $this->dispatch('searchable-multi-select-roles', searchableId: 'roles', options: $this->selectRoles);
        Flux::modal('form-chat-roles')->show();
    }

    public function submitRoles(): void
    {
        $character = Character::findOrFail($this->characterId);
        $character->roles()->sync($this->state['roles']);
        Flux::modal('form-chat-roles')->close();
    }

    public function showMask(int $id): void
    {
        $this->mask = Mask::findOrFail($id); // todo
        Flux::modal('show-mask')->show();
    }

    public function maskIds(): array
    {
        return $this->source()->characters->pluck('mask_id')->toArray();
    }

    protected function findCharacter(int $id): ?Character
    {
        return $this->chat->characters->where('id', $id)->first();
    }

    protected function source(): Chat|Application
    {
        return $this->chat ?: $this->application;
    }

    protected function updateCharacter(Character $character, array $messages = []): void
    {
        if (!$character->exists) {
            $this->characters->forget($character->id);
        } elseif (! $this->characters->has($character->id)) {
            $this->characters->put($character->id, $character);
        } else {
            $this->characters->put($character->id, $character);
        }

        $this->dispatch('updateCharacters', messages: $messages);
    }
}
