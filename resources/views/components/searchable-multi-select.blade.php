<div x-data='multiSelect("{{ $field }}", @json($options))' class="mb-4">

    <div class="flex flex-wrap gap-4 mb-4 items-end">

        <!-- Select Items -->
        <div class="flex-1">
            <x-searchable id="{{ $field }}" :keep-selected="false" :allow-new="false" title="Select"
                          @searchable-init="multiSearchableInit"
                          @searchable-selected="multiSearchableSelected"/>
        </div>

    </div>

    <!-- Selected Items -->
    <div class="flex flex-wrap gap-2 mt-4">
        <template x-for="searchable in selectedMultiSearchables" :key="`selected-${searchable.id}`">
            <div class="flex items-center bg-gray-200 px-3 py-1 rounded-full">
                <span x-text="searchable.name" class="py-1 mr-2 sm:text-sm text-gray-500"></span>
                <button @click.prevent="multiSearchableRemove(searchable.id)"
                        class="text-gray-500 hover:text-gray-700">&times;</button>
            </div>
        </template>
    </div>
</div
@script
<!--suppress JSUnresolvedReference -->
<script>
    window.multiSelect = function (field, options) {
        let component = {
            field: field,
            multiSearchableOptions: options,

            init() {
                this.debug('Init', {
                    field: this.field,
                    options: this.multiSearchableOptions,
                    selected: this[this.selectedField()]
                });
            },

            // searchables handlers:
            multiSearchableInit(e) {
                if (e && e.detail.searchableId !== this.field) {
                    return;
                }
                this.debug('Send options to component', {options: this.availableMultiSearchables});
                this.$dispatch( this.field + '-clear');
                this.$dispatch( this.field + '-options', this.availableMultiSearchables);
            },
            multiSearchableSelected(e) {
                if (e.detail.searchableId !== this.field) {
                    return;
                }
                let option = e.detail.option;
                if (option.id) {
                    this.multiSearchableAttach(option.id);
                } else {
                    this.debug('Invalid searchable', option);
                }
            },
            multiSearchableAttach(id) {
                this[this.selectedField()].push(id);
                this.multiSearchableInit();
            },
            multiSearchableRemove(id) {
                this.debug('Searchable remove', id);
                this[this.selectedField()] =
                    this[this.selectedField()].filter(
                        searchableId => searchableId !== id
                    );
                this.multiSearchableInit();
            },

            debug(message, data) {
                Debug('crud-searchable-multi-select', field, {message, data});
            },

            selectedField() {
                return this.field + 'Selected';
            },

            get availableMultiSearchables() {
                return this.multiSearchableOptions.filter(
                    searchable => !this[this.selectedField()].includes(searchable.id)
                );
            },

            get selectedMultiSearchables() {
                if (!this[this.selectedField()]) {
                    return [];
                }
                return this.multiSearchableOptions.filter(
                    searchable => this[this.selectedField()].includes(searchable.id)
                );
            }
        }

        component[field + 'Selected'] = $wire.entangle('state.' + field);

        return component;
    }
</script>
@endscript
