<flux:tooltip content="Filter by Screen">
    <flux:select id="public" wire:model.live="filterScreenId" placeholder="Screen" class="cursor-pointer">
        <flux:select.option selected value="0">{{ 'All Screens' }}</flux:select.option>
        @php /** @var \App\Models\Screen $screen */ @endphp
        @foreach($this->screens as $screen)
            <flux:select.option :value="$screen->id">{{ $screen->title }}</flux:select.option>
        @endforeach
    </flux:select>
</flux:tooltip>
