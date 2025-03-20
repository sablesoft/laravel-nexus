<div>
    <flux:modal.trigger name="select-screen">
        <flux:button class="cursor-pointer">Select Screen</flux:button>
    </flux:modal.trigger>
    <flux:modal name="select-screen"
                x-on:cancel="$wire.resetFilters()"
                x-on:close="$wire.resetFilters()" class="!max-w-4xl">
        <div class="space-y-6">
            <x-crud.control/>
            <div class="my-2">
                {{ $models->links() }}
            </div>
            <div class="overflow-auto max-h-164 mt-4">
                <div class="grid grid-cols-5 gap-4">
                    @foreach($models as $model)
                        <div class="relative group cursor-pointer"
                             wire:click="selectScreen({{ $model->id }}); $flux.modal('select-screen').close()">
                            @php
                                /** @var \App\Models\Screen $model */
                                $src = $model->imageUrl;
                            @endphp
                            @if($src)
                                <img src="{{ $src }}" alt="{{ $model->title }}" class="w-full h-full object-cover rounded-lg">
                            @else
                                <span class="text-gray-500">No Image</span>
                            @endif
                            <div class="cursor-pointer absolute inset-0 bg-black bg-opacity-30 opacity-0 group-hover:opacity-70 transition-opacity flex items-center justify-center">
                                <span variant="ghost" class="text-white text-center cursor-pointer">{{ $model->title }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </flux:modal>

    <div class="mt-6 space-y-4">
        @foreach($transfers as $id => $transfer)
            @php $screenToId = $transfer['screen_to_id']; @endphp
            <div x-data="{ open: false }">
                <div class="flex items-center justify-between bg-gray-200 p-2 rounded-lg cursor-pointer"
                     @click="open = !open">
                    <div class="flex items-center space-x-2">
                        <img :src="'{{ $transfer['imageUrl'] ?? '' }}'" alt="Screen Image"
                             class="w-10 h-10 rounded-lg object-cover">
                        <span class="font-semibold">{{ $transfer['screenTitle'] }}</span>
                    </div>
                    <span x-text="open ? '▲' : '▼'"></span>
                </div>

                <div x-show="open" class="mt-2 p-2 border rounded-lg">
                    <div class="mb-2">
                        <label class="block text-sm font-medium">Title</label>
                        <flux:input type="text" wire:model.change="transfers.{{ $screenToId }}.title"/>
                    </div>

                    <div class="mb-2">
                        <label class="block text-sm font-medium">Tooltip</label>
                        <flux:input type="text" wire:model.change="transfers.{{ $screenToId }}.tooltip"/>
                    </div>

                    <div class="mb-2">
                        <label class="block text-sm font-medium">Active (JSON)</label>
                        <flux:textarea wire:model.change="transfers.{{ $screenToId }}.active"></flux:textarea>
                    </div>
                    <flux:button class="cursor-pointer" variant="danger" wire:click="removeScreen({{ $screenToId }})">
                        Delete
                    </flux:button>
                </div>
            </div>
        @endforeach
    </div>
</div>
