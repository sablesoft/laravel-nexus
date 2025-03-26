import {EditorView, basicSetup} from "codemirror"
import {EditorState} from "@codemirror/state"
import {json} from "@codemirror/lang-json"
import {oneDark} from "@codemirror/theme-one-dark"

window.jsonEditorComponent = () => ({
    view: null,

    init() {
        this.$nextTick(() => {
            const textarea = this.$refs.textarea;
            const container = this.$refs.editorContainer;

            container.innerHTML = '';
            const initial = textarea.value || '';

            const updateListener = EditorView.updateListener.of(update => {
                if (update.docChanged) {
                    const value = this.view.state.doc.toString();
                    textarea.value = value;
                    textarea.dispatchEvent(new Event('input', { bubbles: true }));

                    try {
                        JSON.parse(value);
                        this.view.dom.classList.remove('border-red-500');
                    } catch {
                        this.view.dom.classList.add('border-red-500');
                    }
                }
            });

            this.view = new EditorView({
                state: EditorState.create({
                    doc: initial,
                    extensions: [
                        basicSetup,
                        json(),
                        oneDark,
                        updateListener,
                    ]
                }),
                parent: container
            });

            const form = textarea.closest('form')
            if (form) {
                form.addEventListener('submit', () => {
                    textarea.value = this.view.state.doc.toString();
                });
            }
        });
    }

});
