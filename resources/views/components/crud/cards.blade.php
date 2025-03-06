<div>
    @foreach($models as $id => $data)
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg mb-6 p-4">
            <div class="flex justify-between items-center mb-2">
                <div class="text-sm font-medium text-gray-500 dark:text-gray-300">No. {{ $id }}</div>
                <div class="flex space-x-2">
                    @foreach($actions as $actionName => $actionInfo)
                        @if(in_array($id, $actionInfo['ids']))
                            <flux:tooltip :content="\App\Livewire\Workshop\AbstractCrud::title($actionName)">
                                <flux:button :icon="$actionInfo['icon']" class="cursor-pointer"
                                             wire:click="{{ $actionName }}({{ $id }})"></flux:button>
                            </flux:tooltip>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="text-sm text-gray-600 dark:text-gray-300">
                @foreach($fields as $field => $title)
                    <div class="flex justify-between mb-1">
                                    <span class="font-semibold text-gray-900 dark:text-gray-300 pr-2">
                                        {{ $title }}:
                                    </span>
                        <span>{!! $data[$field] !!}</span>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
