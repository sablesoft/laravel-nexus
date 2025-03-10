<div>
    <div class="flex flex-wrap items-center justify-between w-full mb-2">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item class="text-base!">{{ __('Chats') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item class="text-base!">{{ __('Edit') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item class="text-base!">{{ $chat->id }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <div class="flex justify-end space-x-2">
            <flux:button.group>
                <flux:button wire:click="close" class="cursor-pointer">
                    {{ __('Close') }}
                </flux:button>
                <flux:button wire:click="update" variant="primary" class="cursor-pointer">
                    {{ __('Update') }}
                </flux:button>
            </flux:button.group>
        </div>
    </div>
    <div class="bg-zinc-100 dark:bg-zinc-900 border-zinc-200 dark:border-zinc-700 p-4 rounded">
        <flux:field class="mb-3">
            <flux:label>{{ __('Title') }}</flux:label>
            <flux:input wire:model="state.title"/>
            <flux:error name="state.title"/>
        </flux:field>

        <flux:field class="mb-3">
            <flux:label>{{ __('Seats Count') }}</flux:label>
            <flux:input wire:model="state.seats" type="number" min="1" step="1"/>
            <flux:error name="state.seats"/>
        </flux:field>

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
    <div class="flex justify-end space-x-2">
        <flux:button.group>
            <flux:button wire:click="close" class="cursor-pointer">
                {{ __('Close') }}
            </flux:button>
            <flux:button wire:click="update" variant="primary" class="cursor-pointer">
                {{ __('Update') }}
            </flux:button>
        </flux:button.group>
    </div>
</div>
