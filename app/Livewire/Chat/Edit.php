<?php

namespace App\Livewire\Chat;

use App\Models\Chat;
use App\Models\Services\StoreService;
use Livewire\Component;

class Edit extends Component
{
    public Chat $chat;

    public array $state;

    public function mount(int $id): void
    {
        $this->chat = Chat::with('application', 'members.mask')->findOrFail($id);
        if (!$this->canEdit()) {
            $this->redirectRoute('chats.view', ['id' => $id], true, true);
        }
        $this->state = $this->chat->only('title', 'seats');
    }

    public function render(): mixed
    {
        return view('livewire.chat.edit')
            ->title(__('Chat Edit').': ' . $this->chat->title);
    }

    public function close(): void
    {
        $this->redirectRoute('chats.view', ['id' => $this->chat->id], true, true);
    }

    public function canEdit(): bool
    {
        return $this->chat->id === auth()->id();
    }

    public function update(): void
    {
        $rules = [
            'title' => 'string|required',
            'seats' => 'int|required|min:1'
        ];
        $data = $this->validate(\Arr::prependKeysWith($rules, 'state.'));
        StoreService::handle($data['state'], $this->chat);
        $this->dispatch('flash', message: __('Your chat was updated'));
    }
}
