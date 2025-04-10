import {EditorView, basicSetup} from "codemirror"
import {EditorState} from "@codemirror/state"
import {json} from "@codemirror/lang-json"
import {yaml} from "@codemirror/lang-yaml"
import {oneDark} from "@codemirror/theme-one-dark"
import * as jsYaml from "js-yaml"
import {autocompletion} from "@codemirror/autocomplete"

window.codeMirrorComponent = (lang = 'yaml', readonly = false) => ({
    view: null,

    init() {
        this.$nextTick(async () => {
            const textarea = this.$refs.textarea;
            const container = this.$refs.editorContainer;
            const key = this.$el.dataset.codemirrorKey;

            container.innerHTML = '';
            let initial = textarea.value ?? '';
            if (lang === 'yaml') {
                initial = this.normalizeMultilineYaml(initial);
            }

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

            // DSL autocompletion
            if (!readonly && lang === 'yaml') {
                const schema = await fetch('/api/dsl/schema')
                    .then(res => res.json())
                    .then(json => json.effects)
                    .catch(() => ({}));

                const effectAutocomplete = (context) => {
                    const word = context.matchBefore(/\w*/);
                    if (!word || word.from === word.to) return null;

                    const options = Object.entries(schema).map(([key, def]) => ({
                        label: key,
                        type: "keyword",
                        info: def.description || '',
                        apply: key + ': ',
                    }));

                    return {
                        from: word.from,
                        options,
                    };
                };

                extensions.push(
                    autocompletion({
                        override: [effectAutocomplete],
                    })
                );
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

                window.addEventListener('codemirror:update', (e) => {
                    if (e.detail?.key !== key) return;

                    let newValue = e.detail.value ?? '';
                    if (lang === 'yaml') {
                        newValue = this.normalizeMultilineYaml(newValue);
                    }
                    const currentValue = this.view.state.doc.toString();

                    if (newValue !== currentValue) {
                        this.view.dispatch({
                            changes: { from: 0, to: this.view.state.doc.length, insert: newValue }
                        });

                        textarea.value = newValue;
                        textarea.dispatchEvent(new Event('input', { bubbles: true }));
                    }
                });
            }
        });
    },

    normalizeMultilineYaml(value) {
        try {
            const parsed = jsYaml.load(value);
            return jsYaml.dump(parsed, {
                lineWidth: 120, // folding 120
                styles: {
                    '!!str': '|' // force literal block for multiline
                }
            });
        } catch (e) {
            return value;
        }
    }
});
