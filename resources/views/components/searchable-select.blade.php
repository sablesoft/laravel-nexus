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
        function dotToCamel(str) {
            const parts = str.split('.');
            return parts[0] + parts.slice(1).map(part =>
                part.charAt(0).toUpperCase() + part.slice(1)
            ).join('');
        }
        const key = dotToCamel(field) + 'Selected{{ $key }}';
        let component = {
            field: field,
            selectOptions: options,

            init() {
                this.debug('Init', {
                    field: this.field,
                    options: this.selectOptions
                });
                const scopedEvent = this.field + '-updated-{{ $key }}';
                window.addEventListener(scopedEvent, (e) => {
                    this[key] = e.detail.value;
                    if (this[key]) {
                        this.$dispatch( this.field + '-selection', this[key]);
                    } else {
                        this.$dispatch( this.field + '-clear');
                    }
                    this.debug('Updated from Livewire', e.detail);
                });
            },
            debug(message, data) {
                Debug('searchable-select', field, {message, data});
            },

            // handlers:
            searchableInit() {
                this.debug('Send options to component', {options: this.selectOptions});
                this.$dispatch( this.field + '-options', this.selectOptions);
                if (this[key]) {
                    this.$dispatch( this.field + '-selection', this[key]);
                } else {
                    this.$dispatch( this.field + '-clear');
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
