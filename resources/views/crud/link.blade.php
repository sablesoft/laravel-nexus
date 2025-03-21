@props([
    'route' => '',
    'title' => '',
    'action' => null,
    'id' => null
])
@if(!empty($route))
    <span class="border-2 rounded-full p-1">
        <a class="cursor-pointer inline-block whitespace-nowrap" wire:navigate href="{{ route($route, ['action' => $action, 'id' => $id]) }}">
            {{ $title ?: '----' }}
        </a>
    </span>
@else
    <span class="border-2 rounded-full p-1 whitespace-nowrap">{{ $title ?: '----' }}</span>
@endif
