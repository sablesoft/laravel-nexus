@props([
    'key' => '',
    'field' => '',
    'options' => []
])
<div x-data='searchableSelect{{ $key }}("{{ $field }}", @json($options))'>
    <x-searchable key="{{ $key }}" :keep-selected="true" :allow-new="false"
                  @searchable-init="searchableInit"
                  @searchable-selected="searchableSelected"
                  @searchable-cleared="searchableCleared"/>
</div>

@script
<!--suppress JSUnresolvedReference -->
<script>
    let componentName = "searchableSelect{{ $key }}"
    window[componentName] = function (field, options) {
        const key = '{{ $key }}';
        let component = {
            field: field,
            selectOptions: options,

            init() {
                this.debug('Init', {
                    field: this.field,
                    options: this.selectOptions
                });
                const eventAdded = this.field + '-options-{{ $key }}';
                window.addEventListener(eventAdded, (e) => {
                    this[key] = e.detail.value;
                    if (Array.isArray(e.detail.options)) {
                        this.selectOptions.splice(0, this.selectOptions.length, ...e.detail.options);
                    }
                    this.searchableInit();
                });
            },
            debug(message, data) {
                Debug('searchable-select', field, {message, data});
            },

            // handlers:
            searchableInit() {
                this.debug('Send options to component', {options: this.selectOptions});
                this.$dispatch( key + '-options', this.selectOptions);
                if (this[key]) {
                    this.$dispatch( key + '-selection', this[key]);
                } else {
                    this.$dispatch( key + '-clear');
                }
            },
            searchableSelected(e) {
                this.debug('Searchable selected', e);
                let option = e.detail.option;
                if (option && option.id) {
                    this[key] = option.id;
                    $wire.set(field, option.id);
                }
            },
            searchableCleared(e) {
                this.debug('Searchable cleared', e);
                this[key] = null;
                $wire.set(field, null);
            },

            get model() {
                return this[key];
            }
        }

        component[key] = $wire.entangle(field);

        return component;
    };
</script>
@endscript
