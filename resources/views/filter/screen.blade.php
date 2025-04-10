<flux:tooltip content="{{ __('Filter by Screen') }}">
    <flux:select id="public" wire:model.live="filterScreenId" placeholder="{{ __('Screen') }}" class="cursor-pointer">
        <flux:select.option selected value="0">{{ __('All Screens') }}</flux:select.option>
        @php /** @var \App\Models\Screen $screen */ @endphp
        @foreach($this->screens as $screen)
            <flux:select.option :value="$screen->id">{{ $screen->title }}</flux:select.option>
        @endforeach
    </flux:select>
</flux:tooltip>
