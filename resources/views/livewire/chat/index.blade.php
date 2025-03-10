<div>
    <div class="flex flex-wrap items-center justify-between w-full mb-2">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item class="text-base!">{{ __('Chats') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item class="text-base!">{{ __('List') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <!-- Control -->
    <x-crud.control>
        <x-slot name="filters">
            <flux:tooltip content="Status">
                <flux:select id="status" wire:model.live="status" placeholder="Status" class="cursor-pointer">
                    <flux:select.option selected value="all">{{ 'All' }}</flux:select.option>
                    @foreach(\App\Models\Enums\ChatStatus::values() as $value)
                        <flux:select.option value="{{ $value }}">{{ ucfirst($value) }}</flux:select.option>
                    @endforeach
                </flux:select>
            </flux:tooltip>
            <flux:tooltip content="Owner">
                <flux:select id="owner" wire:model.live="owner" placeholder="Owner" class="cursor-pointer">
                    <flux:select.option selected value="all">{{ 'All' }}</flux:select.option>
                    <flux:select.option value="user">{{ 'You' }}</flux:select.option>
                    <flux:select.option value="others">{{ 'Others' }}</flux:select.option>
                </flux:select>
            </flux:tooltip>
            <flux:tooltip content="Only With You">
                <flux:switch wire:model.live="memberOnly"/>
            </flux:tooltip>
        </x-slot>
    </x-crud.control>

    <!-- Pagination Top -->
    <div class="my-2">
        {{ $models->links() }}
    </div>

    <div class="flex flex-wrap gap-4">
        @foreach($models as $model)
            <div wire:click="view({{ $model->id }})"
                 class="cursor-pointer w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5 shadow-lg rounded-lg overflow-hidden bg-zinc-100 dark:bg-zinc-900 border-zinc-200 dark:border-zinc-700">
                <img src="{{ Storage::url($model->application->imagePath) }}" alt="{{ $model->title }}" class="w-full h-48 object-cover">
                <div class="p-4">
                    <flux:heading size="lg" class="h-[3.5rem] overflow-hidden">
                        {{ $model->title }}
                    </flux:heading>
                </div>
            </div>
        @endforeach
    </div>
</div>
