<!--suppress XmlUnboundNsPrefix, HtmlUnknownAttribute -->
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ $resourceTitle }}
    </h2>
</x-slot>
<div x-data="{ isMobile: window.innerWidth < 768 }" id="crud-view" x-init="
    window.addEventListener('resize', () => {
        isMobile = window.innerWidth < 768;
    })" class="py-12">
    <div class="max-w-full sm:px-6 lg:px-8">
        <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded dark:bg-gray-800"
             :class="{'dark:bg-gray-900' : isMobile, 'dark:bg-gray-800' : !isMobile}">
            <div class="px-4 py-3 sm:px-6 flex justify-end space-x-2">
                <flux:button wire:click="close()">
                    {{ __('Close') }}
                </flux:button>
                @if($this->canRun('edit', $modelId))
                <flux:button wire:click="edit({{ $modelId }})">
                    {{ __('Edit') }}
                </flux:button>
                @endif
            </div>
            <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="mb-4">
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
                                    {{ $state[$field] ? __('Yes') : __('No') }}
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
                                    {!! nl2br(e($state[$field])) !!}
                                </div>
                                @break
                        @endswitch
                    @endforeach
                </div>
            </div>
            <div class="px-4 py-3 sm:px-6 flex justify-end space-x-2">
                <flux:button wire:click="close()">
                    {{ __('Close') }}
                </flux:button>
                @if($this->canRun('edit', $modelId))
                <flux:button wire:click="edit({{ $modelId }})">
                    {{ __('Edit') }}
                </flux:button>
                @endif
            </div>
        </div>
    </div>
</div>
