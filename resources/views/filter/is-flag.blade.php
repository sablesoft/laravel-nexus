<flux:tooltip :content="$this->filterIsFlagLabel()">
    <flux:select wire:model.live="filterIsFlag" :placeholder="$this->filterIsFlagLabel()" class="cursor-pointer">
        <flux:select.option selected value="all">{{ __('All') }}</flux:select.option>
        <flux:select.option value="yes">{{ __('Yes') }}</flux:select.option>
        <flux:select.option value="no">{{ __('No') }}</flux:select.option>
    </flux:select>
</flux:tooltip>
