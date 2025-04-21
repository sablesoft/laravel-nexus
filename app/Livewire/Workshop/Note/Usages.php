<?php
/** @noinspection PhpUndefinedMethodInspection */

namespace App\Livewire\Workshop\Note;

use App\Models\Interfaces\HasNotesInterface;
use App\Models\Note;
use Flux\Flux;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
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
    public bool $createNote = false;
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
            ->where('user_id', auth()->id())
            ->whereNotIn('id', array_keys($this->usages))
            ->limit(50)
            ->get()
            ->map(fn(Note $note) => [
                'id' => $note->id,
                'name' => $note->title
            ])->toArray();
        $this->key = strtolower(class_basename($this->model)) .
            $this->model->getKey() . 'StateNoteId';
    }

    public function updatedCreateNote(): void
    {
        if ($this->createNote) {
            $this->state['note_id'] = null;
        }
    }

    public function updatedStateNoteId(): void
    {
            /** @var Note $note */
            $note = !empty($this->state['note_id']) ?
                Note::findOrFail($this->state['note_id']) :
                null;
            $this->state['code'] = null;
            $this->state['title'] = $note?->title;
            $this->state['content'] = $note?->content;
    }

    public function edit(int $noteId): void
    {
        $this->noteId = $noteId;
        $usage = $this->usages[$noteId] ?? null;
        $options = $this->selectNotes;
        if ($usage) {
            $this->state = Arr::only($usage, ['note_id', 'code', 'title', 'content']);
            $options = array_merge($this->selectNotes,  [[
                'id' => $this->state['note_id'],
                'name' => $this->state['title']
            ]]);
        }
        $this->dispatch("state.note_id-options-{$this->key}", value: $this->noteId, options: $options);
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
        $rules = [
            'state.code' => ['required', 'string'],
            'state.title' => ['required', 'string'],
            'state.content' => ['required', 'string'],
        ];
        if (!$this->createNote) {
            $rules['state.note_id'] = ['required', Rule::exists('notes', 'id')];
        }
        $validated = $this->validate($rules)['state'];
        if ($this->noteId) {
            $this->model->notes()->wherePivot('note_id', $this->noteId)->detach();
            $note = Note::findOrFail($validated['note_id']);
            $note->update($validated);
        }
        if ($this->createNote) {
            /** @var Note $note **/
            $note = Note::create($validated);
            $validated['note_id'] = $note->getKey();
        }

        $this->model->notes()->attach($validated['note_id'], [
            'code' => $validated['code']
        ]);

        $this->resetForm();
        $this->mount($this->model); // перезагрузить usages
        Flux::modal('form-note-usage-'. $this->key)->close();
        $this->dispatch('flash', message: __('Note attached'));
    }

    public function resetForm(): void
    {
        $this->noteId = null;
        $this->createNote = false;
        $this->state = [
            'note_id' => null,
            'code' => '',
            'title' => '',
            'content' => ''
        ];
        $this->dispatch("state.note_id-options-{$this->key}", value: null);
    }

    public function render(): mixed
    {
        return view('livewire.workshop.note.usages');
    }
}
