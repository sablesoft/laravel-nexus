<div class="mb-4">
    @livewire('mask-selector', ['maskIds' => $this->maskIds(), 'isOwner' => $this->isOwner()])
    @if($this->canAddCharacter())
        <div class="flex justify-end">
            <flux:button variant="primary" wire:click="character" class="cursor-pointer">
                {{ __('Add') }}
            </flux:button>
        </div>
    @endif

    <div class="mt-2 space-y-2">
        @php
            $cols = 4;
            if ($chat) $cols++;
            if (!$this->isStarted()) $cols++;
        @endphp
        @switch($cols)
            @case(4) @php $grid = 'grid-cols-[8rem_8rem_8rem_1fr]'; @endphp @break
            @case(5) @php $grid = 'grid-cols-[8rem_8rem_8rem_1fr_8rem]'; @endphp @break
            @case(6) @php $grid = 'grid-cols-[8rem_8rem_8rem_1fr_10rem_8rem]'; @endphp @break
        @endswitch
        @if($characters->isNotEmpty())
            {{-- Header --}}
            <div class="grid {{ $grid }} gap-4 font-bold text-sm text-zinc-600 dark:text-zinc-300 bg-zinc-100 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-md px-4 py-2">
                <span>{{ __('Image') }}</span>
                <span>{{ __('Name') }}</span>
                <span>{{ __('Roles') }}</span>
                <span>{{ __('Description') }}</span>
                @if($chat)
                    <span>{{ __('Player') }}</span>
                @endif
                @if(!$this->isStarted())
                    <span>{{ __('Actions') }}</span>
                @endif
            </div>
        @else
            <p>{{ __('No characters so far') }}</p>
        @endif

        @foreach($characters as $character)
            <div class="grid {{ $grid }} gap-4 items-center bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-md px-4 py-2 text-sm">
                {{-- Image --}}
                <div class="flex items-center">
                    <img src="{{ Storage::url($character->mask->imagePath) }}" alt="{{ $character->mask->title }}"
                         class="h-32 w-32 rounded object-cover border border-zinc-300 dark:border-zinc-600 cursor-pointer"
                         wire:click="showMask({{ $character->mask_id }})">
                </div>

                {{-- Name --}}
                <div>{{ $character->mask->title }}</div>

                {{-- Roles --}}
                <div>
                    @if($character->roles->isNotEmpty())
                    <ul>
                    @foreach($character->roles as $role)
                        <li>
                            <span>{{ $role->name }}</span>
                            <flux:tooltip toggleable>
                                <flux:button icon="information-circle" size="xs" variant="ghost" class="cursor-pointer" />
                                <flux:tooltip.content class="max-w-[20rem] space-y-1 whitespace-pre-wrap">{!! nl2br(e($role->description)) !!}</flux:tooltip.content>
                            </flux:tooltip>
                        </li>
                    @endforeach
                    </ul>
                    @else
                        {{ __('None') }}
                    @endif
                </div>

                {{-- Description --}}
                <div class="whitespace-pre-wrap text-zinc-700 dark:text-zinc-300">{!! nl2br(e($character->mask->description)) !!}</div>

                {{-- Player --}}
                @if($chat)
                    <div>
                        {{ $character->user ? $character->user->name : '—' }}
                        <br>
                        <span class="text-xs text-zinc-500">
                        {{ $character->is_confirmed ? __('Confirmed') : __('Not Confirmed') }}
                    </span>
                </div>
                @endif

                {{-- Actions --}}
                @if(!$this->isStarted())
                    <div>
                        <flux:button.group class="flex justify-end">
                        @if($chat)
                            @if(!$character->user && !$this->isJoined())
                            <flux:tooltip content="{{ __('Join') }}">
                                <flux:button class="cursor-pointer" size="sm" icon="arrow-left-end-on-rectangle"
                                             wire:click="join({{ $character->id }})" variant="ghost"/>
                            </flux:tooltip>
                            @endif
                            @if($character->user_id === auth()->id() && !$this->isStarted())
                            <flux:tooltip content="{{ __('Leave') }}">
                                <flux:button class="cursor-pointer" size="sm" icon="arrow-right-start-on-rectangle"
                                             wire:click="leave({{ $character->id }})" variant="ghost"/>
                            </flux:tooltip>
                            @endif
                            @if(!$character->is_confirmed && $this->isOwner())
                            <flux:tooltip content="{{ __('Confirm') }}">
                                <flux:button class="cursor-pointer" size="sm" icon="check"
                                             wire:click="confirm({{ $character->id }})" variant="primary"/>
                            </flux:tooltip>
                            @endif
                        @endif
                        @if($this->isOwner())
                            @if($application)
                            <flux:tooltip content="{{ __('Manage Roles') }}">
                                <flux:button class="cursor-pointer" size="sm" icon="user-group"
                                             wire:click="manageRoles({{ $character->id }})"/>
                            </flux:tooltip>
                            @endif
                            <flux:tooltip content="{{ __('Delete') }}">
                                <flux:button class="cursor-pointer" size="sm" icon="trash"
                                             wire:click="deleteCharacter({{ $character->id }})" variant="danger"/>
                            </flux:tooltip>
                        @endif
                        </flux:button.group>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <flux:modal name="show-mask" x-on:cancel="$wire.mask = null;">
        <div class="space-y-6">
            @if($mask?->imagePath)
            <img src="{{ Storage::url($mask?->imagePath) }}" alt="{{ $mask?->title }}" class="w-full object-cover">
            @endif
            <div>
                <flux:heading size="lg">
                    {{ $mask?->title }}
                </flux:heading>
                <flux:subheading>
                    {{ $mask?->description }}
                </flux:subheading>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost" class="cursor-pointer">
                        {{ __('Close') }}
                    </flux:button>
                </flux:modal.close>
            </div>
        </div>
    </flux:modal>

    <flux:modal name="form-chat-roles"
                class="!max-w-4xl min-w-xl">
        <div class="space-y-4">
            <flux:heading>{{ __('Manage Roles') }}</flux:heading>

            <flux:field class="mb-3">
                <flux:label>{{ __('Select Role') }}</flux:label>
                <div>
                    <x-searchable-multi-select field="roles" :options="$selectRoles"/>
                </div>
                <flux:error name="state.roles"/>
            </flux:field>

            <div class="flex gap-2">
                <flux:spacer/>
                <flux:modal.close>
                    <flux:button variant="ghost" class="cursor-pointer">
                        {{ __('Close') }}
                    </flux:button>
                </flux:modal.close>
                <flux:button wire:click="submitRoles" variant="primary" class="cursor-pointer">
                    {{ __('Submit') }}
                </flux:button>
            </div>
        </div>
    </flux:modal>
</div>
