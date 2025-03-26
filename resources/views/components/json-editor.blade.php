<div wire:ignore x-data="jsonEditorComponent()" x-init="init()" class="relative">

    <div x-ref="editorContainer"></div>

    <!--suppress HtmlFormInputWithoutLabel -->
    <textarea x-ref="textarea"
        {{ $attributes->merge(['class' => 'w-full hidden']) }}></textarea>
</div>
