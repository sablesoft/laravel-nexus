<?php

namespace App\Livewire\Chat;

use App\Models\Chat;
use Livewire\Component;

class View extends Component
{
    public Chat $chat;

    public function mount(int $id): void
    {
        $this->chat = Chat::with('application', 'members.mask')->findOrFail($id);
    }

    public function canEdit(): bool
    {
        return $this->chat->id === auth()->id();
    }

    public function edit(): void
    {
        dd($this->chat);
    }

    public function close(): void
    {
        $this->redirectRoute('chats', [], true, true);
    }

    public function render(): mixed
    {
        return view('livewire.chat.view', [
            'chat' => $this->chat,
        ])->title('Chat View: ' . $this->chat->title);
    }
}
