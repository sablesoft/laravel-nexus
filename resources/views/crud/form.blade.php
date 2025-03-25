<div x-data="{ isMobile: window.innerWidth < 768 }" id="crud-form" x-init="
    window.addEventListener('resize', () => {
        isMobile = window.innerWidth < 768;
    })">
    <form>
        {{-- Header --}}
        <div class="flex flex-wrap items-center justify-between w-full mb-4">
            <flux:breadcrumbs>
                <flux:breadcrumbs.item class="text-base!">{{ __('Workshop') }}</flux:breadcrumbs.item>
                <flux:breadcrumbs.item class="text-base!">{{ __($resourceTitle) }}</flux:breadcrumbs.item>
                <flux:breadcrumbs.item class="text-base!">{{ __(\App\Crud\AbstractCrud::title($action)) }}</flux:breadcrumbs.item>
                @if($modelId)
                    <flux:breadcrumbs.item class="text-base!">{{ '#' . $modelId }}</flux:breadcrumbs.item>
                @endif
            </flux:breadcrumbs>

            <div class="flex justify-end space-x-2">
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
                        {{ \App\Crud\AbstractCrud::title($action) }}
                    </flux:button>
                </flux:button.group>
            </div>
        </div>

        {{-- Fields --}}
        <div class="space-y-4 mb-6">
            @foreach($this->checkedFields() as $field => $title)
                @php
                    $hasError = $errors->has('state.' . $field);
                @endphp

                <div x-data="{ open: false }"
                    class="bg-zinc-100 dark:bg-zinc-900 border rounded-md shadow {{ $hasError ? 'border-red-500' : 'border-zinc-200 dark:border-zinc-700' }}">

                    {{-- Header --}}
                    <div @click="open = !open"
                        class="flex items-center justify-between border-b border-zinc-200 dark:border-zinc-700 px-4 py-3 cursor-pointer hover:bg-zinc-200 dark:hover:bg-zinc-800 rounded-t-md">
                        <h3 class="text-base font-bold {{ $hasError ? 'text-red-600 dark:text-red-400' : 'text-zinc-800 dark:text-zinc-100' }}">
                            {{ $title }}
                        </h3>
                        <span class="text-sm text-zinc-500 dark:text-zinc-400" x-text="open ? '▲' : '▼'"></span>
                    </div>

                    {{-- Field --}}
                    <div x-show="open" x-transition class="px-6 py-4">
                        <flux:field class="mb-2">
                            @switch($this->type($field))
                                @case('input')
                                    <flux:input wire:model="state.{{ $field }}"/>
                                    @break

                                @case('number')
                                    <flux:input type="number" min="1" step="1" wire:model="state.{{ $field }}"/>
                                    @break

                                @case('decimal')
                                    <flux:input type="number" min="0" step="0.01" wire:model="state.{{ $field }}"/>
                                    @break

                                @case('checkbox')
                                    <flux:switch wire:model.live="state.{{ $field }}" class="cursor-pointer"/>
                                    @break

                                @case('select')
                                    <flux:select wire:model="state.{{ $field }}" class="cursor-pointer">
                                        @foreach ($this->selectOptions($field) as $value => $label)
                                            <flux:select.option value="{{ $value }}">{{ $label }}</flux:select.option>
                                        @endforeach
                                    </flux:select>
                                    @break

                                @case('textarea')
                                    <flux:textarea wire:model="state.{{ $field }}" rows="auto"/>
                                    @break

                                @case('image')
                                    {{-- Пример из image модели --}}
                                    @if ($this->className() === \App\Models\Image::class)
                                        <div x-data="{ uploading: false, progress: 0 }"
                                             x-on:livewire-upload-start="uploading = true"
                                             x-on:livewire-upload-finish="uploading = false"
                                             x-on:livewire-upload-cancel="uploading = false"
                                             x-on:livewire-upload-error="uploading = false"
                                             x-on:livewire-upload-progress="progress = $event.detail.progress">
                                            <flux:input wire:model="image" type="file" accept=".png, .jpg, .jpeg"/>
                                            <div x-show="uploading" class="mt-2">
                                                <progress max="100" x-bind:value="progress" class="w-full h-2"></progress>
                                            </div>
                                            @error('image')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                                            <div class="mt-3 w-1/3">
                                                @if ($image)
                                                    <img src="{{ $image->temporaryUrl() }}" class="rounded shadow"/>
                                                @else
                                                    <x-image-viewer path="{{ $state[$field] }}" uuid="form"/>
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        <x-image-viewer path="{{ $state[$field] }}" uuid="form"/>
                                    @endif
                                    @break

                                @case('template')
                                    @php
                                        $params = $this->templateParams($action, $field);
                                        if(is_callable($params)) $params = $params($this->getResource());
                                    @endphp
                                    @include($this->config($field, 'template'), $params)
                                    @break

                                @case('component')
                                    <div wire:key="{{ $field }}-{{ $this->config($field, 'component') }}">
                                        @livewire($this->config($field, 'component'), $this->componentParams($action, $field))
                                    </div>
                                    @break

                                @case('hidden')
                                    <flux:input type="hidden" wire:model="state.{{ $field }}"/>
                                    @break
                            @endswitch

                            <flux:error name="state.{{ $field }}"/>
                        </flux:field>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Footer --}}
        <div class="flex justify-end space-x-2">
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
                    {{ \App\Crud\AbstractCrud::title($action) }}
                </flux:button>
            </flux:button.group>
        </div>
    </form>
</div>
