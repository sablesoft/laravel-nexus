<?php

namespace App\Livewire\Chat;

use App\Livewire\PresenceTrait;
use App\Models\Chat;
use App\Models\Enums\ChatStatus;
use App\Models\Member;
use App\Models\Memory;
use App\Notifications\ChatPlaying;
use App\Notifications\ScreenUpdated;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Component;

#[Layout('components.layouts.play')]
class Play extends Component
{
    use PresenceTrait;

    public Chat $chat;
    #[Locked]
    public int $memberId;
    public string $message = '';
    #[Locked]
    public Collection $onlineMembers;
    #[Locked]
    public Collection $offlineMembers;

    protected function getListeners(): array
    {
        return [
            'usersHere' => 'here',
            'userJoining' => 'joining',
            'userLeaving' => 'leaving',
            'refresh.screen' => '$refresh'
        ];
    }

    public function mount(int $id): void
    {
        $this->chat = Chat::with('application', 'members.mask', 'memories')->findOrFail($id);
        if (!$this->canPlay()) {
            $this->redirectRoute('chats.view', ['id' => $id], true, true);
        }
        $this->memberId = $this->chat->takenSeats->where('user_id', auth()->id())->first()->id;
        $this->prepareMembers();
    }

    public function render(): mixed
    {
        return view('livewire.chat.play')
            ->title('Chat Play: ' . $this->chat->title);
    }

    protected function handleHere(): void
    {
        $this->prepareMembers();

        $message = $this->member()->mask_name . ' is playing "' . $this->chat->title . '"';
        $link = route('chats.play', ['id' => $this->chat->id]);
        /** @var Member $member */
        foreach ($this->offlineMembers as $member) {
            $member->user->notifyNow(new ChatPlaying($message, $link));
        }
    }

    protected function handleJoining(int $id): void
    {
        $this->prepareMembers();
    }

    protected function handleLeaving(int $id): void
    {
        $this->prepareMembers();
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

    public function sendMessage(): void
    {
        // todo - test messages:
        Memory::create([
            'chat_id' => $this->chat->id,
            'member_id' => $this->memberId,
            'content' => $this->message,
            'type' => 'chat'
        ]);
        $this->message = '';
        /** @var Member $member */
        foreach ($this->onlineMembers as $member) {
            if ($member->id !== $this->memberId) {
                $member->user->notifyNow(new ScreenUpdated());
            }
        }
    }

    protected function canPlay(): bool
    {
        return $this->chat->status === ChatStatus::Started &&
            !!$this->chat->members->where('user_id', auth()->id())
                ->where('is_confirmed', true)->count();
    }

    protected function member(): Member
    {
        return $this->chat->takenSeats->where('id', $this->memberId)->first();
    }
}
