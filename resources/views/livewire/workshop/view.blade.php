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
                <span class="flex w-full rounded-md shadow-sm sm:w-auto">
                    <button wire:click="close()" type="button"
                            class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white dark:bg-gray-600 text-base leading-6 font-medium text-gray-700 dark:text-gray-300 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring-blue-500 sm:text-sm sm:leading-5">
                        {{ __('Close') }}
                    </button>
                </span>
                @if($this->canRun('edit', $modelId))
                <span class="flex w-full rounded-md shadow-sm sm:w-auto">
                    <button wire:click="edit({{ $modelId }})" type="button"
                            class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-gray-800 dark:bg-gray-200 text-base leading-6 font-medium text-white dark:text-gray-800 shadow-sm hover:bg-gray-700 dark:hover:bg-white focus:outline-none focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm sm:leading-5">
                        {{ __('Edit') }}
                    </button>
                </span>
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
                <span class="flex w-full rounded-md shadow-sm sm:w-auto">
                    <button wire:click="close()" type="button"
                            class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white dark:bg-gray-600 text-base leading-6 font-medium text-gray-700 dark:text-gray-300 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring-blue-500 sm:text-sm sm:leading-5">
                        {{ __('Close') }}
                    </button>
                </span>
                @if($this->canRun('edit', $modelId))
                <span class="flex w-full rounded-md shadow-sm sm:w-auto">
                    <button wire:click="edit({{ $modelId }})" type="button"
                            class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-gray-800 dark:bg-gray-200 text-base leading-6 font-medium text-white dark:text-gray-800 shadow-sm hover:bg-gray-700 dark:hover:bg-white focus:outline-none focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm sm:leading-5">
                        {{ __('Edit') }}
                    </button>
                </span>
                @endif
            </div>
        </div>
    </div>
</div>
