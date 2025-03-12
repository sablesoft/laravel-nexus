<?php /** @noinspection PhpUndefinedMethodInspection */

namespace App\Livewire\Chat;

use App\Models\Chat;
use App\Models\Enums\ChatStatus;
use App\Models\Mask;
use App\Models\Member;
use Flux\Flux;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class View extends Component
{
    public Chat $chat;
    public ?Mask $mask = null;
    public Collection $masks;
    public ?int $maskId = null;

    public function mount(int $id): void
    {
        $this->masks = new Collection();
        $this->chat = Chat::with(['user', 'application', 'members.mask', 'members.user'])->findOrFail($id);
    }

    public function render(): mixed
    {
        return view('livewire.chat.view', [
            'chat' => $this->chat,
        ])->title('Chat View: ' . $this->chat->title);
    }

    public function canEdit(): bool
    {
        return $this->isOwner() &&
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
        Flux::modal('publish-confirmation')->close();
        if (!$this->canEdit()) {
            return;
        }

        $this->chat->update(['status' => ChatStatus::Published]);
        $this->dispatch('flash', message: 'Your chat was published!');
    }

    public function edit(): void
    {
        if (!$this->canEdit()) {
            return;
        }

        $this->redirectRoute('chats.edit', ['id' => $this->chat->id], true, true);
    }

    public function canAddMask(): bool
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
        if (!$this->canAddMask()) {
            return;
        }
        $takenMaskIds = [];
        foreach ($this->chat->members as $member) {
            $takenMaskIds[] = $member->mask_id;
        }

        $query = Mask::whereNotIn('id', $takenMaskIds);
        if ($this->isOwner()) {
            $query->where(function($q) {
                $q->where('is_public', true)
                    ->orWhere('user_id', auth()->id());
            });
        } else {
            $query->where('is_public', true);
        }

        $this->masks = $query->get();
        if (!$this->masks->count()) {
            return;
        }

        $this->maskId = $this->masks->first()->id;
        Flux::modal('add-member')->show();
    }

    public function addMask(): void
    {
        Flux::modal('add-member')->close();
        if (!$this->canAddMask()) {
            return;
        }
        $userId = $this->isOwner() ? null : auth()->id();
        Member::create([
            'chat_id' => $this->chat->id,
            'mask_id' => $this->maskId,
            'user_id' => $userId,
            'is_confirmed' => $this->isOwner()
        ]);
        $this->reload();
        $this->dispatch('flash', message: 'Member added to chat!');
    }

    public function showMask(int $id): void
    {
        $this->mask = Mask::findOrFail($id);
        Flux::modal('show-mask')->show();
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
        $this->reload();
        $this->dispatch('flash', message: 'Your joined this chat!');
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
        $this->reload();
        $this->dispatch('flash', message: 'Your leaved this chat!');
    }

    public function deleteMember(int $id): void
    {
        $member = $this->findMember($id);
        if (!$member || !$this->isOwner()) {
            return;
        }
        $member->delete();
        $this->reload();
        $this->dispatch('flash', message: 'Member deleted from chat!');
    }

    public function confirm(int $id): void
    {
        $member = $this->findMember($id);
        if (!$member || !$this->isOwner() || $member->is_confirmed) {
            return;
        }
        $member->update(['is_confirmed' => true]);
        $this->reload();
        $this->dispatch('flash', message: 'Member confirmed');
    }

    public function canStart(): bool
    {
        return $this->isOwner() &&
            $this->chat->status === ChatStatus::Published;
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
        $this->dispatch('flash', message: 'Your chat was started!');
    }

    public function isStarted(): bool
    {
        return !in_array($this->chat->status, [ChatStatus::Created, ChatStatus::Published]);
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

    public function close(): void
    {
        $this->redirectRoute('chats', [], true, true);
    }

    public function isOwner(): bool
    {
        return $this->chat->user_id === auth()->id();
    }

    protected function findMember(int $id): ?Member
    {
        return $this->chat->members->where('id', $id)->first();
    }

    protected function reload(): void
    {
        $this->chat->refresh()->load(['user', 'application', 'members.mask', 'members.user']);
    }
}
