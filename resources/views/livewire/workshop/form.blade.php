<!--suppress XmlUnboundNsPrefix, HtmlUnknownAttribute -->
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ $resourceTitle }}
    </h2>
</x-slot>
<div x-data="{ isMobile: window.innerWidth < 768 }" id="crud-form" x-init="
    window.addEventListener('resize', () => {
        isMobile = window.innerWidth < 768;
    })" class="py-12">
    <div class="max-w-full sm:px-6 lg:px-8">
        <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded dark:bg-gray-800"
             :class="{'dark:bg-gray-900' : isMobile, 'dark:bg-gray-800' : !isMobile}">
            <form>
                <div id="header-buttons">
                    <div class="px-4 py-3 sm:px-6 flex justify-end space-x-2">
                        <flux:button wire:click="close()">
                            {{ __('Close') }}
                        </flux:button>
                        @if($modelId)
                            <flux:button wire:click="view()">
                                {{ __('View') }}
                            </flux:button>
                        @endif
                        <span class="flex w-full rounded-md shadow-sm sm:w-auto">
                        <flux:button wire:click.prevent="{{ $formAction }}()">
                            {{ \App\Livewire\Workshop\AbstractCrud::title($action) }}
                        </flux:button>
                        </span>
                    </div>
                </div>
                <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="mb-4">
                        @foreach($this->checkedFields() as $field => $title)
                            <div id="field-{{ $field }}">
                                @if($this->type($field) !== 'hidden')
                                    <label for="state.{{ $field }}"
                                           class="block text-gray-700 dark:text-gray-300 text-lg font-black my-4">
                                        {{ $title }}
                                    </label>
                                @endif
                                @switch($this->type($field))
                                    @case('input')
                                        <input type="text"
                                               data-field="{{ $field }}"
                                               placeholder="{{ $this->placeholder($field) }}"
                                               class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full"
                                               id="{{ 'state.'.$field }}" wire:model="state.{{ $field }}">
                                        @break
                                    @case('number')
                                        <input type="number" min="1" step="1"
                                               data-field="{{ $field }}"
                                               class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full"
                                               id="{{ 'state.'.$field }}" wire:model="state.{{ $field }}">
                                        @break
                                    @case('decimal')
                                        <input type="number" min="0" step="0.01"
                                               data-field="{{ $field }}"
                                               class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full"
                                               id="{{ 'state.'.$field }}" wire:model="state.{{ $field }}">
                                        @break
                                    @case('image')
                                        <div x-data="{ uploading: false, progress: 0 }"
                                             x-on:livewire-upload-start="uploading = true"
                                             x-on:livewire-upload-finish="uploading = false"
                                             x-on:livewire-upload-cancel="uploading = false"
                                             x-on:livewire-upload-error="uploading = false"
                                             x-on:livewire-upload-progress="progress = $event.detail.progress">
                                            <input type="file" data-field="{{ $field }}" accept=".png, .jpg, .jpeg"
                                                   class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full"
                                                   id="{{ 'state.'.$field }}" wire:model="image">
                                            <!-- Progress Bar -->
                                            <div x-show="uploading">
                                                <progress max="100" x-bind:value="progress"></progress>
                                            </div>
                                            @error('image')<span class="text-red-500">{{ $message }}</span> @enderror
                                            @if ($image)
                                                <img src="{{ $image->temporaryUrl() }}">
                                            @elseif(!empty($state[$field]))
                                                <img src="{{ Storage::url($state[$field]) }}">
                                            @endif
                                        </div>
                                        @break
                                    @case('checkbox')
                                        <x-checkbox data-field="{{ $field }}" id="{{ 'state.'.$field }}"
                                                    wire:model="state.{{ $field }}"/>
                                        @break
                                    @case('hidden')
                                        <input type="hidden"
                                               data-field="{{ $field }}"
                                               id="{{ 'state.'.$field }}" wire:model="state.{{ $field }}">
                                        @break
                                    @case('select')
                                        <select data-field="{{ $field }}"
                                                class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full"
                                                id="state.{{ $field }}" wire:model="state.{{ $field }}">
                                            @foreach ($this->selectOptions($field) as $value => $title)
                                                <option value="{{ $value }}">{{ $title }}</option>
                                            @endforeach
                                        </select>
                                        @break
                                    @case('textarea')
                                        <textarea data-field="{{ $field }}" rows="3"
                                                  placeholder="{{ $this->placeholder($field) }}"
                                                  class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full"
                                                  id="{{ 'state.'.$field }}" wire:model="state.{{ $field }}"
                                                  x-data
                                                  x-init="$el.style.height = $el.scrollHeight + 'px'; $el.addEventListener('input', function() { this.style.height = 'auto'; this.style.height = this.scrollHeight + 'px'; })"></textarea>
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

                                @error('state.'.$field) <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        @endforeach
                    </div>
                </div>
                <div id="footer-buttons">
                    <div class="px-4 py-3 sm:px-6 flex justify-end space-x-2">
                        <flux:button wire:click="close()">
                            {{ __('Close') }}
                        </flux:button>
                        @if($modelId)
                            <flux:button wire:click="view()">
                                {{ __('View') }}
                            </flux:button>
                        @endif
                        <flux:button wire:click.prevent="{{ $formAction }}()">
                            {{ \App\Livewire\Workshop\AbstractCrud::title($action) }}
                        </flux:button>
                    </span>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
