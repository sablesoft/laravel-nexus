<flux:modal name="select-mask"
            x-on:cancel="$wire.resetFilters()"
            x-on:close="$wire.resetFilters()" class="!max-w-4xl">
    <flux:heading class="mb-3 text-xl">Select Mask</flux:heading>
    <div class="space-y-6">
        <x-crud.control>
            <x-slot name="filters">
                <flux:tooltip content="Owner">
                    <flux:select id="owner" wire:model.live="owner" placeholder="Owner"
                                 class="cursor-pointer">
                        <flux:select.option value="all">{{ __('All') }}</flux:select.option>
                        <flux:select.option value="you">{{ __('You') }}</flux:select.option>
                        <flux:select.option value="others">{{ __('Others') }}</flux:select.option>
                    </flux:select>
                </flux:tooltip>
                <flux:tooltip content="Has Image">
                    <flux:select id="hasImage" wire:model.live="hasImage" placeholder="Has Image"
                                 class="cursor-pointer">
                        <flux:select.option value="all">{{ __('All') }}</flux:select.option>
                        <flux:select.option value="yes">{{ __('Yes') }}</flux:select.option>
                        <flux:select.option value="no">{{ __('No') }}</flux:select.option>
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
                         wire:click="selectMask({{ $model->id }}); $flux.modal('select-mask').close()">
                        @php $path = $model->image?->path; @endphp
                        @if($path)
                            <img src="{{ Storage::url($path) }}" alt="{{ $model->name }}"
                                 class="w-full h-full object-cover rounded-lg">
                        @else
                            <span class="text-gray-500">No Image</span>
                        @endif
                        <div
                            class="cursor-pointer absolute inset-0 bg-black bg-opacity-30 opacity-0 group-hover:opacity-70 transition-opacity flex items-center justify-center">
                            <span variant="ghost" class="text-white text-center cursor-pointer">{{ $model->name }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</flux:modal>
