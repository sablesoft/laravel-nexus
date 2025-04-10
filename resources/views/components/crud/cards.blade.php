<div>
    @foreach($models as $id => $data)
        <div class="bg-zinc-100 dark:bg-zinc-900 border-zinc-200 dark:border-zinc-700 shadow rounded-md mb-6 p-4">
            <div class="flex justify-between items-center mb-2">
                <div class="text-sm font-medium text-gray-500 dark:text-gray-300">#{{ $id }}</div>
                <div class="flex space-x-2">
                    <flux:button.group>
                    @foreach($actions as $actionName => $actionInfo)
                        @if(in_array($id, $actionInfo['ids']))
                            <flux:tooltip :content="\App\Crud\AbstractCrud::title($actionName)">
                                <flux:button :icon="$actionInfo['icon']" class="cursor-pointer"
                                             wire:click="{{ $actionName }}({{ $id }})"></flux:button>
                            </flux:tooltip>
                        @endif
                    @endforeach
                    </flux:button.group>
                </div>
            </div>
            <div class="text-sm text-gray-600 dark:text-gray-300">
                @foreach($fields as $field => $title)
                    <div class="flex justify-between mb-1">
                        @switch($this->type($field))
                            @case('image')
                                <div class="w-96">
                                    <x-image-viewer path="{{ $data[$field] }}" alt="{{ $field }}"/>
                                </div>
                                @break
                            @default
                                <span class="font-semibold text-gray-900 dark:text-gray-300 pr-2">
                                {{ $title }}:
                                </span>
                                <span>{!! $data[$field] !!}</span>
                                @break
                        @endswitch
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
