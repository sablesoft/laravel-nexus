<?php

namespace App\Livewire\Chat;

use App\Models\Chat;
use App\Models\Enums\ChatStatus;
use Livewire\Component;

class Play extends Component
{
    public Chat $chat;

    public function mount(int $id): void
    {
        $this->chat = Chat::with('application', 'members.mask')->findOrFail($id);
        if (!$this->canPlay()) {
            $this->redirectRoute('chats.view', ['id' => $id], true, true);
        }
    }

    public function render(): mixed
    {
        return view('livewire.chat.play')
            ->title('Chat Play: ' . $this->chat->title);
    }

    public function close(): void
    {
        $this->redirectRoute('chats.view', ['id' => $this->chat->id], true, true);
    }

    public function canPlay(): bool
    {
        return $this->chat->status === ChatStatus::Started &&
            !!$this->chat->members->where('user_id', auth()->id())->count();
    }
}
