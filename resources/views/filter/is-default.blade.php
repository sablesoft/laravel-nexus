<flux:tooltip content="Is default filter">
    <flux:select id="public" wire:model.live="filterIsDefault" placeholder="Is Default" class="cursor-pointer">
        <flux:select.option selected value="all">{{ 'All' }}</flux:select.option>
        <flux:select.option value="yes">{{ 'Yes' }}</flux:select.option>
        <flux:select.option value="no">{{ 'No' }}</flux:select.option>
    </flux:select>
</flux:tooltip>
