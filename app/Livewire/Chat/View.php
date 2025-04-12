<?php /** @noinspection PhpUndefinedMethodInspection */

namespace App\Livewire\Chat;

use App\Livewire\PresenceTrait;
use App\Models\Chat;
use App\Models\Enums\ChatStatus;
use App\Models\Mask;
use App\Models\Member;
use App\Models\User;
use App\Notifications\ChatUpdated;
use Flux\Flux;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class View extends Component
{
    use PresenceTrait;

    public Chat $chat;
    public ?Mask $mask = null;

    protected function getListeners(): array
    {
        return [
            'usersHere' => 'here',
            'userJoining' => 'joining',
            'userLeaving' => 'leaving',
            'refresh.chat' => '$refresh'
        ];
    }

    public function mount(int $id): void
    {
        $this->chat = Chat::with(['user', 'application', 'members.mask', 'members.user'])->findOrFail($id);
    }

    public function render(): mixed
    {
        return view('livewire.chat.view', [
            'chat' => $this->chat,
            'presence' => [$this->chatViewChannel() => []]
        ])->title(__('Chat View').': ' . $this->chat->title);
    }

    protected function chatViewChannel(): string
    {
        return 'chats.view.'. $this->chat->id;
    }

    public function close(): void
    {
        $this->redirectRoute('chats', [], true, true);
    }

    // edit flow

    public function canEdit(): bool
    {
        return $this->isOwner() &&
            $this->chat->status === ChatStatus::Created;
    }

    public function edit(): void
    {
        if (!$this->canEdit()) {
            return;
        }

        $this->redirectRoute('chats.edit', ['id' => $this->chat->id], true, true);
    }

    // publish flow

    public function publish(): void
    {
        if (!$this->canEdit()) {
            return;
        }

        Flux::modal('publish-confirmation')->show();
    }

    public function publishConfirmed(): void
    {
        Flux::modal('publish-confirmation')->close();
        if (!$this->canEdit()) {
            return;
        }

        $this->chat->update(['status' => ChatStatus::Published]);
        $this->dispatch('flash', message: __('Your chat was published'));
    }

    // start flow

    public function canStart(): bool
    {
        return $this->isOwner() &&
            $this->chat->status === ChatStatus::Published &&
            !!$this->chat->members->whereNotNull('user_id')
                ->where('is_confirmed', true)->count();
    }

    public function start(): void
    {
        if (!$this->canStart()) {
            return;
        }

        Flux::modal('start-confirmation')->show();
    }

    public function startConfirmed(): void
    {
        Flux::modal('start-confirmation')->close();
        if (!$this->canStart()) {
            return;
        }

        $this->chat->update(['status' => ChatStatus::Started]);
        $this->dispatch('flash', message: __('Your chat was started!'));
        $this->updateMembers(['others' => __('Chat is ready to play') . ': ' . $this->chat->title]);
    }

    // play flow

    public function isJoined(): bool
    {
        return !!$this->chat->members->where('user_id', auth()->id())->count();
    }

    public function canPlay(): bool
    {
        return $this->chat->status === ChatStatus::Started &&
            $this->isJoined();
    }

    public function play(): void
    {
        $this->redirectRoute('chats.play', ['id' => $this->chat->id], true, true);
    }

    public function isOwner(): bool
    {
        return $this->chat->user_id === auth()->id();
    }

    #[On('updateMembers')]
    public function updateMembers(array $messages): void
    {
        $this->chat->refresh()->load(['user', 'application', 'members.mask', 'members.user']);
        $link = route('chats.view', ['id' => $this->chat->id]);
        $handledIds = [];
        // handle seats users:
        foreach ($this->chat->takenSeats as $member) {
            $flash = $messages['others'] ?? null;
            $flash = $messages[$member->user_id] ?? $flash;
            if ($flash && $member->user_id !== auth()->id()) {
                $member->user->notifyNow(new ChatUpdated($flash, $link));
                $handledIds[] = $member->user_id;
            }
        }
        // handle chat owner:
        $flash = $messages['owner'] ?? null;
        if ($flash) {
            $this->chat->user->notifyNow(new ChatUpdated($flash, $link));
            $handledIds[] = $this->chat->user_id;
        }
        // handle remain presence:
        $remainIds = array_diff($this->userIds[$this->chatViewChannel()] ?? [], array_unique($handledIds));
        if ($remainIds) {
            $instance = new ChatUpdated();
            $users = User::whereIn('id', $remainIds)->get();
            foreach ($users as $user) {
                $user->notifyNow($instance);
            }
        }
    }
}
