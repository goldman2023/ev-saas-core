<div class="form-group categories-selector-wrapper {{ $class }}">
    @if (!empty(trim($label)))
        <label class="input-label">{{ $label }} {!! $required ? '<span class="text-danger">*</span>':'' !!}</label>
    @endif

        <select
        wire:ignore
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

        function initCategoriesSelectors() {
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

                    // Attach handlers
                    initCategoriesSelectors();
                } else if(sub_selector.length > 0 && Object.keys(selected.children).length > 0) {
                    let current_sub_selections = sub_selector.select2('data').map(x => x.id);

                    // Create new optgroup in sub_cat selector
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

                    // Attach handlers
                    initCategoriesSelectors();
                }
            });
        }

        initCategoriesSelectors();
    </script>
</div>
