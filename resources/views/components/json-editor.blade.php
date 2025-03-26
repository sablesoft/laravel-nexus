<div x-data="jsonEditorComponent($refs.textarea, $refs.editorContainer)"
    x-init="init()"
    class="relative">

    <div x-ref="editorContainer"></div>

    <!--suppress HtmlFormInputWithoutLabel -->
    <textarea x-ref="textarea"
        {{ $attributes->merge(['class' => 'w-full hidden']) }}></textarea>
</div>

