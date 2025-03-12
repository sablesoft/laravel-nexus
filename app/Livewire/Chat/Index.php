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
            'title' => 'Title',
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
}
