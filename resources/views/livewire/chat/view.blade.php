<div>
    <div class="flex flex-wrap items-center justify-between w-full mb-2">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item class="text-base!">{{ __('Chats') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item class="text-base!">{{ $chat->id }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <div class="flex justify-end space-x-2">
            <flux:button.group>
                <flux:button wire:click="close" class="cursor-pointer">
                    {{ __('Close') }}
                </flux:button>
                @if($this->canEdit())
                <flux:button wire:click="edit" variant="primary" class="cursor-pointer">
                    {{ __('Edit') }}
                </flux:button>
                @endif
            </flux:button.group>
        </div>
    </div>
    <div class="bg-zinc-100 dark:bg-zinc-900 border-zinc-200 dark:border-zinc-700 p-4 rounded">

        <div class="mb-4">
            <h2>{{ $chat->title }}</h2>
        </div>

        <div class="mt-4">
            <img src="{{ Storage::url( $chat->application->imagePath) }}" alt="Image"
                 class="mt-2 rounded-lg shadow-lg w-96">
        </div>

        <div class="mb-4">
            <h3>{{ __('Description') }}</h3>
            <p>{{ $chat->application->description }}</p>
        </div>

        <div class="mb-4">
            <p>{{ __('Seats') }}: {{ $chat->allowedSeatsCount() }} / {{ $chat->seats }}</p>
        </div>

        <div class="mb-4">
            {{-- todo - status name format --}}
            <p>{{ __('Status') }}: {{ ucfirst($chat->status->value) }}</p>
        </div>

        @if($chat->members->count())
        <div class="mb-4">
            <h3>{{ __('Members') }}</h3>
            @foreach($chat->members as $i => $member)
                <p>
                    <span>{{ $i }}) </span>
                    <span>{{ $member->mask->title }} - {{ $member->user_id ? 'Taken' : 'Free' }}</span>
                    <span> ({{ $member->is_confirmed ? 'Confirmed' : 'Not confirmed' }})</span>
                </p>
            @endforeach
        </div>
        @endif
    </div>
    <div class="py-3 flex justify-end space-x-2">
        <flux:button.group>
            <flux:button wire:click="close" class="cursor-pointer">
                {{ __('Close') }}
            </flux:button>
            @if($this->canEdit())
            <flux:button wire:click="edit" variant="primary" class="cursor-pointer">
                {{ __('Edit') }}
            </flux:button>
            @endif
        </flux:button.group>
    </div>
</div>
