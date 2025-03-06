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

<table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
    <thead class="bg-gray-50 dark:bg-gray-900">
    <tr>
        <th class="px-4 py-4 w-20 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
            ID
        </th>
        @foreach($fields as $field => $title)
            <th class="px-4 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ $title }}</th>
        @endforeach
        <th class="px-4 py-4 w-20 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('Actions') }}</th>
    </tr>
    </thead>
    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
    @foreach($models as $id => $data)
        <tr>
            <td class="px-4 py-2 whitespace-nowrap text-gray-900 dark:text-gray-300">{{ $id }}</td>
            @foreach($fields as $field => $title)
                <td class="px-4 py-2 text-gray-900 dark:text-gray-300">
                    <div class="table-cell-content" data-field="{{ $field }}">
                        {!! $data[$field] !!}
                    </div>
                </td>
            @endforeach
            <td class="px-4 py-2 whitespace-nowrap text-gray-900 dark:text-gray-300">
                @foreach($actions as $actionName => $actionInfo)
                    @if(in_array($id, $actionInfo['ids']))
                        <flux:tooltip :content="\App\Livewire\Workshop\AbstractCrud::title($actionName)">
                            <flux:button :icon="$actionInfo['icon']" class="cursor-pointer"
                                         wire:click="{{ $actionName }}({{ $id }})"></flux:button>
                        </flux:tooltip>
                    @endif
                @endforeach
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
