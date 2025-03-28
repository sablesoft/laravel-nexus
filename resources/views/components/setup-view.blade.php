@props([
    'beforeString' => null,
    'afterString' => null,
    'key' => uuid_create()
])
@if($beforeString)
    <div class="mb-3">
        <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400">Before ({{ config('dsl.editor', 'yaml') }})</label>
        <x-code-mirror wire:key="codemirror-before-{{ $key }}"
                       :lang="config('dsl.editor', 'yaml')"
                       :readonly="true"
                       :content="$beforeString"
                       class="w-full" />
    </div>
@endif
@if($afterString)
<div class="mb-4">
    <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400">After ({{ config('dsl.editor', 'yaml') }})</label>
    <x-code-mirror wire:key="codemirror-after-{{ $key }}"
                   :lang="config('dsl.editor', 'yaml')"
                   :readonly="true"
                   :content="$afterString"
                   class="w-full" />
</div>
@endif
