import {EditorView, basicSetup} from "codemirror"
import {EditorState} from "@codemirror/state"
import {json} from "@codemirror/lang-json"
import {oneDark} from "@codemirror/theme-one-dark"

window.jsonEditorComponent = (textareaEl, containerEl) => ({
    view: null,

    init() {
        if (this.view) return;
        // console.debug('[json-editor][init]', textareaEl, containerEl);

        this.$nextTick(() => {
            if (this.view) return;

            const initial = textareaEl.value || '';
            containerEl.innerHTML = '';
            // console.debug('[json-editor][nextTick]', initial);

            const updateListener = EditorView.updateListener.of(update => {
                if (update.docChanged) {
                    textareaEl.value = this.view.state.doc.toString();
                    textareaEl.dispatchEvent(new Event('input', { bubbles: true }));

                    try {
                        JSON.parse(textareaEl.value);
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
                parent: containerEl
            });

            const form = textareaEl.closest('form');
            if (form) {
                form.addEventListener('submit', () => {
                    textareaEl.value = this.view.state.doc.toString();
                });
            }
        });
    }

});
