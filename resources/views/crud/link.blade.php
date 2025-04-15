@props([
    'route' => '',
    'title' => '',
    'action' => null,
    'id' => null
])

@if(!empty($route))
    <flux:button variant="filled" class="!h-8 !px-3">
    <a class="cursor-pointer inline-block whitespace-nowrap" wire:navigate
       href="{{ route($route, ['action' => $action, 'id' => $id]) }}">
        {{ $title ?: '----' }}
    </a>
    </flux:button>
@else
    {{ $title ?: __('(not set)') }}
@endif
