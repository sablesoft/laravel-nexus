<flux:tooltip content="{{ __('Filter by publicity') }}">
    <flux:select id="public" wire:model.live="filterIsPublic" placeholder="{{ __('Is Public') }}" class="cursor-pointer">
        <flux:select.option selected value="all">{{ __('All') }}</flux:select.option>
        <flux:select.option value="yes">{{ __('Yes') }}</flux:select.option>
        <flux:select.option value="no">{{ __('No') }}</flux:select.option>
    </flux:select>
</flux:tooltip>
