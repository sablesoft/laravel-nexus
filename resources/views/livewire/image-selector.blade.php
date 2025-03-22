<div>
    <flux:modal.trigger name="select-image">
        <flux:button class="cursor-pointer">Select Image</flux:button>
    </flux:modal.trigger>
    <flux:modal name="select-image"
                x-on:cancel="$wire.resetFilters()"
                x-on:close="$wire.resetFilters()" class="!max-w-4xl">
        <flux:heading class="mb-3 text-xl">Select Image</flux:heading>
        <div class="space-y-6">
            <x-crud.control>
                <x-slot name="filters">
                    <flux:tooltip content="Aspect Ratio">
                        <flux:select id="aspectRatio" wire:model.live="aspectRatio" placeholder="Ratio"
                                     class="cursor-pointer">
                            <flux:select.option value="all">{{ __('All') }}</flux:select.option>
                            <flux:select.option value="square">{{ __('Square') }}</flux:select.option>
                            <flux:select.option value="portrait">{{ __('Portrait') }}</flux:select.option>
                            <flux:select.option value="landscape">{{ __('Landscape') }}</flux:select.option>
                        </flux:select>
                    </flux:tooltip>
                    <flux:tooltip content="Public">
                        <flux:select id="isPublic" wire:model.live="isPublic" placeholder="Public"
                                     class="cursor-pointer">
                            <flux:select.option value="all">{{ __('All') }}</flux:select.option>
                            <flux:select.option value="1">{{ __('Yes') }}</flux:select.option>
                            <flux:select.option value="0">{{ __('No') }}</flux:select.option>
                        </flux:select>
                    </flux:tooltip>
                    <flux:tooltip content="Rendering Artifacts">
                        <flux:select id="hasArtifact" wire:model.live="hasArtifacts" placeholder="Rendering Artifacts"
                                     class="cursor-pointer">
                            <flux:select.option value="all">{{ __('All') }}</flux:select.option>
                            <flux:select.option value="1">{{ __('Yes') }}</flux:select.option>
                            <flux:select.option value="0">{{ __('No') }}</flux:select.option>
                        </flux:select>
                    </flux:tooltip>
                </x-slot>
            </x-crud.control>
            <div class="my-2">
                {{ $models->links() }}
            </div>
            <div class="overflow-auto max-h-164 mt-4">
                <div class="grid grid-cols-5 gap-4">
                    @foreach($models as $model)
                        <div class="relative group cursor-pointer"
                             wire:click="selectImage({{ $model->id }}); $flux.modal('select-image').close()">
                            <img src="{{ Storage::url($model->path) }}" alt="{{ $model->title }}"
                                 class="w-full h-full object-cover rounded-lg">
                            <div
                                class="cursor-pointer absolute inset-0 bg-black bg-opacity-30 opacity-0 group-hover:opacity-70 transition-opacity flex items-center justify-center">
                                <span variant="ghost" class="text-white text-center cursor-pointer">{{ $model->title }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </flux:modal>
</div>
