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
    public Collection $masks;

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
        $this->masks = new Collection();
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

    // member flow

    public function canAddMember(): bool
    {
        if (!$this->isOwner() &&
            $this->chat->members->where('user_id', auth()->id())->count()) {
            return false;
        }
        $hasSlots = $this->chat->seats - $this->chat->members->count() > 0;
        if (!$hasSlots) {
            return false;
        }

        return true;
    }

    public function member(): void
    {
        if (!$this->canAddMember()) {
            return;
        }
        $this->dispatch('maskSelector');
    }

    #[On('maskSelected')]
    public function addMember(int $maskId): void
    {
        if (!$this->canAddMember()) {
            return;
        }
        $userId = $this->isOwner() ? null : auth()->id();
        Member::create([
            'chat_id' => $this->chat->id,
            'mask_id' => $maskId,
            'user_id' => $userId,
            'is_confirmed' => $this->isOwner()
        ]);
        $this->reloadChat();
        $messages = $userId ? [
            'owner' => __('Member added to your chat') .': '. $this->chat->title
        ] : [];
        $this->notify($messages);
        $this->dispatch('flash', message: __('Member added to chat'));
    }

    public function deleteMember(int $id): void
    {
        $member = $this->findMember($id);
        if (!$member || !$this->isOwner()) {
            return;
        }
        $userId = $member->user_id;
        $messages = $userId && $userId !== auth()->id() ? [
            $userId => __('Your seat was deleted from chat') .': '. $this->chat->title
        ] : [];
        $this->notify($messages);
        $member->delete();
        $this->reloadChat();
        $this->dispatch('maskRemoved', maskId: $member->mask_id);
        $this->dispatch('flash', message: __('Member deleted from chat'));
    }

    public function isJoined(): bool
    {
        return !!$this->chat->members->where('user_id', auth()->id())->count();
    }

    public function join(int $id): void
    {
        $member = $this->findMember($id);
        if (!$member || $member->user_id) {
            return;
        }
        $member->update(['user_id' => auth()->id()]);
        $this->reloadChat();
        $messages = $member->user_id !== $this->chat->user_id ? [
            'owner' => __('User joined your chat') . ': ' . $this->chat->title
        ] : [];
        $this->notify($messages);
        $this->dispatch('flash', message: __('You joined this chat'));
    }

    public function leave(int $id): void
    {
        $member = $this->findMember($id);
        if (!$member || $member->user_id !== auth()->id()) {
            return;
        }
        if (!$member->is_confirmed) {
            $member->delete();
        } else {
            $member->update(['user_id' => null]);
        }
        $this->reloadChat();
        $messages = $member->user_id !== $this->chat->user_id ? [
            'owner' => __('User leaved your chat') . ': ' . $this->chat->title
        ] : [];
        $this->notify($messages);
        $this->dispatch('flash', message: __('You leaved this chat'));
    }

    public function confirm(int $id): void
    {
        $member = $this->findMember($id);
        if (!$member || !$this->isOwner() || $member->is_confirmed) {
            return;
        }
        $member->update(['is_confirmed' => true]);
        $this->reloadChat();
        $messages = $member->user_id ? [
            $member->user_id => __('Your seat was confirmed in the chat') . ': ' . $this->chat->title
        ] : [];
        $this->notify($messages);
        $this->dispatch('flash', message: __('Member confirmed'));
    }

    public function showMask(int $id): void
    {
        $this->mask = Mask::findOrFail($id);
        Flux::modal('show-mask')->show();
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
        $this->notify(['others' => __('Chat is ready to play') . ': ' . $this->chat->title]);
    }

    public function isStarted(): bool
    {
        return !in_array($this->chat->status, [ChatStatus::Created, ChatStatus::Published]);
    }

    // play flow

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

    protected function findMember(int $id): ?Member
    {
        return $this->chat->members->where('id', $id)->first();
    }

    protected function reloadChat(): void
    {
        $this->chat->refresh()->load(['user', 'application', 'members.mask', 'members.user']);
    }

    protected function notify(array $messages = []): void
    {
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
