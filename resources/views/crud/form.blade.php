<div x-data="{ isMobile: window.innerWidth < 768 }" id="crud-form" x-init="
    window.addEventListener('resize', () => {
        isMobile = window.innerWidth < 768;
    })">
    <div class="max-w-full">
        <form>
            @php
                $actionTitle = \App\Crud\AbstractCrud::title($action);
            @endphp
            <div class="flex flex-wrap items-center justify-between w-full mb-4">
                <flux:breadcrumbs>
                    <flux:breadcrumbs.item class="text-base!">{{ __('Workshop') }}</flux:breadcrumbs.item>
                    <flux:breadcrumbs.item class="text-base!">{{ __($resourceTitle) }}</flux:breadcrumbs.item>
                    <flux:breadcrumbs.item class="text-base!">{{ __($actionTitle) }}</flux:breadcrumbs.item>
                    @if($modelId)
                        <flux:breadcrumbs.item class="text-base!">{{'#'. $modelId }}</flux:breadcrumbs.item>
                    @endif
                </flux:breadcrumbs>
                <div id="header-buttons" class="flex justify-end space-x-2">
                    <flux:button.group>
                        <flux:button wire:click="close()" class="cursor-pointer">
                            {{ __('Close') }}
                        </flux:button>
                        @if($modelId)
                            <flux:button wire:click="view()" class="cursor-pointer">
                                {{ __('View') }}
                            </flux:button>
                        @endif
                        <flux:button wire:click.prevent="{{ $formAction }}()" variant="primary" class="cursor-pointer">
                            {{ $actionTitle }}
                        </flux:button>
                    </flux:button.group>
                </div>
            </div>
            <div class="mb-6">
                @foreach($this->checkedFields() as $field => $title)
                    <flux:field class="mb-3">
                        @if($this->type($field) !== 'hidden')
                            <flux:label>{{ $title }}</flux:label>
                        @endif
                        @switch($this->type($field))
                            @case('input')
                                <flux:input wire:model="state.{{ $field }}"/>
                                @break
                            @case('number')
                                <flux:input wire:model="state.{{ $field }}" min="1" step="1" type="number"/>
                                @break
                            @case('decimal')
                                <flux:input wire:model="state.{{ $field }}" min="0" step="0.01" type="number"/>
                                @break
                            @case('image')
                                @php $src = $state[$field] ? Storage::url($state[$field]) : null; @endphp
                                @if ($this->className() === \App\Models\Image::class)
                                <div x-data="{ uploading: false, progress: 0 }"
                                     x-on:livewire-upload-start="uploading = true"
                                     x-on:livewire-upload-finish="uploading = false"
                                     x-on:livewire-upload-cancel="uploading = false"
                                     x-on:livewire-upload-error="uploading = false"
                                     x-on:livewire-upload-progress="progress = $event.detail.progress">
                                    <flux:input wire:model="image"
                                                accept=".png, .jpg, .jpeg" type="file"/>
                                    <!-- Progress Bar -->
                                    <div x-show="uploading">
                                        <progress max="100" x-bind:value="progress"></progress>
                                    </div>
                                    @error('image')<span class="text-red-500">{{ $message }}</span> @enderror
                                    @if ($image)
                                    <div class="px-4 py-2 whitespace-normal w-1/3">
                                        <img src="{{ $image->temporaryUrl() }}">
                                    </div>
                                    @else
                                    <div class="px-4 py-2 whitespace-normal w-1/3">
                                        <x-image-viewer src="{{ $src }}" alt="{{ $field }}" uuid="form"/>
                                    </div>
                                    @endif
                                </div>
                                @else
                                    <div class="px-4 py-2 whitespace-normal w-1/3">
                                        <x-image-viewer src="{{ $src }}" alt="{{ $field }}" uuid="form"/>
                                    </div>
                                @endif
                                @break
                            @case('checkbox')
                                <flux:switch wire:model.live="state.{{ $field }}" class="cursor-pointer"/>
                                @break
                            @case('hidden')
                                <flux:input wire:model="state.{{ $field }}" type="hidden"/>
                                @break
                            @case('select')
                                <flux:select wire:model="state.{{ $field }}" class="cursor-pointer">
                                    @foreach ($this->selectOptions($field) as $value => $title)
                                        <flux:select.option value="{{ $value }}">
                                            {{ $title }}
                                        </flux:select.option>
                                    @endforeach
                                </flux:select>
                                @break
                            @case('textarea')
                                <flux:textarea rows="auto" wire:model="state.{{ $field }}"/>
                                @break
                            @case('template')
                                <div wire:key="{{ $field }}-{{ $this->config($field, 'template') }}">
                                    @include($this->config($field, 'template'), $this->templateParams($action, $field))
                                </div>
                                @break
                            @case('component')
                                <div wire:key="{{ $field }}-{{ $this->config($field, 'component') }}">
                                    @livewire($this->config($field, 'component'), $this->componentParams($action, $field))
                                </div>
                                @break
                        @endswitch

                        <flux:error name="state.{{ $field }}"/>
                    </flux:field>
                @endforeach
            </div>
            <div id="footer-buttons" class="flex justify-end space-x-2">
                <flux:button.group>
                    <flux:button wire:click="close()" class="cursor-pointer">
                        {{ __('Close') }}
                    </flux:button>
                    @if($modelId)
                        <flux:button wire:click="view()" class="cursor-pointer">
                            {{ __('View') }}
                        </flux:button>
                    @endif
                    <flux:button wire:click.prevent="{{ $formAction }}()" variant="primary" class="cursor-pointer">
                        {{ $actionTitle }}
                    </flux:button>
                </flux:button.group>
            </div>
        </form>
    </div>
</div>
