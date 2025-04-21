<div x-data="selectTags">

    <!-- Select and Create Tags & Categories -->
    <div class="flex flex-wrap gap-4 mb-4 items-end">

        <!-- Select Filtering Category -->
        <div class="flex-1">
            <label for="categories" class="block text-sm font-medium text-gray-700">{{ __('Select Category') }}</label>
            <x-searchable key="categories" :keep-selected="true" :allow-new="false"
                          title="{{ __('Category') }}"
                          @searchable-init="categoriesInit"
                          @searchable-selected="categorySelected"
                          @searchable-cleared="categoryCleared"/>
        </div>

        <!-- Select Tag -->
        <div class="flex-1">
            <label for="tags" class="block text-sm font-medium text-gray-700">{{ __('Select Tag') }}</label>
            <x-searchable key="tags" :keep-selected="false" :allow-new="$allowNew"
                          title="{{ __('Tag') }}"
                          @searchable-init="tagsInit"
                          @searchable-selected="tagSelected"
                          @searchable-cleared="tagCleared"/>
        </div>

        <!-- Hidden Block for Tag Creating -->
        <div x-show="newTagName" class="flex-1 flex items-center space-x-2 sm:mt-0">

            <!-- Select Parent Category for New Tag -->
            <div class="flex-1">
                <label for="parents" class="block text-sm font-medium text-gray-700">{{ __('Select Parent') }}</label>
                <x-searchable key="parents" :keep-selected="true" :allow-new="false"
                              title="{{ __('Parent') }}"
                              @searchable-init="parentsInit"
                              @searchable-selected="parentSelected"
                              @searchable-cleared="parentCleared"/>
            </div>

            <!-- Create New Tag -->
            <button @click.prevent="tagCreate" x-bind:disabled="!newTagName"
                    class="mt-5 bg-blue-500 text-white px-4 py-2 rounded-md shadow-sm focus:outline-none disabled:opacity-50 whitespace-nowrap">
                {{ __('New')}}
            </button>
        </div>

    </div>

    <!-- Selected Tags -->
    <div class="flex flex-wrap gap-2 mt-4">
        <template x-for="tag in selectedTags" :key="`selected-${tag.id}`">
            <div class="flex items-center bg-gray-200 px-3 py-1 rounded-full">
                <span x-text="tag.name" class="py-1 mr-2 sm:text-sm text-gray-500"></span>
                <button @click.prevent="tagRemove(tag.id)" class="text-gray-500 hover:text-gray-700">&times;</button>
            </div>
        </template>
    </div>
</div
@script
<script>
    Alpine.data('selectTags', () => {
        return {
            tags: $wire.entangle('tags'),
            categories: $wire.entangle('tagCategories'),
            selectedTagIds: $wire.entangle('selectedTagIds'),
            showTagsDebug: $wire.entangle('showTagsDebug'),

            selectedCategory: null,
            selectedParentId: null,
            newTagName : null,

            init() {
                this.debug('Init');
            },
            dispatchSelected() {
                let selected = this.selectedTags;
                this.debug('Wire tagsSelected', selected)
                $wire.call('tagsSelected');
            },

            // category handlers:
            categoriesInit() {
                this.debug('Dispatch categories', this.categories);
                this.$dispatch('searchable-categories', this.categories);
            },
            categorySelected(e) {
                this.debug('Category selected', e);
                this.selectedCategory = e.detail.option;
                this.tagsInit();
            },
            categoryCleared(e) {
                this.debug('Category cleared', e);
                this.selectedCategory = null;
                this.tagsInit();
            },

            // tag handlers:
            tagsInit() {
                this.debug('Dispatch tags', this.availableTags);
                this.$dispatch('tags-clear');
                this.$dispatch('tags-options', this.availableTags);
            },
            tagSelected(e) {
                this.debug('Tag selected', e);
                let option = e.detail.option;
                if (option.id) {
                    this.tagAttach(option.id);
                } else {
                    this.debug('New tag', option.name);
                    let present = this.tags.find(tag => tag.name === option.name);
                    if (present) {
                        this.$dispatch('tags-clear');
                    } else {
                        this.newTagName = option.name;
                    }
                }
            },
            tagAttach(id) {
                this.selectedTagIds.push(id);
                this.tagsInit();
                this.dispatchSelected();
            },
            tagCleared(e) {
                this.debug('Tag cleared', e);
                this.newTagName = null;
            },
            tagRemove(id) {
                this.debug('Tag remove', id);
                this.selectedTagIds = this.selectedTagIds.filter(tagId => tagId !== id);
                this.tagsInit();
                this.dispatchSelected();
            },
            tagCreate() {
                let tag = {
                    'name' : this.newTagName,
                    'parentId' : this.selectedParentId,
                };
                this.debug('Tag create', tag);
                $wire.call('createTag', tag.name, tag.parentId).then((tag) => {
                    this.debug('Tag created', tag);
                    this.newTagName = null;
                    this.selectedParentId = null;
                    this.categoriesInit();
                    this.tagAttach(tag.id);
                    this.parentsInit();
                });
            },

            // parent handlers:
            parentsInit() {
                this.debug('Dispatch parents', this.tags);
                this.$dispatch('parents-clear');
                this.$dispatch('parents-options', this.tags);
            },
            parentSelected(e) {
                this.debug('Parent selected', e);
                this.selectedParentId = e.detail.option.id;
            },
            parentCleared(e) {
                this.debug('Parent cleared', e);
                this.selectedParentId = null;
            },

            debug(message, data) {
                if (this.showTagsDebug) {
                    console.debug('[Workshop][Tags] ' + message, data);
                }
            },

            get availableTags() {
                let tags = this.selectedCategory ? this.selectedCategory.children : this.tags;
                this.debug('Available filtering', tags);
                return tags.filter(tag => !this.selectedTagIds.includes(tag.id));
            },

            get selectedTags() {
                this.debug('Selected filtering, Tags:', this.tags);
                this.debug('Selected filtering, selectedTagIds:', this.selectedTagIds);
                return this.tags.filter(tag => this.selectedTagIds.includes(tag.id));
            }
        }
    });
</script>
@endscript
