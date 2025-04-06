<div>

    {{-- Modal Form --}}
    <div class="flex justify-end mb-2">
        <flux:button variant="primary" wire:click="addRole" class="cursor-pointer">Add Role</flux:button>
    </div>
    <flux:modal name="form-group-{{ $groupId }}-role"
                x-on:cancel="$wire.resetForm()"
                x-on:close="$wire.resetForm()" class="!max-w-4xl min-w-xl">
        <div class="space-y-4">
            <flux:heading>{{ $this->groupRoleId ? __('Edit Group Role') : __('Create Group Role') }}</flux:heading>

            <flux:field class="mb-3">
                <flux:label>Role</flux:label>
                <div wire:key="{{ $selectKey }}">
                    <x-searchable-select field="role_id" :options="$roles" :key="'ForGroup'. $groupId"/>
                </div>
                <flux:error name="state.role_id"/>
            </flux:field>

            <flux:field class="mb-3">
                <flux:label>Name</flux:label>
                <flux:input wire:model="state.name"/>
                <flux:error name="state.name"/>
            </flux:field>

            <flux:field class="mb-3">
                <flux:label>Description</flux:label>
                <flux:textarea wire:model="state.description" rows="auto"></flux:textarea>
                <flux:error name="state.description"/>
            </flux:field>

            <flux:field class="mb-3">
                <flux:label>Limit</flux:label>
                <flux:input type="number" step="1" wire:model="state.limit"/>
                <flux:error name="state.limit"/>
            </flux:field>

            {{-- Behaviors --}}
            <flux:field class="mb-3">
                <flux:label>Behaviors ({{ config('dsl.editor', 'yaml') }})</flux:label>
                <x-code-mirror wire:key="{{ $codeMirrorPrefix }}.behaviorsString"
                               :lang="config('dsl.editor', 'yaml')"
                               :content="$state['behaviorsString'] ?? ''"
                               wire:model.defer="state.behaviorsString" class="w-full" />
                <flux:error name="state.behaviorsString"/>
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

    {{-- Group Roles List --}}
    <div class="space-y-2">
        @if($groupRoles)
            <div
                class="grid grid-cols-4 gap-4 font-bold text-sm text-zinc-600 dark:text-zinc-300 bg-zinc-100 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-md px-4 py-2">
                <span>Role</span>
                <span>Name</span>
                <span>Limit</span>
                <span class="text-right">Actions</span>
            </div>
        @endif

        @foreach($groupRoles as $id => $groupRole)
            <div x-data="{ open: false }"
                 class="bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-md shadow transition-all duration-300">
                {{-- Row --}}
                <div class="grid grid-cols-4 gap-4 items-center px-4 py-3 hover:bg-zinc-50 dark:hover:bg-zinc-700">
                    <span class="text-sm font-medium text-zinc-800 dark:text-zinc-100">
                        <a class="underline" wire:click.stop wire:navigate
                           href="{{ route('workshop.roles', ['action' => 'view', 'id' => $groupRole['role_id']]) }}">
                            {{ $groupRole['roleName'] }}
                        </a>
                    </span>
                    <span class="text-sm text-zinc-600 dark:text-zinc-300">
                        {{ $groupRole['name'] }}
                    </span>
                    <span class="text-sm text-zinc-500 dark:text-zinc-400">
                        {{ $groupRole['limit'] }}
                    </span>

                    {{-- Expand toggle + actions --}}
                    <div class="flex justify-end gap-2">
                        <flux:button x-show="open" size="sm" icon="chevron-up"
                                     @click="open = !open" class="cursor-pointer"/>
                        <flux:button x-show="!open" size="sm" icon="chevron-down"
                                     @click="open = !open" class="cursor-pointer"/>
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
                        <pre class="bg-zinc-100 dark:bg-zinc-800 p-2 rounded text-xs overflow-auto whitespace-pre-wrap">
                            {!! e($groupRole['description']) !!}
                        </pre>
                    </div>
                    @if($groupRole['behaviorsString'])
                        <div class="mb-3">
                            <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400">Behaviors ({{ config('dsl.editor', 'yaml') }})</label>
                            <x-code-mirror wire:key="codemirror-before-{{ uuid_create() }}"
                                           :lang="config('dsl.editor', 'yaml')"
                                           :readonly="true"
                                           :content="$groupRole['behaviorsString']"
                                           class="w-full" />
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

</div>
