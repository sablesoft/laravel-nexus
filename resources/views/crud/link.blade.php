@props([
    'route' => '',
    'title' => '',
    'action' => null,
    'id' => null
])

@if(!empty($route))
    <flux:button variant="filled">
    <a class="cursor-pointer inline-block whitespace-nowrap" wire:navigate
       href="{{ route($route, ['action' => $action, 'id' => $id]) }}">
        {{ $title ?: '----' }}
    </a>
    </flux:button>
@else
    {{ $title ?: '(not set)' }}
@endif
