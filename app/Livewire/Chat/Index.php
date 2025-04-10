<?php

namespace App\Livewire\Chat;

use App\Crud\Traits\HandlePaginate;
use App\Models\Enums\ChatStatus;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use App\Models\Chat;

class Index extends Component
{
    use HandlePaginate;

    public ?Chat $chat = null;

    public string $status = 'all';
    public string $owner = 'all';

    public bool $memberOnly = false;

    public function render(): mixed
    {
        return view('livewire.chat.index', [
            'models' => $this->paginator()
        ]);
    }

    public function className(): string
    {
        return Chat::class;
    }

    public function orderByFields(): array
    {
        return [
            'id' => 'ID',
//            'title' => __('Title'), TODO
        ];
    }

    public function getStatuses(): array
    {
        return ($this->owner === 'others') ?
            ChatStatus::publicValues() :
            ChatStatus::values();
    }

    public function view(int $id): void
    {
        $this->redirectRoute('chats.view', ['id' => $id], true, true);
    }

    public function canLeave(int $id): bool
    {
        $chat = $this->getChat($id);
        if (!$chat || !in_array($chat->status, [ChatStatus::Created, ChatStatus::Published])) {
            return false;
        }

        return $this->isJoined($chat);
    }

    public function leave(int $id): void
    {
        $chat = $this->getChat($id);
        if (!$chat) {
            return;
        }
        $member = $chat->members->where('user_id', auth()->id())->first();
        if (!$member) {
            return;
        }
        if (!$member->is_confirmed) {
            $member->delete();
        } else {
            $member->update(['user_id' => null]);
        }
        $this->dispatch('flash', message: __('You leaved this chat'));
    }

    public function canPlay(int $id): bool
    {
        $chat = $this->getChat($id);
        if (!$chat || $chat->status !== ChatStatus::Started) {
            return false;
        }

        return $this->isJoined($chat);
    }

    public function play(int $id): void
    {
        if (!$this->canPlay($id)) {
            return;
        }

        $this->redirectRoute('chats.play', ['id' => $id], true, true);
    }

    protected function paginationProperties(): array
    {
        return ['orderBy', 'orderDirection', 'perPage', 'search', 'status', 'owner', 'memberOnly'];
    }

    protected function filterByOwner(Builder $query): Builder
    {
        return $query;
    }

    protected function modifyQuery(Builder $query): Builder
    {
        $query->with(['application', 'members']);
        $userId = auth()->id();
        if ($this->owner === 'user') {
            $query->where('user_id', $userId);
        } elseif ($this->owner === 'others') {
            $query->where('user_id', '!=', $userId);
        }
        if ($this->status !== 'all') {
            $query->where('status', $this->status);
        }
        if ($this->owner === 'others' || $this->owner === 'all') {
            $query->where(function ($q) use ($userId) {
                $q->where('user_id', $userId)
                ->orWhere('status', 'published') // Всегда показываем Published
                ->orWhere(function ($subQuery) use ($userId) {
                    $subQuery->whereIn('status', ['started', 'ended']) // Показываем Started и Ended
                    ->whereHas('members', function ($memberQuery) use ($userId) {
                        $memberQuery->where('user_id', $userId); // Только если пользователь участник
                    });
                })->orWhere(function ($createdQuery) use ($userId) {
                        $createdQuery->where('status', 'created') // Показываем Created
                        ->whereHas('members', function ($memberQuery) use ($userId) {
                            $memberQuery->where('user_id', $userId); // Только если пользователь участник
                        });
                    });
            });
            if ($this->owner === 'others') {
                $query->where('status', '!=', 'created');
            }
        }
        if ($this->memberOnly) {
            $query->whereHas('members', function ($memberQuery) use ($userId) {
                $memberQuery->where('user_id', $userId);
            });
        }

        return $query;
    }

    protected function isJoined(Chat $chat): bool
    {
        return !!$chat->members->where('user_id', auth()->id())->count();
    }

    protected function getChat(int $id): ?Chat
    {
        return Chat::with('members')->where('id', $id)->first();
    }
}
