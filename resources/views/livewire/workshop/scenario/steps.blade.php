<div>

    {{-- Modal Form --}}
    <div class="flex justify-end mb-2">
        <flux:modal.trigger name="form-step">
            <flux:button variant="primary" class="cursor-pointer">Add Step</flux:button>
        </flux:modal.trigger>
    </div>
    <flux:modal name="form-step"
                x-on:cancel="$wire.resetForm()"
                x-on:close="$wire.resetForm()" class="!max-w-4xl min-w-xl">
        <div class="space-y-4">
            <flux:heading>{{ $this->stepId ? __('Edit Step') : __('Create Step') }}</flux:heading>

            <flux:field>
                <flux:label class="cursor-pointer">Logic</flux:label>
                <div class="flex gap-2">
                    <ui-label
                        class="cursor-pointer text-sm text-zinc-800 dark:text-white {{ $switcher ? '' : 'font-black' }}">
                        Command
                    </ui-label>
                    <flux:switch class="cursor-pointer" wire:model.live="switcher"/>
                    <ui-label
                        class="cursor-pointer text-sm text-zinc-800 dark:text-white {{ !$switcher ? '' : 'font-black' }}">
                        Scenario
                    </ui-label>
                </div>
            </flux:field>
            <flux:field class="mb-3">
                @if($switcher)
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

            <flux:field class="mb-3">
                <flux:label>Active (JSON)</flux:label>
                <flux:textarea wire:model="state.active" rows="auto"></flux:textarea>
                <flux:error name="state.active"/>
            </flux:field>
            <flux:field class="mb-3">
                <flux:label>Constants (JSON)</flux:label>
                <flux:textarea wire:model="state.constants" rows="auto"></flux:textarea>
                <flux:error name="state.constants"/>
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
                $logicTitle = $isScenario
                    ? 'Scenario: ' . ($step['nestedTitle'] ?? '—')
                    : 'Command: ' . ($step['commandTitle'] ?? '—');
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

                        {{-- Column 3: Expand toggle --}}
                        <button class="cursor-pointer text-right text-sm text-zinc-400 dark:text-zinc-500 hover:text-zinc-600 dark:hover:text-zinc-300"
                                @click="open = !open">
                            <span x-text="open ? '▲' : '▼'"></span>
                        </button>

                        {{-- Column 4: Controls --}}
                        <div class="flex justify-end gap-2">
                            <flux:button wire:click.stop="moveUp({{ $id }})" variant="ghost" class="cursor-pointer">
                                ↑
                            </flux:button>
                            <flux:button wire:click.stop="moveDown({{ $id }})" variant="ghost" class="cursor-pointer">
                                ↓
                            </flux:button>
                            <flux:button wire:click.stop="edit({{ $id }})" variant="primary" class="cursor-pointer">
                                Edit
                            </flux:button>
                            <flux:button wire:click.stop="delete({{ $id }})" variant="danger" class="cursor-pointer">
                                Delete
                            </flux:button>
                        </div>
                    </div>

                    {{-- Expandable section --}}
                    <div x-show="open" x-transition class="px-6 pb-4 pt-2 text-sm text-zinc-700 dark:text-zinc-300">
                        <div class="mb-3">
                            <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400">Active (JSON)</label>
                            <pre class="bg-zinc-100 dark:bg-zinc-800 p-2 rounded text-xs overflow-auto">
                                {{ $step['active'] ?? '--- empty ---' }}
                            </pre>
                        </div>

                        <div class="mb-3">
                            <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400">Constants (JSON)</label>
                            <pre class="bg-zinc-100 dark:bg-zinc-800 p-2 rounded text-xs overflow-auto">
                                {{ $step['constants'] ?? '--- empty ---' }}
                            </pre>
                        </div>
                    </div>
                </div>

            @endforeach
    </div>

</div>
