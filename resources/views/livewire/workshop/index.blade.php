<!--suppress XmlUnboundNsPrefix, HtmlUnknownAttribute -->
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ $resourceTitle }}
    </h2>
</x-slot>
<div x-data="{ isMobile: window.innerWidth < 768 }" id="crud-index" x-init="
    window.addEventListener('resize', () => {
        isMobile = window.innerWidth < 768;
    })" class="py-12">
    <div class="max-w-full sm:px-6 lg:px-8">
        <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded dark:bg-gray-800"
             :class="{'dark:bg-gray-900' : isMobile, 'dark:bg-gray-800' : !isMobile}">
            <div wire:loading.delay>Loading...</div>
            <!-- Index Buttons -->
            <div class="mb-2 flex flex-wrap justify-end">
            @foreach($this->indexButtons() as $buttonAction => $buttonTitle)
                <x-crud.button wire:click="{{  $buttonAction }}" class="ml-2">
                    {{ $buttonTitle }}
                </x-crud.button>
            @endforeach
            </div>

            <!-- Pagination -->
            <div class="my-2">
                {{ $models->links() }}
            </div>

            <!-- Custom Index Components -->
            <div wire:key="custom-components">
            @foreach($this->components('index') as $index => $component)
                <div wire:key="component-{{ $component }}-{{ $index }}">
                @livewire($component, $this->componentParams($action))
                </div>
            @endforeach
            </div>
            <!-- Custom Index Templates -->
            <div wire:key="custom-templates">
            @foreach($this->templates('index') as $index => $template)
                <div wire:key="template-{{ $template }}-{{ $index }}">
                @include($template, $this->templateParams($action))
                </div>
            @endforeach
            </div>

            <div wire:key="index-content">

                @if($this->checkedModels())
                    <!-- Table for large screens -->
                    <div x-show="!isMobile" x-cloak class="overflow-hidden w-full hidden md:block">
                        <x-crud.table :models="$this->checkedModels()"
                                      :fields="$this->checkedFields()"
                                      :actions="$this->checkedActions()"/>
                    </div>

                    <!-- Cards for mobile screens -->
                    <div x-show="isMobile" x-cloak class="md:hidden">
                        <x-crud.cards :models="$this->checkedModels()"
                                      :fields="$this->checkedFields()"
                                      :actions="$this->checkedActions()"/>
                    </div>
                @else
                    <p class="text-center py-4 text-gray-500">{{ __('No records found') }}</p>
                @endif

            </div>

            <!-- Pagination -->
            <div class="my-2">
                {{ $models->links() }}
            </div>
        </div>
    </div>
</div>
