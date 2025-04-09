<div>

    {{-- Modal Form --}}
    <div class="flex justify-end">
        <flux:modal.trigger name="form-group">
            <flux:button variant="primary" class="cursor-pointer">Add Group</flux:button>
        </flux:modal.trigger>
    </div>
    <flux:modal name="form-group"
                x-on:cancel="$wire.resetForm()"
                x-on:close="$wire.resetForm()" class="!max-w-4xl min-w-xl">
        <div class="space-y-4">
            <flux:heading>{{ $this->groupId ? __('Edit Group') : __('Create Group') }}</flux:heading>
            <flux:field class="mb-3">
                <flux:label>Name</flux:label>
                <flux:input wire:model="state.name"></flux:input>
                <flux:error name="state.name"/>
            </flux:field>
            <flux:field class="mb-3">
                <flux:label>Description</flux:label>
                <flux:textarea wire:model="state.description" rows="auto"></flux:textarea>
                <flux:error name="state.description"/>
            </flux:field>
            <flux:field class="mb-3">
                <flux:label>Roles Per Member</flux:label>
                <flux:input type="number" min="0" step="1" wire:model="state.roles_per_member"></flux:input>
                <flux:error name="state.roles_per_member"/>
            </flux:field>
            <flux:field class="mb-3">
                <flux:switch label="Is Required" class="cursor-pointer" wire:model="state.is_required"/>
                <flux:error name="state.is_required"/>
            </flux:field>
            <flux:field class="mb-3">
                <flux:label>Allowed</flux:label>
                <flux:textarea wire:model="state.allowed" rows="auto"></flux:textarea>
                <flux:error name="state.allowed"/>
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

    {{-- Groups List --}}
    <div class="space-y-2 mt-3">
        @if($groups)
            {{-- Table header --}}
            <div class="grid grid-cols-5 gap-4 font-bold text-sm text-zinc-600 dark:text-zinc-300 bg-zinc-100 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-md px-4 py-2">
                <span>Number</span>
                <span>Name</span>
                <span>Is Required</span>
                <span>Roles Per Member</span>
                <span class="text-right">Details</span>
            </div>
        @endif

        @foreach($groups as $id => $group)
            <div x-data="{ open: false }" class="bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-md shadow transition-all duration-300">
                {{-- Row --}}
                <div class="grid grid-cols-5 gap-4 items-center px-4 py-3 hover:bg-zinc-50 dark:hover:bg-zinc-700">
                    {{-- Column 1: Number --}}
                    <span class="text-sm font-medium text-zinc-800 dark:text-zinc-100">
                    {{ $group['number'] }}
                    </span>

                    {{-- Column 2: Name --}}
                    <span class="text-sm text-zinc-600 dark:text-zinc-300">
                    {{ $group['name'] }}
                    </span>

                    {{-- Column 3: Is Required --}}
                    <span class="text-sm text-zinc-600 dark:text-zinc-300">
                     {{ $group['is_required'] ? 'Yes' : 'No' }}
                    </span>

                    {{-- Column 3: Roles Per Member --}}
                    <span class="text-sm text-zinc-600 dark:text-zinc-300">
                     {{ $group['roles_per_member'] }}
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
                        <p>{!! e($group['description']) !!}</p>
                    </div>
                    @if($group['allowed'])
                        <div class="mb-3">
                            <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400">Allowed</label>
                            <span class="text-sm text-zinc-600 dark:text-zinc-300">
                            {!! e($group['allowed']) !!}
                            </span>
                        </div>
                    @endif
                    <livewire:workshop.application.group-roles
                        :application-id="$applicationId"
                        :roles="$roles"
                        :group-id="$group['id']"
                        :key="'group-roles-'.$group['id']" />
                </div>
            </div>

        @endforeach
    </div>

</div>
