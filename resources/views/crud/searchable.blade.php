<div x-data='searchableSelect("{{ $field }}", @json($options))'>
    <x-searchable id="{{ $field }}" :keep-selected="true" :allow-new="false"
                  @searchable-init="searchableInit"
                  @searchable-selected="searchableSelected"
                  @searchable-cleared="searchableCleared"/>
    <input type="hidden" x-model="model" value="{{ $state[$field] }}">
</div>

@script
<script>
    window.searchableSelect = function (field, options) {
        let component = {
            field: field,
            selectOptions: options,
            showSearchableSelectDebug: false, // todo

            init() {
                this.debug('Init', {
                    field: this.field,
                    options: this.selectOptions
                });
            },
            debug(message, data) {
                if (this.showSearchableSelectDebug) {
                    console.debug('[Workshop][Searchable] ' + message, data);
                }
            },

            selectedField() {
                return this.field + 'Selected';
            },

            // handlers:
            searchableInit() {
                this.debug('Send options to component', {options: this.selectOptions});
                this.$dispatch( this.field + '-options', this.selectOptions);
                if (this[this.selectedField()]) {
                    this.$dispatch( this.field + '-selection', this[this.selectedField()]);
                } else {
                    this.$dispatch( this.field + '-clear');
                }
            },
            searchableSelected(e) {
                this.debug('Searchable selected', e);
                let option = e.detail.option;
                if (option.id) {
                    this[this.selectedField()] = option.id;
                }
            },
            searchableCleared(e) {
                this.debug('Searchable cleared', e);
                this[this.selectedField()] = null;
            },

            get model() {
                return this[this.selectedField()];
            }
        }

        component[field + 'Selected'] = $wire.entangle('state.' + field);

        return component;
    };
</script>
@endscript
