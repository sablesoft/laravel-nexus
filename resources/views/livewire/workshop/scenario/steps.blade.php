<div>

    {{-- Modal Form --}}
    <div class="flex justify-end mb-2">
        <flux:modal.trigger name="form-step">
            <flux:button icon="plus-circle" variant="primary" class="cursor-pointer"/>
        </flux:modal.trigger>
    </div>
    <flux:modal name="form-step"
                x-on:cancel="$wire.resetForm()"
                x-on:close="$wire.resetForm()" class="!max-w-4xl min-w-xl">
        <div class="space-y-4">
            <flux:heading>{{ $this->stepId ? __('Edit Step') : __('Create Step') }}</flux:heading>
            <flux:field class="mb-3">
                <flux:label>{{ __('Name') }}</flux:label>
                <flux:input wire:model="state.name"/>
                <flux:error name="state.name"/>
            </flux:field>
            <flux:field class="mb-3">
                <flux:label>{{ __('Description') }}</flux:label>
                <flux:textarea wire:model="state.description" rows="auto"></flux:textarea>
                <flux:error name="state.description"/>
            </flux:field>

            {{-- Effects --}}
            <flux:field class="mb-3">
                <flux:label>{{ __('Effects') }} ({{ config('dsl.editor', 'yaml') }})</flux:label>
                <x-code-mirror wire:key="{{ $codeMirrorPrefix }}.beforeString"
                               :lang="config('dsl.editor', 'yaml')"
                               wire:model.defer="state.beforeString" class="w-full" />
                <flux:error name="state.beforeString"/>
            </flux:field>

            {{-- Logic --}}
            <flux:field>
                <div class="flex gap-2">
                    <flux:switch label="{{ __('Add Logic') }}" class="cursor-pointer" wire:model.live="addLogic"/>
                </div>
            </flux:field>
            @if($addLogic)
                <flux:field class="mb-3">
                    <x-searchable-select field="state.scenario_id" :options="$scenarios"/>
                    <flux:error name="state.scenario_id"/>
                </flux:field>

                {{-- Effects After --}}
                <flux:field class="mb-3">
                    <flux:label>{{ __('Effects After') }} ({{ config('dsl.editor', 'yaml') }})</flux:label>
                    <x-code-mirror wire:key="{{ $codeMirrorPrefix }}.afterString"
                                   :lang="config('dsl.editor', 'yaml')"
                                   wire:model.defer="state.afterString" class="w-full" />
                    <flux:error name="state.afterString"/>
                </flux:field>
            @endif

            <div class="flex gap-2">
                <flux:spacer/>
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

    {{-- Steps List --}}
    <div class="space-y-2 mt-6">
        @if($steps)
        {{-- Table header --}}
        <div class="grid grid-cols-4 gap-4 font-bold text-sm text-zinc-600 dark:text-zinc-300 bg-zinc-100 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-md px-4 py-2">
            <span>{{ __('Number') }}</span>
            <span>{{ __('Name') }}</span>
            <span>{{ __('Logic') }}</span>
            <span class="text-right">{{ __('Details') }}</span>
        </div>
        @endif

        @foreach($steps as $id => $step)
        @php
            $hasScenario = !empty($step['scenario_id']);
            $logicTitle = $hasScenario ? $step['scenarioTitle'] : 'None';
        @endphp

        <div x-data="{ open: false }" class="bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-md shadow transition-all duration-300">
            {{-- Row --}}
            <div class="grid grid-cols-4 gap-4 items-center px-4 py-3 hover:bg-zinc-50 dark:hover:bg-zinc-700">
                {{-- Column 1: Number --}}
                <span class="text-sm font-medium text-zinc-800 dark:text-zinc-100">
                    {{ $step['number'] }}
                </span>

                {{-- Column 2: Name --}}
                <span class="text-sm font-medium text-zinc-800 dark:text-zinc-100">
                    {{ $step['name'] }}
                </span>

                {{-- Column 3: Logic --}}
                <span class="text-sm text-zinc-600 dark:text-zinc-300">
                    @if($hasScenario)
                    <a class="underline" wire:click.stop wire:navigate
                       href="{{ route('workshop.scenarios', ['action' => 'view', 'id' => $step['scenario_id']]) }}">
                        {{ $logicTitle }}
                    </a>
                    @else
                        {{ $logicTitle }}
                    @endif
                </span>

                {{-- Column 4: Controls --}}
                <div class="flex justify-end gap-2">
                    <flux:button x-show="open" size="sm" icon="chevron-up"
                                 @click="open = !open" class="cursor-pointer"/>
                    <flux:button x-show="!open" size="sm" icon="chevron-down"
                                 @click="open = !open" class="cursor-pointer"/>
                    <flux:button size="sm" icon="arrow-up" wire:click.stop="moveUp({{ $id }})"
                                 variant="ghost" class="cursor-pointer"/>
                    <flux:button size="sm" icon="arrow-down" wire:click.stop="moveDown({{ $id }})"
                                 variant="ghost" class="cursor-pointer"/>
                    <flux:button size="sm" icon="pencil-square" wire:click.stop="edit({{ $id }})"
                                 variant="primary" class="cursor-pointer"/>
                    <flux:button size="sm" icon="trash" wire:click.stop="delete({{ $id }})"
                                 variant="danger" class="cursor-pointer"/>
                </div>
            </div>

            {{-- Expandable section --}}
            <div x-show="open" x-transition class="px-6 pb-4 pt-2 text-sm text-zinc-700 dark:text-zinc-300">
                <div class="mb-3">
                    <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400">{{ __('Description') }}</label>
                    <p>{!! e($step['description']) !!}</p>
                </div>
                <x-effects-view :before-string="$step['beforeString']" :after-string="$step['afterString']"/>
                <livewire:workshop.note.usages :model="$this->model($id)" />
            </div>
        </div>

        @endforeach
    </div>

</div>
