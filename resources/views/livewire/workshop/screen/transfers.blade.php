<div>
    <div class="flex justify-end">
        <flux:modal.trigger name="select-screen">
            <flux:button size="sm" variant="primary" icon="plus-circle" class="cursor-pointer"/>
        </flux:modal.trigger>
    </div>
    <flux:modal name="select-screen"
                x-on:cancel="$wire.resetFilters()"
                x-on:close="$wire.resetFilters()" class="!max-w-4xl">
        <div class="space-y-6">
            <x-crud.control/>
            <div class="my-2">
                {{ $models->links() }}
            </div>
            <div class="overflow-auto max-h-164 mt-4">
                <div class="grid grid-cols-5 gap-4">
                    @foreach($models as $model)
                        <div class="relative group cursor-pointer"
                             wire:click="selectScreen({{ $model->id }}); $flux.modal('select-screen').close()">
                            @php
                                /** @var \App\Models\Screen $model */
                                $src = $model->imageUrlMd;
                            @endphp
                            @if($src)
                                <img src="{{ $src }}" alt="{{ $model->title }}" class="w-full h-full object-cover rounded-lg">
                            @else
                                <span class="text-gray-500">{{ __('No Image') }}</span>
                            @endif
                            <div class="cursor-pointer absolute inset-0 bg-black bg-opacity-30 opacity-0 group-hover:opacity-70 transition-opacity flex items-center justify-center">
                                <span variant="ghost" class="text-white text-center cursor-pointer">{{ $model->title }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </flux:modal>
    <flux:modal name="form-transfer"
                x-on:cancel="$wire.resetForm()"
                x-on:close="$wire.resetForm()" class="!max-w-4xl min-w-xl">
        <div class="space-y-4">
            <flux:heading>{{ $this->transferId ? __('Edit Transfer To') : __('Create Transfer To') }}</flux:heading>
            <div class="flex items-center gap-3">
                <img :src="'{{ $state['imageUrlSm'] ?? '' }}'" alt="{{ __('Screen Image') }}"
                     class="size-12 rounded object-cover border border-zinc-300 dark:border-zinc-600">
                <span class="font-semibold text-zinc-800 dark:text-zinc-100">{{ $state['screenTitle'] ?? ''}}</span>
            </div>
            <flux:field class="mb-3">
                <flux:label>{{ __('Title') }}</flux:label>
                <flux:input type="text" wire:model="state.title"/>
                <flux:error name="state.title"/>
            </flux:field>
            <flux:field class="mb-3">
                <flux:label>{{ __('Tooltip') }}</flux:label>
                <flux:textarea wire:model="state.tooltip" rows="auto"></flux:textarea>
                <flux:error name="state.tooltip"/>
            </flux:field>
            <flux:field class="mb-3">
                <flux:label>{{ __('Description') }}</flux:label>
                <flux:textarea wire:model="state.description" rows="auto"></flux:textarea>
                <flux:error name="state.description"/>
            </flux:field>
            <flux:field class="mb-3">
                <flux:label>{{ __('Visible Condition') }}</flux:label>
                <flux:textarea wire:model="state.visible_condition" rows="auto"></flux:textarea>
                <flux:error name="state.visible_condition"/>
            </flux:field>
            <flux:field class="mb-3">
                <flux:label>{{ __('Enabled Condition') }}</flux:label>
                <flux:textarea wire:model="state.enabled_condition" rows="auto"></flux:textarea>
                <flux:error name="state.enabled_condition"/>
            </flux:field>
            <flux:field class="mb-3">
                <flux:label>{{ __('Effects') }} ({{ config('dsl.editor', 'yaml') }})</flux:label>
                <x-code-mirror wire:key="{{ $codeMirrorPrefix }}.beforeString"
                               :lang="config('dsl.editor', 'yaml')"
                               wire:model.defer="state.beforeString" class="w-full" />
                <flux:error name="state.beforeString"/>
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

    <div class="mt-6 space-y-2">
        @if($transfers)
            {{-- Table header --}}
            <div class="grid grid-cols-4 gap-4 font-bold text-sm text-zinc-600 dark:text-zinc-300 bg-zinc-100 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-md px-4 py-2">
                <span>{{ __('Screen') }}</span>
                <span>{{ __('Title') }}</span>
                <span>{{ __('Tooltip') }}</span>
                <span class="text-right">{{ __('Actions') }}</span>
            </div>
        @endif

        @foreach($transfers as $id => $transfer)
            <div x-data="{ open: false }" class="bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-md shadow transition-all duration-300">
                {{-- Row --}}
                <div
                    class="grid grid-cols-4 gap-3 items-center px-3 py-2 cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-700"
                    @click="open = !open">
                    <div class="flex items-center gap-3">
                        <img :src="'{{ $transfer['imageUrlSm'] ?? '' }}'" alt="{{ __('Screen Image') }}"
                             class="size-12 rounded object-cover border border-zinc-300 dark:border-zinc-600">
                        <a class="underline font-semibold text-zinc-800 dark:text-zinc-100" wire:click.stop wire:navigate
                           href="{{ route('workshop.screens', ['action' => 'view', 'id' => $transfer['screen_to_id']]) }}">
                            {{ $transfer['screenTitle'] }}
                        </a>
                    </div>
                    <span class="text-sm text-zinc-600 dark:text-zinc-300">{{ $transfer['title'] ?? '—' }}</span>
                    <span class="text-sm text-zinc-500 dark:text-zinc-400">{{ $transfer['tooltip'] ?? '—' }}</span>
                    <div class="flex justify-end gap-2">
                        <flux:button x-show="open" size="sm" icon="chevron-up" variant="ghost"
                                     @click.stop="open = !open" class="cursor-pointer"/>
                        <flux:button x-show="!open" size="sm" icon="chevron-down" variant="ghost"
                                     @click.stop="open = !open" class="cursor-pointer"/>
                        <flux:button size="sm" icon="pencil-square" wire:click.stop="edit({{ $id }})"
                                     variant="primary" class="cursor-pointer"/>
                        <flux:button size="sm" icon="trash" wire:click.stop="delete({{ $id }})"
                                     variant="danger" class="cursor-pointer"/>
                    </div>
                </div>

                {{-- Expandable form --}}
                <div x-show="open" x-transition class="px-6 pb-4 pt-2 text-sm text-zinc-700 dark:text-zinc-300">
                    <div class="mb-3">
                        <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400">{{ __('Description') }}</label>
                        <pre class="whitespace-pre-wrap text-left font-sans mt-1 bg-zinc-100 dark:bg-zinc-800">{!! e($transfer['description']) !!}</pre>
                    </div>
                    @if(!empty($transfer['visible_condition']))
                    <div class="mb-3">
                        <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400">{{ __('Visible Condition') }}</label>
                        <pre class="whitespace-pre-wrap mt-1 bg-zinc-100 dark:bg-zinc-800 rounded px-2 py-1 text-sm font-mono text-zinc-700 dark:text-zinc-200 border border-zinc-200 dark:border-zinc-700">{!! e($transfer['visible_condition']) !!}</pre>
                    </div>
                    @endif
                    @if(!empty($transfer['enabled_condition']))
                    <div class="mb-3">
                        <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400">{{ __('Enabled Condition') }}</label>
                        <pre class="whitespace-pre-wrap mt-1 bg-zinc-100 dark:bg-zinc-800 rounded px-2 py-1 text-sm font-mono text-zinc-700 dark:text-zinc-200 border border-zinc-200 dark:border-zinc-700">{!! e($transfer['enabled_condition']) !!}</pre>
                    </div>
                    @endif
                    <x-effects-view :before-string="$transfer['beforeString']"/>
                    @if($transfer['beforeString'])
                        <livewire:workshop.note.usages :model="$this->model($id)" />
                    @endif
                </div>
            </div>
        @endforeach
    </div>

</div>
