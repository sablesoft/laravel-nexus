<style>
    .table-cell-content {
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 4;
        overflow: hidden;
        text-overflow: ellipsis;
        max-height: 6rem;
        line-height: 1.5rem;
    }
</style>

<table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
    <thead class="bg-zinc-100 dark:bg-zinc-900 border-zinc-200 dark:border-zinc-700">
    <tr>
        <th class="px-4 py-4 w-20 text-left font-bold uppercase tracking-wider">
            ID
        </th>
        @foreach($fields as $field => $title)
            <th class="px-4 py-4 text-left font-bold uppercase tracking-wider">{{ $title }}</th>
        @endforeach
        <th class="px-4 py-4 w-20 text-left font-bold uppercase tracking-wider">{{ __('Actions') }}</th>
    </tr>
    </thead>
    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
    @foreach($models as $id => $data)
        <tr>
            <td class="px-4 py-2 whitespace-nowrap">{{ $id }}</td>
            @foreach($fields as $field => $title)
                <td class="px-4 py-2">
                    <div class="table-cell-content" data-field="{{ $field }}">
                        {!! $data[$field] !!}
                    </div>
                </td>
            @endforeach
            <td class="px-4 py-2 whitespace-nowrap">
                <flux:button.group>
                @foreach($actions as $actionName => $actionInfo)
                    @if(in_array($id, $actionInfo['ids']))
                        <flux:tooltip :content="\App\Livewire\Workshop\AbstractCrud::title($actionName)">
                            <flux:button :icon="$actionInfo['icon']" class="cursor-pointer"
                                         wire:click="{{ $actionName }}({{ $id }})"></flux:button>
                        </flux:tooltip>
                    @endif
                @endforeach
                </flux:button.group>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
