@props([
    'route' => '',
    'action' => 'view',
    'list' => [],
])
<div class="flex flex-wrap gap-2">
    @foreach($list as $id => $title)
        @include('crud.link', compact('route', 'action', 'id', 'title'))
    @endforeach
</div>
