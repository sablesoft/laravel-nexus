<?php

namespace App\Livewire\Chat;

use App\Crud\Traits\HandlePaginate;
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
        if ($this->status !== 'all') {
            $query->where('status', $this->status);
        }
        if ($this->owner === 'user') {
            $query->where('user_id', auth()->id());
        } elseif ($this->owner === 'others') {
            $query->whereNot('user_id', auth()->id());
        }
        if ($this->memberOnly) {
            $query->whereHas('members', function ($query) {
                $query->where('user_id', auth()->id());
            });
        }

        return $query;
    }
}
