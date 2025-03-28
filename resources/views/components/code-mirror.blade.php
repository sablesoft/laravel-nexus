@props([
    'readonly' => false,
    'lang' => 'json',
    'content' => null,
])
<div wire:ignore x-data="codeMirrorComponent('{{ $lang }}', {{ $readonly ? 'true' : 'false' }})"
     x-init="init({{ $readonly ? '@json($content)' : 'null' }})" class="relative">

    <div x-ref="editorContainer"></div>

    <!--suppress HtmlFormInputWithoutLabel -->
    @if (!$readonly)
        <textarea x-ref="textarea"
                  {{ $attributes->merge(['class' => 'w-full hidden']) }}></textarea>
    @else
        <textarea x-ref="textarea"
                  class="hidden">{{ $content }}</textarea>
    @endif
</div>
