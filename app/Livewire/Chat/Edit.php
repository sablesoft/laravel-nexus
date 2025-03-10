<?php

namespace App\Livewire\Chat;

use App\Models\Chat;
use Livewire\Component;

class Edit extends Component
{
    public Chat $chat;

    public function mount(int $id): void
    {
        $this->chat = Chat::with('application', 'members.mask')->findOrFail($id);
        if (!$this->canEdit()) {
            $this->redirectRoute('chats.view', ['id' => $id], true, true);
        }
    }

    public function canEdit(): bool
    {
        return $this->chat->id === auth()->id();
    }

    public function edit(): void
    {
        dd($this->chat);
    }

    public function render(): mixed
    {
        return view('livewire.chat.edit', [
            'chat' => $this->chat,
        ])->title('Chat Edit: ' . $this->chat->title);
    }
}
