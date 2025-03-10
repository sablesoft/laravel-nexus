<?php

namespace App\Livewire\Chat;

use App\Models\Chat;
use App\Models\Enums\ChatStatus;
use Flux\Flux;
use Livewire\Component;

class View extends Component
{
    public Chat $chat;

    public function mount(int $id): void
    {
        $this->chat = Chat::with('application', 'members.mask')->findOrFail($id);
    }

    public function render(): mixed
    {
        return view('livewire.chat.view', [
            'chat' => $this->chat,
        ])->title('Chat View: ' . $this->chat->title);
    }

    public function canEdit(): bool
    {
        return $this->chat->id === auth()->id() &&
            $this->chat->status === ChatStatus::Created;
    }

    public function publish(): void
    {
        if (!$this->canEdit()) {
            return;
        }

        Flux::modal('publish-confirmation')->show();
    }

    public function publishConfirmed(): void
    {
        if (!$this->canEdit()) {
            return;
        }

        $this->chat->update(['status' => ChatStatus::Published]);
        $this->dispatch('flash', message: 'Your chat was published!');
        Flux::modal('publish-confirmation')->close();
    }

    public function edit(): void
    {
        if (!$this->canEdit()) {
            return;
        }

        $this->redirectRoute('chats.edit', ['id' => $this->chat->id], true, true);
    }

    public function canJoin(): bool
    {
        return true; // todo
    }

    public function join(): void
    {
        // todo - validate if can
        $this->dispatch('flash', message: 'Your joined this chat!');
    }

    public function close(): void
    {
        $this->redirectRoute('chats', [], true, true);
    }
}
