<div>
    {{-- Add Note Button --}}
    <div class="flex justify-end mb-2">
        <flux:modal.trigger name="form-note-usage-{{ $key }}">
            <flux:button icon="plus-circle" variant="primary" class="cursor-pointer">
                {{ __('Add Note') }}
            </flux:button>
        </flux:modal.trigger>
    </div>

    {{-- Modal Form --}}
    <flux:modal name="form-note-usage-{{ $key }}" class="!max-w-2xl min-w-xl"
                x-on:cancel="$wire.resetForm()"
                x-on:close="$wire.resetForm()">
        <div class="space-y-4">
            <flux:heading>
                {{ $noteId ? __('Edit Note Usage') : __('Attach Note') }}
            </flux:heading>

            @if(!$noteId)
            <flux:field class="mb-3">
                <flux:switch label="{{ __('Create Note') }}" class="cursor-pointer" wire:model.live="createNote"/>
            </flux:field>
            @endif

            @if(!$createNote)
            <flux:field class="mb-3">
                <flux:label>{{ __('Select Note') }}</flux:label>
                <x-searchable-select field="state.note_id" :key="$key" :options="$selectNotes" />
                <flux:error name="state.note_id" />
            </flux:field>
            @endif

            <flux:field class="mb-3">
                <flux:label>{{ __('Code') }}</flux:label>
                <!--suppress RequiredAttributes -->
                <flux:input required type="text" wire:model.defer="state.code" />
                <flux:error name="state.code" />
            </flux:field>

            <flux:field class="mb-3">
                <flux:label>{{ __('Title') }}</flux:label>
                <!--suppress RequiredAttributes -->
                <flux:input required type="text" wire:model.defer="state.title" />
                <flux:error name="state.title" />
            </flux:field>

            <flux:field class="mb-3">
                <flux:label>{{ __('Content') }}</flux:label>
                <!--suppress RequiredAttributes -->
                <flux:textarea required wire:model.defer="state.content" />
                <flux:error name="state.content" />
            </flux:field>

            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost" class="cursor-pointer">
                        {{ __('Close') }}
                    </flux:button>
                </flux:modal.close>
                <flux:button wire:click="submit" variant="primary" class="cursor-pointer">
                    {{ __('Submit') }}
                </flux:button>
            </div>
        </div>
    </flux:modal>

    {{-- Notes Table Header --}}
    @if($usages)
        <div class="grid grid-cols-3 gap-4 font-bold text-sm text-zinc-600 dark:text-zinc-300 bg-zinc-100 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-md px-4 py-2">
            <span>{{ __('Title') }}</span>
            <span>{{ __('Code') }}</span>
            <span class="text-right">{{ __('Actions') }}</span>
        </div>
        {{-- Notes Table Rows --}}
        <div class="space-y-2 mt-2">
            @foreach($usages as $id => $usage)
                <div x-data="{ open: false }" class="bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-md shadow">
                    <div class="grid grid-cols-3 gap-4 items-center px-4 py-2">
                        <a class="text-sm underline font-semibold text-zinc-800 dark:text-zinc-100" wire:click.stop wire:navigate
                           href="{{ route('workshop.notes', ['action' => 'view', 'id' => $id]) }}">
                            {{ $usage['title'] }}
                        </a>
                        <span class="text-sm text-zinc-600 dark:text-zinc-300">{{ $usage['code'] }}</span>
                        <div class="flex justify-end gap-2">
                            <flux:button x-show="!open" size="sm" icon="chevron-down" @click="open = true" class="cursor-pointer" />
                            <flux:button x-show="open" size="sm" icon="chevron-up" @click="open = false" class="cursor-pointer" />
                            <flux:button size="sm" icon="pencil-square" wire:click.stop="edit({{ $id }})" variant="primary" class="cursor-pointer" />
                            <flux:button size="sm" icon="trash" wire:click.stop="delete({{ $id }})" variant="danger" class="cursor-pointer" />
                        </div>
                    </div>
                    <div x-show="open" x-transition class="px-6 pb-4 pt-2 text-sm text-zinc-700 dark:text-zinc-300">
                        <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400">{{ __('Content') }}</label>
                        <pre class="whitespace-pre-wrap text-left font-sans mt-1 bg-zinc-100 dark:bg-zinc-800 px-3 py-2 rounded">{{ $usage['content'] }}</pre>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>{{ __('No attached notes') }}</p>
    @endif
</div>
