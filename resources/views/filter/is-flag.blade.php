<flux:tooltip :content="$this->filterIsFlagLabel()">
    <flux:select wire:model.live="filterIsFlag" :placeholder="$this->filterIsFlagLabel()" class="cursor-pointer">
        <flux:select.option selected value="all">{{ 'All' }}</flux:select.option>
        <flux:select.option value="yes">{{ 'Yes' }}</flux:select.option>
        <flux:select.option value="no">{{ 'No' }}</flux:select.option>
    </flux:select>
</flux:tooltip>
