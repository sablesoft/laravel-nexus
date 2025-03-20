<flux:tooltip content="Filter by publicity">
    <flux:select id="public" wire:model.live="filterIsPublic" placeholder="Is Public" class="cursor-pointer">
        <flux:select.option selected value="all">{{ 'All' }}</flux:select.option>
        <flux:select.option value="yes">{{ 'Yes' }}</flux:select.option>
        <flux:select.option value="no">{{ 'No' }}</flux:select.option>
    </flux:select>
</flux:tooltip>
