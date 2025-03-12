<div>
    <div class="flex flex-wrap items-center justify-between w-full mb-2">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item class="text-base!">{{ __('Heroes') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>
    <div class="flex flex-wrap gap-4">
        @foreach($models as $model)
        <div wire:click="show({{ $model->id }})"
            class="cursor-pointer w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5 bg-zinc-100 dark:bg-zinc-900 border-zinc-200 dark:border-zinc-700 shadow-lg rounded-lg overflow-hidden">
            <img src="{{ Storage::url($model->imagePath) }}" alt="{{ $model->title }}" class="w-full h-48 object-cover">
            <div class="p-4">
                <flux:heading size="lg" class="h-[3.5rem] overflow-hidden">
                    {{ $model->title }}
                </flux:heading>
                <flux:subheading class="h-[5rem] overflow-hidden">
                    {{ $model->description }}
                </flux:subheading>
            </div>
        </div>
        @endforeach

        <flux:modal name="details" x-on:cancel="$wire.mask = null;">
            <div class="space-y-6">
                <img src="{{ Storage::url($mask?->imagePath) }}" alt="{{ $mask?->title }}" class="w-full object-cover">
                <div>
                    <flux:heading size="lg">
                        {{ $mask?->title }}
                    </flux:heading>
                    <flux:subheading>
                        {{ $mask?->description }}
                    </flux:subheading>
                </div>
                <div class="flex gap-2">
                    <flux:spacer />
                    <flux:modal.close>
                        <flux:button variant="ghost" class="cursor-pointer">
                            {{ __('Close') }}
                        </flux:button>
                    </flux:modal.close>
                    <flux:button class="cursor-pointer">
                        {{ __('Subscribe') }}
                    </flux:button>
                </div>
            </div>
        </flux:modal>
    </div>
</div>
