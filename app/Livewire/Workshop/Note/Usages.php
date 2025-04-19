<?php
/** @noinspection PhpUndefinedMethodInspection */

namespace App\Livewire\Workshop\Note;

use App\Models\Interfaces\HasNotesInterface;
use App\Models\Note;
use Flux\Flux;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Usages extends Component
{
    #[Locked]
    public string $key;

    public HasNotesInterface $model;

    public array $usages = [];
    public array $selectNotes = [];

    public string $action = 'create';
    public ?int $noteId = null;
    public array $state = [
        'note_id' => null,
        'code' => '',
        'content' => ''
    ];

    public function mount(HasNotesInterface $model): void
    {
        $this->model = $model;
        $this->usages = $this->model->notes
            ->mapWithKeys(fn(Note $note) => [
                $note->id => [
                    'note_id' => $note->id,
                    'code' => $note->pivot->code,
                    'title' => $note->title,
                    'content' => $note->content
                ]
            ])->toArray();
        $this->selectNotes = Note::query()
            ->orderByDesc('id')
            ->limit(50)
            ->get()
            ->map(fn(Note $note) => [
                'id' => $note->id,
                'name' => $note->title
            ])->toArray();
        $this->key = strtolower(class_basename($this->model)) . $this->model->getKey();
    }

    public function edit(int $noteId): void
    {
        $this->noteId = $noteId;
        $usage = $this->usages[$noteId] ?? null;
        if ($usage) {
            $this->state = Arr::only($usage, ['note_id', 'code', 'content']);
        }
        $this->dispatch("state.note_id-updated-{$this->key}", value: $this->noteId);
        Flux::modal('form-note-usage-' . $this->key)->show();
    }

    public function delete(int $noteId): void
    {
        $this->model->notes()->wherePivot('note_id', $noteId)->detach();
        unset($this->usages[$noteId]);
        $this->resetForm();
    }

    public function submit(): void
    {
        $validated = $this->validate([
            'state.note_id' => ['required', Rule::exists('notes', 'id')],
            'state.code' => ['required', 'string'],
        ])['state'];

        if ($this->noteId) {
            $this->model->notes()->wherePivot('note_id', $this->noteId)->detach();
        }

        $this->model->notes()->attach($validated['note_id'], [
            'code' => $validated['code']
        ]);

        $this->resetForm();
        $this->mount($this->model); // перезагрузить usages
        Flux::modal('form-note-usage-'. $this->key)->close();
        $this->dispatch('flash', message: __('Note attached.'));
    }

    public function resetForm(): void
    {
        $this->action = 'create';
        $this->noteId = null;
        $this->state = [
            'note_id' => null,
            'code' => '',
            'content' => ''
        ];
        $this->dispatch("state.note_id-updated-{$this->key}", value: null);
    }

    public function render(): mixed
    {
        return view('livewire.workshop.note.usages');
    }
}
