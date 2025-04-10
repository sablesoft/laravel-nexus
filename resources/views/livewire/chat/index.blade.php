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
            <flux:tooltip content="{{ __('Owner') }}">
                <flux:select id="owner" wire:model.live="owner" placeholder="{{ __('Owner') }}" class="cursor-pointer">
                    <flux:select.option selected value="all">{{ 'All' }}</flux:select.option>
                    <flux:select.option value="user">{{ 'You' }}</flux:select.option>
                    <flux:select.option value="others">{{ 'Others' }}</flux:select.option>
                </flux:select>
            </flux:tooltip>
            <flux:tooltip content="{{ __('Status') }}">
                <flux:select id="status" wire:model.live="status" placeholder="{{ __('Status') }}" class="cursor-pointer">
                    <flux:select.option selected value="all">{{ 'All' }}</flux:select.option>
                    @foreach($this->getStatuses() as $value)
                        <flux:select.option value="{{ $value }}">{{ ucfirst($value) }}</flux:select.option>
                    @endforeach
                </flux:select>
            </flux:tooltip>
            <flux:tooltip content="{{ __('Only With You') }}">
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
            <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5 shadow-lg rounded-lg overflow-hidden bg-zinc-100 dark:bg-zinc-900 border-zinc-200 dark:border-zinc-700">
                <img src="{{ Storage::url($model->application->imagePath) }}" alt="{{ $model->title }}" class="w-full h-48 object-cover">
                <div class="p-4">
                    <flux:heading size="lg" class="h-[3.5rem] overflow-hidden">
                        {{ $model->title }}
                    </flux:heading>
                    <flux:subheading>
                        <p>{{ __('Owner') }}: {{ ucfirst($model->user->name) }}</p>
                        <p>{{ __('Seats') }}: {{ $model->allowedSeatsCount() }} / {{ $model->seats }}</p>
                        <p>{{ __('Status') }}: {{ ucfirst($model->status->value) }}</p>
                    </flux:subheading>
                    <flux:button.group class="mt-2">
                        <flux:tooltip content="{{ __('View') }}">
                            <flux:button icon="eye" wire:click="view({{ $model->id }})" class="cursor-pointer"></flux:button>
                        </flux:tooltip>
                        @if($this->canLeave($model->id))
                        <flux:tooltip content="{{ __('Leave') }}">
                            <flux:button icon="arrow-right-start-on-rectangle" class="cursor-pointer"
                                         wire:click="leave({{ $model->id }})"></flux:button>
                        </flux:tooltip>
                        @endif
                        @if($this->canPlay($model->id))
                        <flux:tooltip content="{{ __('Play') }}">
                            <flux:button icon="play" wire:click="play({{ $model->id }})" class="cursor-pointer"></flux:button>
                        </flux:tooltip>
                        @endif
                    </flux:button.group>
                </div>
            </div>
        @endforeach
    </div>

    <x-echo-public channel="chats.index"/>
</div>
