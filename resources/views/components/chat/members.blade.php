<div class="mb-4">
    <h3>{{ __('Members') }}</h3>
    @if($members->count())
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
        <thead class="bg-zinc-100 dark:bg-zinc-900 border-zinc-200 dark:border-zinc-700">
        <tr>
            <th class="px-4 py-4 w-20 text-left font-bold uppercase tracking-wider">
                Mask
            </th>
            <th class="px-4 py-4 w-20 text-left font-bold uppercase tracking-wider">
                Name
            </th>
            <th class="px-4 py-4 w-20 text-left font-bold uppercase tracking-wider">
                Description
            </th>
            <th class="px-4 py-4 w-20 text-left font-bold uppercase tracking-wider">
                Player
            </th>
            <th class="px-4 py-4 w-20 text-left font-bold uppercase tracking-wider">
                Confirmed
            </th>
            @if(!$isStarted)
            <th class="px-4 py-4 w-20 text-left font-bold uppercase tracking-wider">{{ __('Actions') }}</th>
            @endif
        </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
        @foreach($members as $member)
            <tr>
                <td class="px-4 py-2 cursor-pointer" wire:click="showMask({{ $member->mask_id }})">
                    <img src="{{ Storage::url($member->mask->imagePath) }}" alt="{{ $member->mask->title }}">
                </td>
                <td class="px-4 py-2">{{ $member->mask->title }}</td>
                <td class="px-4 py-2">
                    <div class="max-h-26 overflow-hidden">
                        {{ $member->mask->description }}
                    </div>
                </td>
                <td class="px-4 py-2">
                    {{ $member->user ? $member->user->name : '---' }}
                </td>
                <td class="px-4 py-2">
                    {{ $member->is_confirmed ? 'Yes' : 'No' }}
                </td>
                @if(!$isStarted)
                <td class="px-4 py-2 whitespace-nowrap">
                    <flux:button.group>
                    @if(!$member->user && !$isJoined)
                        <flux:tooltip content="Join">
                            <flux:button icon="arrow-left-end-on-rectangle" class="cursor-pointer"
                                         wire:click="join({{ $member->id }})"></flux:button>
                        </flux:tooltip>
                    @endif
                    @if($member->user_id === auth()->id())
                        <flux:tooltip content="Leave">
                            <flux:button icon="arrow-right-start-on-rectangle" class="cursor-pointer"
                                         wire:click="leave({{ $member->id }})"></flux:button>
                        </flux:tooltip>
                    @endif
                    @if(!$member->is_confirmed && $isOwner)
                        <flux:tooltip content="Confirm">
                            <flux:button icon="check" class="cursor-pointer"
                                         wire:click="confirm({{ $member->id }})"></flux:button>
                        </flux:tooltip>
                    @endif
                    @if($isOwner)
                        <flux:tooltip content="Delete">
                            <flux:button icon="trash" class="cursor-pointer"
                                         wire:click="deleteMember({{ $member->id }})"></flux:button>
                        </flux:tooltip>
                    @endif
                    </flux:button.group>
                </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
    @else
    <p>No members so far</p>
    @endif
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
</div>
