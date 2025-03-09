<div class="flex items-center gap-2">

    @if(count($this->orderByFields()) > 1)
    <flux:tooltip content="Order and Search By">
        <flux:select id="orderBy" wire:model.live="orderBy" placeholder="Order By" class="cursor-pointer">
            @foreach($this->orderByFields() as $field => $title)
                <flux:select.option value="{{ $field }}">{{ $title }}</flux:select.option>
            @endforeach
        </flux:select>
    </flux:tooltip>
    @endif

    <flux:tooltip content="Direction">
        <flux:select id="orderDirection" wire:model.live="orderDirection" placeholder="Direction" class="cursor-pointer">
            <flux:select.option value="asc">ASC</flux:select.option>
            <flux:select.option value="desc">DESC</flux:select.option>
        </flux:select>
    </flux:tooltip>

    <flux:tooltip content="Per Page">
        <flux:select id="perPage" wire:model.live="perPage" placeholder="Per page..." class="cursor-pointer">
            @foreach($this->perPageCounts() as $count)
                <flux:select.option value="{{ $count }}">{{ $count }}</flux:select.option>
            @endforeach
        </flux:select>
    </flux:tooltip>

    <flux:tooltip>
        <flux:input wire:model.live.debounce.500ms="search" placeholder="Search...">
            @if($this->search)
                <x-slot name="iconTrailing">
                    <flux:button size="sm" variant="subtle" icon="x-mark" class="-mr-1 cursor-pointer"
                        x-data x-on:click="$wire.set('search', '');"/>
                </x-slot>
            @endif
        </flux:input>
        <flux:tooltip.content>
            {{ __('Search by ') . $this->orderBy . ' value' }}
        </flux:tooltip.content>
    </flux:tooltip>

</div>
