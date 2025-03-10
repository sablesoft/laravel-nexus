<?php

namespace App\Livewire;

use App\Models\Chat;
use Flux\Flux;
use App\Crud\Traits\HandlePaginate;
use App\Models\Application;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class Catalog extends Component
{
    use HandlePaginate;

    public ?Application $application = null;

    public function render(): mixed
    {
        return view('livewire.catalog', [
            'models' => $this->paginator()
        ]);
    }

    public function className(): string
    {
        return Application::class;
    }

    public function show(int $id): void
    {
        $this->application = Application::findOrFail($id);
        Flux::modal('details')->show();
    }

    public function play(): void
    {
        $number = Chat::where([
            'user_id' => auth()->id(),
            'application_id' => $this->application->id
        ])->count() + 1;
        $chat = Chat::create([
            'user_id' => auth()->id(),
            'application_id' => $this->application->id,
            'title' => $this->application->title . ' #' . $number
        ]);
        $this->redirectRoute('chats.view', ['id' => $chat->id], true, true);
    }

    protected function filterByOwner(Builder $query): Builder
    {
        return $query;
    }

    protected function modifyQuery(Builder $query): Builder
    {
        return $query->where('is_public', true)
            ->with('image');
    }
}
