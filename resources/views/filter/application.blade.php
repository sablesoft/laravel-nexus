<flux:tooltip content="Filter by Application">
    <flux:select id="public" wire:model.live="filterApplicationId" placeholder="Application" class="cursor-pointer">
        <flux:select.option selected value="0">{{ 'All Applications' }}</flux:select.option>
        @php /** @var \App\Models\Application $application */ @endphp
        @foreach($this->applications as $application)
            <flux:select.option :value="$application->id">{{ $application->title }}</flux:select.option>
        @endforeach
    </flux:select>
</flux:tooltip>
