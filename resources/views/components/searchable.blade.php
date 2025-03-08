@props([
    'id' => 'searchable',
    'title' => 'Search & Select',
    'keepSelected' => false,
    'allowNew' => false,
    'showSearchableDebug' => false
])

<div x-data="searchable('{{ $id }}', '{{ $title }}', @json($keepSelected), @json($allowNew), @json($showSearchableDebug))"
    {{ $attributes->merge(['class' => 'relative']) }}>
    <button @click.prevent="toggleDropdown" class="w-full px-4 py-2 bg-gray-200 rounded-md shadow-sm text-left cursor-pointer">
        <span x-text="title"></span>
        <template x-if="selectedOption">
            <button @click.stop.prevent="clearSelection" class="ml-2 text-red-500 hover:text-red-700">&times;</button>
        </template>
    </button>

    <div x-show="dropdownOpen" @click.away="closeDropdown" class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg max-h-48 overflow-y-auto">
        <!--suppress HtmlFormInputWithoutLabel -->
        <input type="text" x-model="searchQuery" @keydown.enter.prevent="selectNewOption" placeholder="Search..." class="w-full px-4 py-2 border-b border-gray-300 focus:outline-none">
        <ul>
            <template x-for="option in filteredOptions" :key="option.id">
                <li @click.prevent="selectOption(option)" class="cursor-pointer px-4 py-2 hover:bg-gray-100" x-text="option.name"></li>
            </template>
        </ul>
    </div>
</div>

@script
<script>
    Alpine.data('searchable',  (id, title, keepSelected, allowNew, showSearchableDebug) => {
        return {
            id: id,
            defaultTitle: title,
            allowNew: allowNew,
            keepSelected: keepSelected,
            showSearchableDebug: showSearchableDebug,

            title: title,
            options: [],
            allFilteredOptions: [],
            selectedOption: null,
            dropdownOpen: false,
            searchQuery: '',

            init() {
                this.searchableDebug('Init', {
                    id: this.id,
                    defaultTitle : this.defaultTitle,
                    allowNew: this.allowNew,
                    keepSelected: this.keepSelected
                });
                this.addEventListeners();
                setTimeout(() => {
                    this.dispatch('init');
                }, 100);
            },
            addEventListeners() {
                document.addEventListener('searchable-' + this.id, this.loadOptions.bind(this));
                document.addEventListener(this.id + '-options', this.loadOptions.bind(this));
                document.addEventListener(this.id + '-selection', this.loadSelection.bind(this));
                document.addEventListener(this.id + '-clear', this.clearSelection.bind(this));
            },
            loadOptions(e) {
                this.options = e.detail;
                this.searchableDebug('Options loaded', this.options);
            },
            loadSelection(e) {
                this.selectedOption = this.options.find(option => option.id === e.detail);
                this.title = this.selectedOption.name;
                this.searchQuery = '';
                this.dropdownOpen = false;
            },

            dispatch(name, data) {
                this.searchableDebug('Dispatch ' + name, data);
                this.$dispatch(this.id + '-' + name, data);
                data = data ? data : {};
                data.searchableId = this.id;
                this.$dispatch('searchable-' + name, data);
            },

            toggleDropdown() {
                this.dropdownOpen = !this.dropdownOpen;
                if (this.dropdownOpen) {
                    this.searchQuery = '';
                    this.allFilteredOptions = this.options;
                    this.searchableDebug('Dropdown shown');
                }
            },
            closeDropdown() {
                this.dropdownOpen = false;
                this.searchableDebug('Dropdown closed');
            },

            selectOption(option) {
                if (this.keepSelected || !option.id) {
                    this.selectedOption = option;
                    this.title = option.name;
                    this.searchableDebug('Title changed', option);
                }
                this.searchQuery = '';
                this.dropdownOpen = false;
                this.dispatch('selected', { option: option });
            },
            selectNewOption() {
                if (this.allowNew && this.searchQuery.trim().length > 0) {
                    let newOption = { id: null, name: this.searchQuery.trim() };
                    this.selectOption(newOption);
                    this.searchableDebug('New option selected', newOption);
                }
            },
            clearSelection() {
                let clearedOption = this.selectedOption;
                this.selectedOption = null;
                this.title = this.defaultTitle;
                this.dispatch('cleared', { option: clearedOption });
            },

            searchableDebug(message, data) {
                if (this.showSearchableDebug) {
                    console.debug('[Searchable][' + this.id + '] ' + message, data);
                }
            },

            get filteredOptions() {
                let query = this.searchQuery.toLowerCase();
                this.searchableDebug('Filtering options', this.searchQuery);
                return this.options.filter(option => option.name.toLowerCase().includes(query));
            },

            watch: {
                searchQuery() {
                    this.allFilteredOptions = this.getFilteredOptions();
                }
            }
        };
    });
</script>
@endscript
