@props([
    'route' => '',
    'action' => 'view',
    'list' => [],
])
<div class="flex flex-wrap gap-1">
    @foreach($list as $id => $title)
        @include('crud.link', compact('route', 'action', 'id', 'title'))
    @endforeach
</div>
