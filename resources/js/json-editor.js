import {EditorView, basicSetup} from "codemirror"
import {EditorState} from "@codemirror/state"
import {json} from "@codemirror/lang-json"
import {oneDark} from "@codemirror/theme-one-dark"

window.jsonEditorComponent = (textareaEl, containerEl) => ({
    view: null,

    init() {
        if (!textareaEl || !containerEl) return;

        containerEl.innerHTML = '';

        const updateListener = EditorView.updateListener.of(update => {
            if (update.docChanged) {
                textareaEl.value = this.view.state.doc.toString();

                try {
                    JSON.parse(textareaEl.value);
                    this.view.dom.classList.remove('border-red-500');
                } catch (e) {
                    this.view.dom.classList.add('border-red-500');
                }
            }
        });

        this.view = new EditorView({
            state: EditorState.create({
                doc: textareaEl.value || '',
                extensions: [
                    basicSetup,
                    json(),
                    oneDark,
                    updateListener,
                ]
            }),
            parent: containerEl
        });

        const form = textareaEl.closest('form');
        if (form) {
            form.addEventListener('submit', () => {
                textareaEl.value = this.view.state.doc.toString();
            });
        }
    }
});
