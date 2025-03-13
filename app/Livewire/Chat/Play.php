<?php

namespace App\Livewire\Chat;

use App\Models\Chat;
use App\Models\Enums\ChatStatus;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Component;

#[Layout('components.layouts.play')]
class Play extends Component
{
    public Chat $chat;
    #[Locked]
    public array $userIds = [];
    public string $message = '';
    #[Locked]
    public Collection $onlineMembers;
    #[Locked]
    public Collection $offlineMembers;

    protected $listeners = [
        "usersHere" => 'here',
        "userJoining" => 'joining',
        "userLeaving" => 'leaving',
    ];

    public function mount(int $id): void
    {
        $this->chat = Chat::with('application', 'members.mask')->findOrFail($id);
        if (!$this->canPlay()) {
            $this->redirectRoute('chats.view', ['id' => $id], true, true);
        }
        $this->prepareMembers();
    }

    public function render(): mixed
    {
        return view('livewire.chat.play')
            ->title('Chat Play: ' . $this->chat->title);
    }

    public function here(array $members): void
    {
        $this->userIds = array_column($members, 'id');
        $this->prepareMembers();
        \Log::debug('[Play][Here]', $this->userIds);
    }

    public function joining(int $id): void
    {
        $this->userIds[] = $id;
        $this->userIds = array_unique($this->userIds);
        $this->prepareMembers();
        \Log::debug('[Play][Joining]', compact('id'));
    }

    public function leaving(int $id): void
    {
        $this->userIds = array_values(array_diff($this->userIds, [$id]));
        $this->prepareMembers();
        \Log::debug('[Play][Leaving]', compact('id'));
    }

    public function prepareMembers(): void
    {
        $this->offlineMembers = $this->chat->takenSeats->filter(
            fn($member) => !in_array($member->user_id, $this->userIds)
        );
        $this->onlineMembers = $this->chat->takenSeats->filter(
            fn($member) => in_array($member->user_id, $this->userIds)
        );
    }

    public function close(): void
    {
        $this->redirectRoute('chats.view', ['id' => $this->chat->id], true, true);
    }

    public function canPlay(): bool
    {
        return $this->chat->status === ChatStatus::Started &&
            !!$this->chat->members->where('user_id', auth()->id())
                ->where('is_confirmed', true)->count();
    }
}
