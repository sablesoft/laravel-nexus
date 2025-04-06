@props([
    'key' => '',
    'field' => '',
    'options' => []
])
<div x-data='searchableSelect{{ $key }}("{{ $field }}", @json($options))'>
    <x-searchable id="{{ $field }}" :keep-selected="true" :allow-new="false"
                  @searchable-init="searchableInit"
                  @searchable-selected="searchableSelected"
                  @searchable-cleared="searchableCleared"/>
</div>

@script
<!--suppress JSUnresolvedReference -->
<script>
    let componentName = "searchableSelect{{ $key }}"
    window[componentName] = function (field, options) {
        let component = {
            field: field,
            selectOptions: options,

            init() {
                this.debug('Init', {
                    field: this.field,
                    options: this.selectOptions
                });
            },
            debug(message, data) {
                Debug('searchable-select', field, {message, data});
            },

            selectedField() {
                return this.field + 'Selected{{ $key }}';
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
                    $wire.set('state.' + field, option.id);
                }
            },
            searchableCleared(e) {
                this.debug('Searchable cleared', e);
                this[this.selectedField()] = null;
                $wire.set('state.' + field, null);
            },

            get model() {
                return this[this.selectedField()];
            }
        }

        component[field + "Selected{{ $key }}"] = $wire.entangle('state.' + field);

        return component;
    };
</script>
@endscript
