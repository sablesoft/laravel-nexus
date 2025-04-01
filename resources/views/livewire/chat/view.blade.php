<div>
    <div class="flex flex-wrap items-center justify-between w-full mb-2">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item class="text-base!">{{ __('Chats') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item class="text-base!">{{ __('View') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item class="text-base!">{{ $chat->id }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <div class="flex justify-end space-x-2">
            <flux:button.group>
                <flux:button wire:click="close" class="cursor-pointer">
                    {{ __('Close') }}
                </flux:button>
                @if($this->canEdit())
                    <flux:button wire:click="edit" class="cursor-pointer">
                        {{ __('Edit') }}
                    </flux:button>
                    <flux:button wire:click="publish" class="cursor-pointer">
                        {{ __('Publish') }}
                    </flux:button>
                @endif
                @if($this->canAddMember())
                    <flux:button wire:click="member" class="cursor-pointer">
                        {{ __('Member') }}
                    </flux:button>
                @endif
                @if($this->canStart())
                    <flux:button wire:click="start" class="cursor-pointer">
                        {{ __('Start') }}
                    </flux:button>
                @endif
                @if($this->canPlay())
                    <flux:button wire:click="play" class="cursor-pointer">
                        {{ __('Play') }}
                    </flux:button>
                @endif
            </flux:button.group>
        </div>
    </div>
    <div class="bg-zinc-100 dark:bg-zinc-900 border-zinc-200 dark:border-zinc-700 p-4 rounded">

        <div class="mb-4">
            <h2>{{ $chat->title }}</h2>
        </div>
        @if($chat->application->imagePath)
        <div class="mt-4">
            <img src="{{ Storage::url($chat->application->imagePath) }}" alt="Image"
                 class="mt-2 rounded-lg shadow-lg w-96">
        </div>
        @endif

        <div class="mb-4">
            <h3>{{ __('Description') }}</h3>
            <p>{{ $chat->application->description }}</p>
        </div>

        <div class="mb-4">
            <h3>{{ __('Host') }}</h3>
            <p>{{ $chat->user->name }}</p>
        </div>

        <div class="mb-4">
            <p>{{ __('Seats') }}: {{ $chat->allowedSeatsCount() }} / {{ $chat->seats }}</p>
        </div>

        <div class="mb-4">
            {{-- todo - status name format --}}
            <p>{{ __('Status') }}: {{ ucfirst($chat->status->value) }}</p>
        </div>
        <x-chat.members
                :members="$chat->members"
                :masks="$masks"
                :mask="$mask"
                :is-started="$this->isStarted()"
                :is-owner="$this->isOwner()"
                :is-joined="$this->isJoined()"/>

        @livewire('mask-selector', ['chat' => $chat])

    </div>
    <div class="py-3 flex justify-end space-x-2">
        <flux:button.group>
            <flux:button wire:click="close" class="cursor-pointer">
                {{ __('Close') }}
            </flux:button>
            @if($this->canEdit())
                <flux:button wire:click="edit" class="cursor-pointer">
                    {{ __('Edit') }}
                </flux:button>
                <flux:button wire:click="publish" class="cursor-pointer">
                    {{ __('Publish') }}
                </flux:button>
            @endif
            @if($this->canAddMember())
                <flux:button wire:click="member" class="cursor-pointer">
                    {{ __('Member') }}
                </flux:button>
            @endif
            @if($this->canStart())
                <flux:button wire:click="start" class="cursor-pointer">
                    {{ __('Start') }}
                </flux:button>
            @endif
            @if($this->canPlay())
                <flux:button wire:click="play" class="cursor-pointer">
                    {{ __('Play') }}
                </flux:button>
            @endif
        </flux:button.group>
    </div>

    <flux:modal name="publish-confirmation" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Publish') }}?</flux:heading>
                <flux:subheading>
                    <p>{{ __('Are you sure you want to publish this chat?') }}</p>
                    <p>{{ __('This action cannot be reversed.') }}</p>
                </flux:subheading>
            </div>
            <div class="flex gap-2">
                <flux:spacer/>
                <flux:modal.close>
                    <flux:button variant="ghost" class="cursor-pointer">
                        {{ __('Cancel') }}
                    </flux:button>
                </flux:modal.close>
                <flux:button variant="primary" wire:click="publishConfirmed" class="cursor-pointer">
                    {{ __('Publish') }}
                </flux:button>
            </div>
        </div>
    </flux:modal>

    <flux:modal name="start-confirmation" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Start Chat') }}?</flux:heading>
                <flux:subheading>
                    <p>{{ __('Are you sure you want to start this chat?') }}</p>
                    <p>{{ __('This action cannot be reversed.') }}</p>
                    {{-- TODO: check seats and write warning --}}
                </flux:subheading>
            </div>
            <div class="flex gap-2">
                <flux:spacer/>
                <flux:modal.close>
                    <flux:button variant="ghost" class="cursor-pointer">
                        {{ __('Cancel') }}
                    </flux:button>
                </flux:modal.close>
                <flux:button variant="primary" wire:click="startConfirmed" class="cursor-pointer">
                    {{ __('Start') }}
                </flux:button>
            </div>
        </div>
    </flux:modal>

    <x-echo-presence :channels="$presence"/>
</div>
