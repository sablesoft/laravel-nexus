<div>
    {{-- Header --}}
    <header class="flex flex-wrap items-center justify-between w-full mb-4">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item class="text-base!">{{ __('Workshop') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item class="text-base!">{{ __($resourceTitle) }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item class="text-base!">{{ __('Details') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item class="text-base!">{{ '#' . $modelId }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <div class="flex justify-end space-x-2">
            <flux:button.group>
                <flux:button wire:click="close()" class="cursor-pointer">
                    {{ __('Close') }}
                </flux:button>
                @foreach($this->viewButtons() as $buttonAction => $button)
                    @if($this->canRun($buttonAction, $modelId))
                        <flux:button :variant="$button['variant'] ?? 'outline'" wire:click="{{ $buttonAction }}({{ $modelId }})"
                                     class="cursor-pointer">
                            {{ $button['title'] }}
                        </flux:button>
                    @endif
                @endforeach
            </flux:button.group>
        </div>
    </header>

    {{-- Fields --}}
    <div class="space-y-4">
        @foreach($this->checkedFields() as $field => $title)
            @if($this->type($field) !== 'hidden')
                <div x-data="{ open: false }" class="bg-zinc-100 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-md shadow">
                    {{-- Field header --}}
                    <div @click="open = !open"
                         class="flex items-center justify-between border-b border-zinc-200 dark:border-zinc-700 px-4 py-3 cursor-pointer hover:bg-zinc-200 dark:hover:bg-zinc-800 rounded-t-md">
                        <h3 class="text-lg font-black text-gray-700 dark:text-gray-300">
                            {{ $title }}
                        </h3>
                        <span class="text-sm text-gray-500 dark:text-gray-400" x-text="open ? '▲' : '▼'"></span>
                    </div>

                    {{-- Field content --}}
                    <div x-show="open" x-transition class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">
                        @switch($this->type($field))
                            @case('checkbox')
                                {{ $state[$field] }}
                                @break

                            @case('image')
                                @switch($this->getImageRatio($modelId))
                                    @case('square')
                                        <div class="w-2/3">
                                            <x-image-viewer :path="$state[$field]" alt="{{ $field }}"/>
                                        </div>
                                        @break
                                    @case('portrait')
                                        <div class="w-2/5">
                                            <x-image-viewer :path="$state[$field]" alt="{{ $field }}"/>
                                        </div>
                                        @break
                                    @default
                                        <div class="w-full">
                                            <x-image-viewer :path="$state[$field]" alt="{{ $field }}"/>
                                        </div>
                                        @break
                                @endswitch
                                @break

                            @case('select')
                                {!! $this->selectedOptionTitle($field, $state[$field]) !!}
                                @break

                            @case('template')
                                @if($this->config($field, 'callback'))
                                    {!! nl2br($state[$field]) !!}
                                @else
                                    @php
                                        $params = $this->templateParams($action, $field);
                                        if(is_callable($params)) {
                                            $params = $params($this->getResource());
                                        }
                                    @endphp
                                    @include($this->config($field, 'template'), $params)
                                @endif
                                @break

                            @case('component')
                                <div wire:key="{{ $field }}-{{ $this->config($field, 'component') }}">
                                    @livewire($this->config($field, 'component'), $this->componentParams($action, $field))
                                </div>
                                @break

                            @default
                                {!! nl2br($state[$field]) !!}
                                @break
                        @endswitch
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    {{-- Footer --}}
    <footer class="py-4 flex justify-end space-x-2">
        <flux:button.group>
            <flux:button wire:click="close()" class="cursor-pointer">
                {{ __('Close') }}
            </flux:button>
            @foreach($this->viewButtons() as $buttonAction => $button)
                @if($this->canRun($buttonAction, $modelId))
                    <flux:button :variant="$button['variant'] ?? 'outline'" wire:click="{{ $buttonAction }}({{ $modelId }})"
                                 class="cursor-pointer">
                        {{ $button['title'] }}
                    </flux:button>
                @endif
            @endforeach
        </flux:button.group>
    </footer>
</div>
