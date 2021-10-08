<div class="form-group categories-selector-wrapper {{ $class }}">
    @if (!empty(trim($label)))
        <label class="input-label">{{ $label }} {!! $required ? '<span class="text-danger">*</span>':'' !!}</label>
    @endif

        <select
        name="selected_categories"
        class="categories-selector js-select2-custom custom-select @error($errorBagName) is-invalid @enderror"
        data-hs-select2-options='{!! $options !!}'
        size="1" style="opacity: 0;"
        data-level="0"
        @if($multiple) multiple @endif
        {{ $attributes }}>

            @foreach($items as $item)
                <option value="{{ $item['slug_path'] }}">
                    {{ $item['name'] }}
                </option>
            @endforeach

        </select>

    @error($errorBagName)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror

    <script>
        let all_categories = @json($items);

        window.EV.form.select.initCategoriesSelectors = function() {
            $('.categories-selector').off('select2:unselect').on('select2:unselect', function(e) {
                let value = e.params.data.id; // value is slug_path which is dot notation of key accessor
                let level = value.split('.').length - 1;
                let unselected = value.replace(/([.])/g, ".children.").split('.').reduce((a, b) => a[b], all_categories);
                let current_selector = $('.categories-selector[data-level="'+level+'"]');
                let sub_selectors = $('.categories-selector[data-level]');

                if(sub_selectors.length > 1) {
                    // Check if any child category of the
                    sub_selectors.each(function(index, selector_html) {
                        if($(selector_html).data('level') > level) {
                            let sub_selected_data = $(selector_html).select2('data');
                            let sub_selected_data_new = [];
                            sub_selected_data.forEach(function(item, index) {
                                if(item.id.indexOf(value) === -1) {
                                    // If category (value, actually slug_path) is inside any of the sub-category slug_path, skip it!
                                    sub_selected_data_new.push(item);
                                }
                            });

                            // manually trigger the `select2:select` event by selecting again previously selected data
                            $(selector_html).val(sub_selected_data_new.length > 0 ? sub_selected_data_new.map(x => x.id) : []);
                            // remove optgroup in subselector
                            $(selector_html).find(`[id^="group-${unselected.slug_path}"]`).remove();

                            $(selector_html).trigger('change');

                            if(sub_selected_data_new.length <= 0 && current_selector.val().length <= 0) {
                                $(selector_html).select2('destroy');
                                $(selector_html).remove();
                            }
                        }
                    });
                }
            });

            $('.categories-selector').off('select2:select').on('select2:select', function(e) {
                let value = e.params.data.id; // value is slug_path which is dot notation of key accessor
                if(value === undefined) {
                    return;
                }

                let level = value.split('.').length - 1;
                let selected = value.replace(/([.])/g, ".children.").split('.').reduce((a, b) => a[b], all_categories);
                let selector = $('.categories-selector[data-level="'+level+'"]');
                let sub_selector = $('.categories-selector[data-level="'+(level+1)+'"]');

                // Check if select field with certain level exists
                if(sub_selector.length <= 0 && Object.keys(selected.children).length > 0) {

                    let options = [`<optgroup id="group-${selected.slug_path}" label="${selected.title_path.replace('.', ' / ')}">`];
                    for (const slug in selected.children) {
                        options.push(`
                        <option value="${selected.children[slug].slug_path}">
                            ${selected.children[slug].name}
                        </option>
                        `);
                    }
                    options.push(`</optgroup>`);

                    let content = `
                        <select
                            name="selected_categories"
                            class="categories-selector js-select2-custom custom-select @error($errorBagName) is-invalid @enderror"
                            size="1" style="opacity: 0;"
                            data-level="${level+1}"
                            data-hs-select2-options='${ '{!! $options !!}'.replace('categories-selector-level-0', 'categories-selector-level-'+(level+1)) }'
                            @if($multiple) multiple @endif
                    {{ $attributes }}>

                        </select>
                    `;

                    $(content).insertAfter($('.categories-selector-level-'+level).closest('.select2-container'));

                    let sub_selector = $('.categories-selector[data-level="'+(level+1)+'"]');
                    $.HSCore.components.HSSelect2.init(sub_selector);
                    sub_selector.append($(options.join(' ')));
                    // IMPORTANT: After appending, it has to be initialized again!!! Otherwise selecting won't work as expected!!!!
                    $.HSCore.components.HSSelect2.init(sub_selector);

                    // ReAttach handlers
                    window.EV.form.select.initCategoriesSelectors();
                } else if(sub_selector.length > 0 && Object.keys(selected.children).length > 0) {
                    let current_sub_selections = sub_selector.select2('data').map(x => x.id);

                    // Create new optgroup in sub_cat selector
                    if($(`#group-${selected.slug_path}`).length > 0) {
                        return;
                    }

                    let new_options = [`
                        <optgroup id="group-${selected.slug_path}" label="${selected.title_path.replace('.', ' / ')}">
                    `];
                    for (const slug in selected.children) {
                        new_options.push(`
                        <option value="${selected.children[slug].slug_path}">
                            ${selected.children[slug].name}
                        </option>
                        `);
                    }
                    new_options.push(`</optgroup>`);

                    if(sub_selector.find('optgroup').last().length > 0) {
                        $(new_options.join(' ')).insertAfter(sub_selector.find('optgroup').last());
                    } else {
                        sub_selector.append($(new_options.join(' ')));
                    }

                    // init change event
                    $(sub_selector).select2('destroy');

                    $.HSCore.components.HSSelect2.init(sub_selector);

                    // manually trigger the `select2:select` event by selecting again previously selected data
                    sub_selector.val(current_sub_selections);
                    sub_selector.trigger('change');

                    // ReAttach handlers
                    window.EV.form.select.initCategoriesSelectors();
                }


                if(e.params.level !== undefined && e.params.selected_items !== undefined && e.params.selected_items[e.params.level] !== undefined && e.params.selected_items[e.params.level].length > 0) {
                    $('.categories-selector[data-level="'+e.params.level+'"]').val(e.params.selected_items[e.params.level].map(x => x.id));
                    e.params.selected_items[e.params.level].forEach(function(item) {
                        $('.categories-selector[data-level="'+e.params.level+'"]').trigger('change').trigger({
                            type: 'select2:select',
                            params: {
                                data: item,
                                level: e.params.level + 1,
                                selected_items: e.params.selected_items
                            }
                        });
                    });
                }

            });
        }

        /**
         * This is fired when Categories-Selector component has to set previously selected values (as when changing steps in product form etc)
         */
        window.EV.form.select.preselectCategories = function(data) {
            if(data.length > 0) {
                let selected = [];

                data.forEach(function(category_path, index) {
                    let cat_level = category_path.split('.').length - 1;
                    let category = category_path.replace(/([.])/g, ".children.").split('.').reduce((a, b) => a[b], all_categories);

                    if(selected[cat_level] === undefined) {
                        selected[cat_level] = [{
                            id: category_path,
                            text: category.name
                        }];
                    } else {
                        selected[cat_level].push({
                            id: category_path,
                            text: category.name
                        });
                    }
                });

                // Select proper values

                if(selected[0].length > 0) {
                    $('.categories-selector[data-level="0"]').val(selected[0].map(x => x.id)).trigger('change');
                    selected[0].forEach(function(item) {
                        $('.categories-selector[data-level="0"]').trigger({
                            type: 'select2:select',
                            params: {
                                data: item,
                                level: 1,
                                selected_items: selected
                            }
                        });
                    });
                }
            }
        }


        window.EV.form.select.initCategoriesSelectors();
    </script>
</div>
