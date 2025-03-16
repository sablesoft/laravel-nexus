<div>
    <div class="flex flex-wrap items-center justify-between w-full mb-2">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item class="text-base!">{{ __('Workshop') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item class="text-base!">{{ __($resourceTitle) }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item class="text-base!">{{ __('Details') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item class="text-base!">{{'#'. $modelId }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <div class="flex justify-end space-x-2">
            <flux:button.group>
            <flux:button wire:click="close()" class="cursor-pointer">
                {{ __('Close') }}
            </flux:button>
            @if($this->canRun('edit', $modelId))
                <flux:button wire:click="edit({{ $modelId }})" variant="primary" class="cursor-pointer">
                    {{ __('Edit') }}
                </flux:button>
            @endif
            </flux:button.group>
        </div>
    </div>
    <div class="bg-zinc-100 dark:bg-zinc-900 border-zinc-200 dark:border-zinc-700 p-4 rounded">
        @foreach($this->checkedFields() as $field => $title)
            @if($this->type($field) !== 'hidden')
                <label for="state.{{ $field }}"
                       class="block text-gray-700 dark:text-gray-300 text-lg font-black mt-4">
                    {{ $title }}
                </label>
            @endif
            @switch($this->type($field))
                @case('hidden')
                    @break
                @case('checkbox')
                    <div class="px-4 py-2 whitespace-normal text-gray-900 dark:text-gray-300">
                        {{ $state[$field] }}
                    </div>
                    @break
                @case('image')
                    <div class="px-4 py-2 whitespace-normal text-gray-900 dark:text-gray-300">
                        <img src="{{ Storage::url($state[$field]) }}" alt="{{ $field }}">
                    </div>
                    @break
                @case('select')
                    <div class="px-4 py-2 whitespace-normal text-gray-900 dark:text-gray-300">
                        {!!  $this->selectedOptionTitle($field, $state[$field]) !!}
                    </div>
                    @break
                @default
                    <div class="px-4 py-2 whitespace-normal text-gray-900 dark:text-gray-300">
                        {!! nl2br($state[$field]) !!}
                    </div>
                    @break
            @endswitch
        @endforeach
    </div>
    <div class="py-3 flex justify-end space-x-2">
        <flux:button.group>
        <flux:button wire:click="close()" class="cursor-pointer">
            {{ __('Close') }}
        </flux:button>
        @if($this->canRun('edit', $modelId))
            <flux:button wire:click="edit({{ $modelId }})" variant="primary" class="cursor-pointer">
                {{ __('Edit') }}
            </flux:button>
        @endif
        </flux:button.group>
    </div>
</div>
