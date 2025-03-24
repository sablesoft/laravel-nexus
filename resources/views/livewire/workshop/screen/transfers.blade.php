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
                                $src = $model->imageUrlMd;
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

    <div class="mt-6 space-y-2">
        @if($transfers)
            {{-- Table header --}}
            <div class="grid grid-cols-4 gap-4 font-bold text-sm text-zinc-600 dark:text-zinc-300 bg-zinc-100 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-md px-4 py-2">
                <span>Screen</span>
                <span>Title</span>
                <span>Tooltip</span>
                <span class="text-right">Actions</span>
            </div>
        @endif

        @foreach($transfers as $id => $transfer)
            @php $screenToId = $transfer['screen_to_id']; @endphp
            <div x-data="{ open: false }" class="bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-md shadow transition-all duration-300">
                {{-- Row --}}
                <div
                    class="grid grid-cols-4 gap-4 items-center px-4 py-3 cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-700"
                    @click="open = !open"
                >
                    <div class="flex items-center gap-2">
                        <img :src="'{{ $transfer['imageUrlSm'] ?? '' }}'" alt="Screen Image"
                             class="w-15 h-15 rounded object-cover border border-zinc-300 dark:border-zinc-600">
                        <span class="font-semibold text-zinc-800 dark:text-zinc-100">{{ $transfer['screenTitle'] }}</span>
                    </div>
                    <span class="text-sm text-zinc-600 dark:text-zinc-300">{{ $transfer['title'] ?? '—' }}</span>
                    <span class="text-sm text-zinc-500 dark:text-zinc-400">{{ $transfer['tooltip'] ?? '—' }}</span>
                    <span class="text-right text-sm text-zinc-400 dark:text-zinc-500" x-text="open ? '▲' : '▼'"></span>
                </div>

                {{-- Expandable form --}}
                <div x-show="open" x-transition class="px-6 pb-4 pt-2 text-sm text-zinc-700 dark:text-zinc-300">
                    <div class="mb-3">
                        <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400">Title</label>
                        <flux:input type="text" wire:model.change="transfers.{{ $screenToId }}.title"/>
                    </div>

                    <div class="mb-3">
                        <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400">Tooltip</label>
                        <flux:input type="text" wire:model.change="transfers.{{ $screenToId }}.tooltip"/>
                    </div>

                    <div class="mb-4">
                        <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400">Active (JSON)</label>
                        <flux:textarea wire:model.change="transfers.{{ $screenToId }}.active"></flux:textarea>
                    </div>

                    <div class="flex justify-end">
                        <flux:button class="cursor-pointer" variant="danger" wire:click="removeScreen({{ $screenToId }})">
                            Delete
                        </flux:button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>
