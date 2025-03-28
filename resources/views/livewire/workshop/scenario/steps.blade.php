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
                <flux:label>Description</flux:label>
                <flux:textarea wire:model="state.description" rows="auto"></flux:textarea>
                <flux:error name="state.description"/>
            </flux:field>
            <flux:field>
                <div class="flex gap-2">
                    <flux:switch label="Add Logic" class="cursor-pointer" wire:model.live="addLogic"/>
                </div>
            </flux:field>
            @if($addLogic)
                <flux:field>
                    <div class="flex gap-2">
                        <ui-label
                            class="cursor-pointer text-sm text-zinc-800 dark:text-white {{ $scenarioLogic ? '' : 'font-black' }}">
                            Command
                        </ui-label>
                        <flux:switch class="cursor-pointer" wire:model.live="scenarioLogic"/>
                        <ui-label
                            class="cursor-pointer text-sm text-zinc-800 dark:text-white {{ !$scenarioLogic ? '' : 'font-black' }}">
                            Scenario
                        </ui-label>
                    </div>
                </flux:field>
                <flux:field class="mb-3">
                    @if($scenarioLogic)
                        <x-searchable-select field="nested_id" :options="$scenarios"/>
                        <flux:error name="state.nested_id"/>
                    @else
                        <flux:select wire:model="state.command" class="cursor-pointer">
                            <flux:select.option selected>Not selected</flux:select.option>
                            @foreach (\App\Models\Enums\Command::options() as $value => $title)
                                <flux:select.option value="{{ $value }}">
                                    {{ $title }}
                                </flux:select.option>
                            @endforeach
                        </flux:select>
                        <flux:error name="state.command"/>
                    @endif
                </flux:field>
            @endif
            <flux:field class="mb-3">
                <flux:label>Before ({{ config('dsl.editor', 'yaml') }})</flux:label>
                <x-code-mirror wire:key="codemirror-editor-beforeString"
                               :lang="config('dsl.editor', 'yaml')"
                               wire:model.defer="state.beforeString" class="w-full" />
                <flux:error name="state.beforeString"/>
            </flux:field>
            <flux:field class="mb-3">
                <flux:label>After ({{ config('dsl.editor', 'yaml') }})</flux:label>
                <x-code-mirror wire:key="codemirror-editor-afterString"
                               :lang="config('dsl.editor', 'yaml')"
                               wire:model.defer="state.afterString" class="w-full" />
                <flux:error name="state.afterString"/>
            </flux:field>

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
        <div class="grid grid-cols-3 gap-4 font-bold text-sm text-zinc-600 dark:text-zinc-300 bg-zinc-100 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-md px-4 py-2">
            <span>Number</span>
            <span>Logic</span>
            <span class="text-right">Details</span>
        </div>
        @endif

        @foreach($steps as $id => $step)
        @php
            $isScenario = !empty($step['nested_id']);
            $isCommand = !empty($step['command']);
            $logicTitle = ($isCommand || $isScenario) ? null : 'None';
            $logicTitle = $logicTitle ?? ($isScenario
                ? 'Scenario: ' . ($step['nestedTitle'] ?? '—')
                : 'Command: ' . ($step['commandTitle'] ?? '—'));
        @endphp

        <div x-data="{ open: false }" class="bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-md shadow transition-all duration-300">
            {{-- Row --}}
            <div class="grid grid-cols-4 gap-4 items-center px-4 py-3 hover:bg-zinc-50 dark:hover:bg-zinc-700">
                {{-- Column 1: Number --}}
                <span class="text-sm font-medium text-zinc-800 dark:text-zinc-100">
                    {{ $step['number'] }}
                </span>

                {{-- Column 2: Logic --}}
                <span class="text-sm text-zinc-600 dark:text-zinc-300">
                    @if($isScenario)
                    <a class="underline" wire:click.stop wire:navigate
                       href="{{ route('workshop.scenarios', ['action' => 'view', 'id' => $step['nested_id']]) }}">
                        {{ $logicTitle }}
                    </a>
                    @else
                        {{ $logicTitle }}
                    @endif
                </span>

                {{-- Column 3: Controls --}}
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
                    <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400">Description</label>
                    <p>{!! e($step['description']) !!}</p>
                </div>
                <x-setup-view :before-string="$step['beforeString']" :after-string="$step['afterString']"/>
            </div>
        </div>

        @endforeach
    </div>

</div>
