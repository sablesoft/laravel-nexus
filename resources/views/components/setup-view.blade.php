@props([
    'beforeString' => null,
    'afterString' => null,
])
<div class="mb-3">
    <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400">Before (JSON)</label>
    <x-prism-view :string="$beforeString" lang="json"/>
</div>
<div class="mb-4">
    <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400">After (JSON)</label>
    <x-prism-view :string="$afterString" lang="json"/>
</div>
