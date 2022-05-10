<div class="w-full  " 
        x-data="selector()" 
        x-init="
            displayed_items = all_categories; 
            items = all_categories_flat; 
            $watch('search_query', (value) => {
                if(value == '') {
                    displayed_items = all_categories;
                    return;
                }

                let newItems = {};
                
                Object.values(items).filter(entry => {
                    if (entry['name'].toLowerCase().indexOf(value.toLowerCase()) !== -1) {
                        newItems[entry['slug']] = entry;
                        return true;
                    }
                });

                displayed_items = newItems;
            })
        "
        >

    <div class="w-full border-b border-gray-200 pb-4 mb-0 px-2">
        <input type="text" class="form-standard w-full focus:ring-0 " placeholder="{{ translate('Search categories') }}" x-model.debounce.500ms="search_query" />
    </div>

    <fieldset class="space-y-1 max-h-[790px] overflow-y-auto">
        <ul>
            <template x-for="(category, slug) in displayed_items">
                <li class="block" x-effect="$nextTick(() => { $el.innerHTML = renderCategory(category, slug); })"></li>
            </template>
        </ul>
    </fieldset>

    <x-system.invalid-msg field="selected_categories"></x-system.invalid-msg>
</div>

<script>
    function selector() {
        return {
            items: [],
            displayed_items: [],
            search_query: '',
            renderCategory(category, slug) {
                let hasChildren = category.children !== null && category.children !== undefined && Object.keys(category.children).length > 0;
                // let show_children = ;

                let html = `
                    <div x-data='{
                        has_children: ${hasChildren},
                        slug_path: "${category.slug_path}",
                        show_children: selected_categories.indexOf("${category.slug_path}") !== -1,
                        // Move following two functions outside the recursion!
                        selectCategory(slug_path) {
                            this.show_children = !this.show_children;
                            let index = selected_categories.indexOf(slug_path);

                            if(index === -1) {
                                selected_categories.push(slug_path);
                            } else {
                                selected_categories.splice(index, 1);
                            }

                            this.deselectAllChildren(slug_path);
                            $dispatch("hide-children-categories", {parent_slug_path: slug_path});
                        },
                        deselectAllChildren(slug_path) {
                            selected_categories = selected_categories.filter((cat_slug_path) => {
                                return !cat_slug_path.startsWith(slug_path+".");
                            });
                        },
                    }' @hide-children-categories.window='if(slug_path.startsWith($event.detail.parent_slug_path+".")) show_children = false;'>
                        <div class='relative flex items-start justify-between py-2 cursor-pointer' x-on:click='selectCategory(category.slug_path);'>
                            <div class='w-full flex items-center cursor-pointer'>
                                <div class='flex items-center h-6 cursor-pointer'>
                                    <input type='checkbox' :checked='selected_categories.indexOf(category.slug_path) !== -1'  class='pointer-events-none focus:ring-primary h-5 w-5 text-primary border-gray-300 rounded'>
                                </div>
                                <div class='ml-3 text-16'>
                                    <label class='font-medium text-gray-700 cursor-pointer' x-text='category.name'></label>
                                </div>
                            </div>
                            <div class='w-full flex items-center justify-end'>
                                <div class='badge-info mr-2' x-show='has_children' x-text="category.descendants_count"></div>
                                @svg('heroicon-o-chevron-right', ['class' => 'h-4 w-4', ':class' => "{'rotate-90':show_children}", 'x-show' => 'has_children'])
                            </div>
                            
                        </div>
                `;

                if(hasChildren) {
                    html += `
                        <ul class='pl-5' x-show='show_children'>
                            <template x-for='(category, slug) in category.children'>
                                <li class='block' x-effect='$nextTick(() => { $el.innerHTML = renderCategory(category, slug); })'></li>
                            </template>
                        </ul>
                    `;
                }

                html += `</div>`;

                return html;
            }
        }
    }
</script>