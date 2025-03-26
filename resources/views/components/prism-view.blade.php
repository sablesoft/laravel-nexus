@props([
    'string' => null,
    'lang' => 'json'
])
<pre x-data x-init="window.Prism && Prism.highlightElement($el.querySelector('code'))"
    x-on:livewire:navigated.window="window.Prism && Prism.highlightElement($el.querySelector('code'))"
    class="bg-zinc-100 dark:bg-zinc-800 rounded text-xs overflow-auto whitespace-pre-wrap">
    <code class="language-{{ $lang }}">
        {!! e($string) !!}
    </code>
</pre>
