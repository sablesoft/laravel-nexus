<?php
namespace App\Livewire;

use App\Models\Application;
use App\Models\Chat;
use App\Models\Enums\ChatStatus;
use App\Models\Mask;
use App\Models\Member;
use Flux\Flux;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

class Members extends Component
{
    #[Locked]
    public ?Chat $chat = null;
    #[Locked]
    public ?Application $application = null;
    public ?Mask $mask = null;
    public Collection $members;

    public function mount(?Application $application = null, ?Chat $chat = null): void
    {
        $this->application = $application?->exists ? $application : null;
        $this->chat = $chat?->exists ? $chat : null;
        $source = $this->chat ?: $this->application;
        if (!$source) {
            throw new \DomainException('Members component required chat or application');
        }
        $this->prepareMembers();
    }

    public function render(): mixed
    {
        return view('livewire.members');
    }

    #[On('refresh.chat')]
    public function prepareMembers(): void
    {
        $members = $this->source()->members;
        if ($this->isStarted()) {
            $members = $members->where('is_confirmed', true)->whereNotNull('user_id');
        }
        $this->members = $members->keyBy('id');
    }

    public function isOwner(): bool
    {
        return $this->source()->user_id === auth()->id();
    }

    public function isStarted(): bool
    {
        return $this->chat && !in_array($this->chat->status, [ChatStatus::Created, ChatStatus::Published]);
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
        $messages = $member->user_id !== $this->chat->user_id ? [
            'owner' => __('User leaved your chat') . ': ' . $this->chat->title
        ] : [];
        $this->updateMember($member, $messages);
        $this->dispatch('flash', message: __('You leaved this chat'));
    }

    public function confirm(int $id): void
    {
        $member = $this->findMember($id);
        if (!$member || !$this->isOwner() || $member->is_confirmed) {
            return;
        }
        $member->update(['is_confirmed' => true]);
        $messages = $member->user_id ? [
            $member->user_id => __('Your seat was confirmed in the chat') . ': ' . $this->chat->title
        ] : [];
        $this->updateMember($member, $messages);
        $this->dispatch('flash', message: __('Member confirmed'));
    }

    public function canAddMember(): bool
    {
        if (!$this->isOwner() &&
            $this->members->where('user_id', auth()->id())->count()) {
            return false;
        }

        if (!$this->chat) {
            return true;
        }

        return ($this->chat->seats - $this->members->count()) > 0;
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
        $mask = Mask::findOrFail($maskId);
        $userId = $this->isOwner() ? null : auth()->id();
        $member = Member::create([
            'chat_id' => $this->chat?->id,
            'application_id' => $this->application?->id,
            'user_id' => $userId,
            'mask_id' => $mask->getKey(),
            'gender' => $mask->gender,
            'is_confirmed' => $this->isOwner()
        ]);
        // reload members
        $messages = $userId ? [
            'owner' => __('Member added to your chat') .': '. $this->chat->title
        ] : [];
        $this->updateMember($member, $messages);
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
        $member->delete();
        $this->updateMember($member, $messages);
        $this->dispatch('maskRemoved', maskId: $member->mask_id);
        $this->dispatch('flash', message: __('Member deleted from chat'));
    }

    public function isJoined(): bool
    {
        return !!$this->source()->members->where('user_id', auth()->id())->count();
    }

    public function join(int $id): void
    {
        $member = $this->findMember($id);
        if (!$member || $member->user_id) {
            return;
        }
        $member->update(['user_id' => auth()->id()]);
        $messages = $member->user_id !== $this->chat->user_id ? [
            'owner' => __('User joined your chat') . ': ' . $this->chat->title
        ] : [];
        $this->updateMember($member, $messages);
        $this->dispatch('flash', message: __('You joined this chat'));
    }

    public function showMask(int $id): void
    {
        $this->mask = Mask::findOrFail($id); // todo
        Flux::modal('show-mask')->show();
    }

    public function maskIds(): array
    {
        return $this->source()->members->pluck('mask_id')->toArray();
    }

    protected function findMember(int $id): ?Member
    {
        return $this->chat->members->where('id', $id)->first();
    }

    protected function source(): Chat|Application
    {
        return $this->chat ?: $this->application;
    }

    protected function updateMember(Member $member, array $messages = []): void
    {
        if (!$member->exists) {
            $this->members->forget($member->id);
        } elseif (! $this->members->has($member->id)) {
            $this->members->put($member->id, $member);
        } else {
            $this->members->put($member->id, $member);
        }

        $this->dispatch('updateMembers', messages: $messages);
    }
}
