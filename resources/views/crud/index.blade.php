<div x-data="{ isMobile: window.innerWidth < 768 }" id="crud-index" x-init="
    window.addEventListener('resize', () => {
        isMobile = window.innerWidth < 768;
    })">
    <div class="max-w-full">

        <div class="mb-2 flex flex-wrap items-center justify-between w-full">
            <flux:breadcrumbs>
                <flux:breadcrumbs.item class="text-base!">{{ __('Workshop') }}</flux:breadcrumbs.item>
                <flux:breadcrumbs.item class="text-base!">{{ __($resourceTitle) }}</flux:breadcrumbs.item>
                <flux:breadcrumbs.item class="text-base!">{{ __('List') }}</flux:breadcrumbs.item>
            </flux:breadcrumbs>
            <div wire:loading.delay><flux:icon.loading /></div>
            <div class="flex flex-wrap justify-end">
                <flux:button.group>
                @foreach($this->indexButtons() as $buttonAction => $buttonTitle)
                    <flux:button wire:click="{{  $buttonAction }}" class="cursor-pointer">
                        {{ $buttonTitle }}
                    </flux:button>
                @endforeach
                </flux:button.group>
            </div>
        </div>

        <!-- Pagination Top -->
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
        <!-- Content -->
        <div wire:key="index-content">
            @if($this->checkedModels())
                <!-- Table for large screens -->
                <div x-show="!isMobile" x-cloak class="overflow-hidden w-full md:block rounded-md">
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
        <!-- Pagination Bottom -->
        <div class="my-2">
            {{ $models->links() }}
        </div>
    </div>

    <flux:modal name="delete-confirmation" class="min-w-[22rem]" x-on:cancel="$wire.deleteId = null;">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Delete') }} {{ $this->classTItle(false) }}?</flux:heading>
                <flux:subheading>
                    <p>{{ __('Are you sure you want to delete this item?') }}</p>
                    <p>{{ __('This action cannot be reversed.') }}</p>
                </flux:subheading>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost" class="cursor-pointer">
                        {{ __('Cancel') }}
                    </flux:button>
                </flux:modal.close>
                <flux:button variant="danger" wire:click="deleteConfirmed" class="cursor-pointer">
                    {{ __('Delete') }}
                </flux:button>
            </div>
        </div>
    </flux:modal>

</div>
