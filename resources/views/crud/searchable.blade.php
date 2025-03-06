<div x-data="select_{{ $field }}">
    <x-searchable id="{{ $field }}" :keep-selected="true" :allow-new="false"
                  @searchable-init="searchableInit"
                  @searchable-selected="searchableSelected"
                  @searchable-cleared="searchableCleared"/>
    <input type="hidden" x-model="model" value="{{ $state[$field] }}">
</div>

@script
<script>
    Alpine.data('select_{{ $field }}', () => {
        return {
            field: '{{ $field }}',
            model: $wire.entangle("state.{{ $field }}"),
            selectOptions: @json($options),
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

            // handlers:
            searchableInit() {
                this.debug('Send options to component', {options: this.selectOptions});
                this.$dispatch( this.field + '-options', this.selectOptions);
                if (this.model) {
                    this.$dispatch( this.field + '-selection', this.model);
                } else {
                    this.$dispatch( this.field + '-clear');
                }
            },
            searchableSelected(e) {
                this.debug('Searchable selected', e);
                let option = e.detail.option;
                if (option.id) {
                    this.model = option.id;
                }
            },
            searchableCleared(e) {
                this.debug('Searchable cleared', e);
                this.model = null;
            },
        }
    });
</script>
@endscript
