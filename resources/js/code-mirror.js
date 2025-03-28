import {EditorView, basicSetup} from "codemirror"
import {EditorState} from "@codemirror/state"
import {json} from "@codemirror/lang-json"
import {yaml} from "@codemirror/lang-yaml"
import {oneDark} from "@codemirror/theme-one-dark"
import * as jsYaml from "js-yaml"

window.codeMirrorComponent = (lang = 'json', readonly = false) => ({
    view: null,

    init(initialContent = null) {
        this.$nextTick(() => {
            const textarea = this.$refs.textarea;
            const container = this.$refs.editorContainer;

            container.innerHTML = '';
            const initial = initialContent ?? textarea.value ?? '';

            const extensions = [
                basicSetup,
                oneDark,
                readonly ? EditorView.editable.of(false) : [],
            ];

            if (lang === 'yaml') {
                extensions.push(yaml());
            } else {
                extensions.push(json());
            }

            if (!readonly) {
                const updateListener = EditorView.updateListener.of(update => {
                    if (update.docChanged) {
                        const value = this.view.state.doc.toString();
                        textarea.value = value;
                        textarea.dispatchEvent(new Event('input', { bubbles: true }));

                        try {
                            lang === 'yaml' ? jsYaml.load(value) : JSON.parse(value);
                            this.view.dom.classList.remove('border-red-500');
                        } catch {
                            this.view.dom.classList.add('border-red-500');
                        }
                    }
                });

                extensions.push(updateListener);
            }

            this.view = new EditorView({
                state: EditorState.create({
                    doc: initial,
                    extensions,
                }),
                parent: container
            });

            if (!readonly) {
                const form = textarea.closest('form');
                if (form) {
                    form.addEventListener('submit', () => {
                        textarea.value = this.view.state.doc.toString();
                    });
                }
            }
        });
    }
});
