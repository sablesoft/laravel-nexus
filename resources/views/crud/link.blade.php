@props([
    'route' => '',
    'title' => '',
    'action' => null,
    'id' => null
])
<a {{ $attributes->merge() }} wire:navigate href="{{ route($route, ['action' => $action, 'id' => $id]) }}">
    {{ $title }}
</a>
