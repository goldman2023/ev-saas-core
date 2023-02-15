<div class="lw-form container-fluid" x-data="{
        thumbnail: @js(toJSONMedia($productAddon->thumbnail)),
        cover: @js(toJSONMedia($productAddon->cover)),
        meta_img: @js(toJSONMedia($productAddon->meta_img)),
        gallery: @js(toJSONMedia($productAddon->gallery)),
        
        base_currency: @js($productAddon->base_currency),
        status: @js($productAddon->status ?? \App\Enums\StatusEnum::draft()->value),
        type: @js($productAddon->type ?? \App\Enums\ProductAddonTypeEnum::draft()->value),
        use_serial: @js($productAddon->use_serial),
        allow_out_of_stock_purchases: @js($productAddon->allow_out_of_stock_purchases),
        discount_type: @js($productAddon->discount_type),
        track_inventory: @js($productAddon->track_inventory),

        description: @entangle('productAddon.description').defer,

        attributes: @js($custom_attributes),
        selected_predefined_attribute_values: @js($selected_predefined_attribute_values),
        selected_categories: @js($selected_categories),
        predefined_types: @js(\App\Enums\AttributeTypeEnum::getPredefined() ?? []),

        // Relationships
        selected_products: @js($productAddon->products->pluck('id')),
        selected_taxonomies: @js($productAddon->category_taxonomy->pluck('id')),

        core_meta: @js($core_meta),
        wef: @js($wef),

        onSave() {
            $wire.set('productAddon.description', this.description, true);

            $wire.set('productAddon.thumbnail', this.thumbnail.id, true);
            $wire.set('productAddon.cover', this.cover.id, true);
            $wire.set('productAddon.meta_img', this.meta_img.id, true);
            $wire.set('productAddon.gallery', this.gallery, true);

            $wire.set('productAddon.base_currency', this.base_currency, true);
            $wire.set('productAddon.discount_type', this.discount_type, true);
            $wire.set('productAddon.track_inventory', this.track_inventory, true);
            $wire.set('productAddon.use_serial', this.use_serial, true);
            $wire.set('productAddon.allow_out_of_stock_purchases', this.allow_out_of_stock_purchases, true);

            $wire.set('productAddon.status', this.status, true);
            $wire.set('productAddon.type', this.type, true);

            $wire.set('selected_categories', this.selected_categories, true);
            $wire.set('selected_predefined_attribute_values', this.selected_predefined_attribute_values, true);
            $wire.set('custom_attributes', this.attributes, true);

            $wire.set('wef', this.wef, true);
            $wire.set('core_meta', this.core_meta, true);
        }
    }"
@init-product-form.window=""
@validation-errors.window="console.log($event.detail.errors);" x-cloak>

    <div class="w-full relative">
        <x-ev.loaders.spinner class="absolute-center z-10 hidden" wire:target="saveProductAddon"
            wire:loading.class.remove="hidden"></x-ev.loaders.spinner>

        <div class="w-full" wire:loading.class="opacity-30 pointer-events-none" wire:target="saveProductAddon">

            <div class="sm:grid sm:grid-cols-12 gap-8 mb-10">
                {{-- Left side --}}
                <div class="sm:col-span-8  ">

                    {{-- Basic --}}
                    <div class="p-4 border bg-white border-gray-200 rounded-lg shadow">
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('Basic info') }}</h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ translate('This is basic and required
                                info about the product addon') }}</p>
                        </div>

                        <div class="mt-6 sm:mt-3 space-y-6 sm:space-y-5">
                            <!-- Title -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                x-data="{}">

                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Name') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <x-dashboard.form.input field="productAddon.name" placeholder="{{ translate('New product addon title') }}" />
                                </div>
                            </div>
                            <!-- END Title -->

                            <!-- Excerpt -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                x-data="{}">

                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Excerpt') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <x-dashboard.form.textarea field="productAddon.excerpt" rows="4" placeholder="{{ translate('Write a short promo description for this product addon') }}" />
                                </div>
                            </div>
                            <!-- END Excerpt -->

                            <!-- Description -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                x-data="{}" wire:ignore>

                                <label class="col-span-3 block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Description') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-3">
                                    <x-dashboard.form.editor-js field="description" structure-field="wef.content_structure" id="product-addon-description-wysiwyg" />

                                    <x-system.invalid-msg class="w-full" field="productAddon.description" />
                                </div>
                            </div>
                            <!-- END Description -->
                        </div>
                    </div>
                    {{-- END Basic --}}

                    {{-- Relationships --}}
                    <div class="p-4 border bg-white border-gray-200 rounded-lg shadow mt-5 sm:mt-8" >
                        <div class="mb-6 pb-4 border-b border-gray-200">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('Addon Relationships') }}</h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ translate('Attach product addon to products or categories') }}</p>
                        </div>

                        <div class="sm:mt-3 space-y-6 sm:space-y-5">
                            <!-- Products -->
                            <div
                                class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Products') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <x-dashboard.form.select :items="\App\Models\Product::published()->get()->keyBy('id')->map(fn($item) => $item->name)"
                                        selected="selected_products" :multiple="true" :nullable="false" :search="true"></x-dashboard.form.select>
                                </div>
                            </div>
                            <!-- END Products -->

                            <!-- Products -->
                            <div
                                class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Category Taxonomy') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <x-dashboard.form.select :items="collect(\Categories::getAllFormatted(for_js: true, flat: true))->keyBy('id')->map(fn($item) => $item['name'])"
                                        selected="selected_taxonomies" :multiple="true" :nullable="false" :search="true"></x-dashboard.form.select>
                                </div>
                            </div>
                            <!-- END Products -->
                        </div>
                    </div>
                    {{-- END Relationships --}}

                    {{-- Pricing --}}
                    <div class="p-4 border bg-white border-gray-200 rounded-lg shadow mt-5 sm:mt-8" >
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('Pricing') }}</h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ translate('Product addon pricing details') }}</p>
                        </div>

                        <div class="mt-6 sm:mt-3 space-y-6 sm:space-y-5">
                            <!-- Price -->
                            <div
                                class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Price') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <div class="grid grid-cols-10 gap-3">
                                        <div class="col-span-6">
                                            <x-dashboard.form.input type="number" step="0.01" min="0" 
                                                field="productAddon.unit_price" placeholder="0.00" />
                                        </div>

                                        <div class="col-span-4" x-data="{}">
                                            <x-dashboard.form.select :items="\FX::getAllCurrencies(formatted: true)"
                                                selected="base_currency" :nullable="false"></x-dashboard.form.select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END Price -->

                            <!-- Discount and Discount type -->
                            <div
                                class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Discount') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <div class="grid grid-cols-10 gap-3">
                                        <div class="col-span-6">
                                            <x-dashboard.form.input type="number" step="0.01" min="0" 
                                                field="productAddon.discount" placeholder="0.00" />
                                        </div>

                                        <div class="col-span-4" x-data="{}">
                                            <x-dashboard.form.select
                                                :items="\App\Enums\AmountPercentTypeEnum::toArray()"
                                                selected="discount_type" :nullable="false"></x-dashboard.form.select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END Discount and Discount type -->
                        </div>
                    </div>
                    {{-- END Pricing --}}

                    {{-- Attributes --}}
                    <div class="p-4 border bg-white border-gray-200 rounded-lg shadow mt-5 sm:mt-8" x-data="{}"
                        wire:ignore>
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('Attributes') }}</h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ translate('Enrich your productaddons with
                                additional data') }}</p>
                        </div>

                        <div class="mt-6 sm:mt-3 space-y-6 sm:space-y-5">
                            <template x-for="attribute in attributes">
                                <div class="w-full mb-3" x-data="{
                                        getSelectorID() {
                                            return 'attributes_'+this.attribute.id+'_attribute_values';
                                        },
                                        hasCustomProperty(name) {
                                            return this.attribute.custom_properties !== null &&
                                                    this.attribute.custom_properties !== undefined &&
                                                    this.attribute.custom_properties.hasOwnProperty(name);
                                        },
                                        getMinValue() {
                                            return this.hasCustomProperty('min_value') ? this.attribute.custom_properties.min_value : 0;
                                        },
                                        getMaxValue() {
                                            return this.hasCustomProperty('max_value') ? this.attribute.custom_properties.max_value : 999;
                                        },
                                        getMinRows() {
                                            return this.hasCustomProperty('min_rows') ? this.attribute.custom_properties.min_rows : 0;
                                        },
                                        getMaxRows() {
                                            return this.hasCustomProperty('max_rows') ? this.attribute.custom_properties.max_rows : 999;
                                        },
                                    }" x-cloak>

                                    {{-- Dropdown --}}
                                    <template x-if="attribute.type === 'dropdown'">
                                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 "
                                            x-data="{
                                                items: attribute.attribute_values,
                                                selected_items: selected_predefined_attribute_values['attribute.'+attribute.id],
                                                show: false,
                                                multiple: hasCustomProperty('multiple') && attribute.custom_properties.multiple,
                                                tag: false,
                                                countSelected() {
                                                    if(this.selected_items === undefined || this.selected_items === null) {
                                                        this.selected_items = [];
                                                    }

                                                    return this.selected_items.length;
                                                },
                                                getPlaceholder() {
                                                    if(this.countSelected() === 1) {
                                                        return this.items.find(x => {
                                                            return x.id == this.selected_items[0];
                                                        }).values || '';
                                                    } else if(this.countSelected() > 1) {
                                                        return '';
                                                    } else {
                                                        return '{{ translate('Choose option(s)') }}';
                                                    }
                                                },
                                                isSelected(key) {
                                                    return this.selected_items.indexOf(key) !== -1 ? true : false;
                                                },
                                                select(key, label) {
                                                    if(this.isSelected(key)) {
                                                        this.selected_items.splice(this.selected_items.indexOf(key), 1);
                                                    } else {
                                                        if(!this.multiple) {
                                                            this.selected_items = [key];
                                                        } else {
                                                            this.selected_items.push(Number(key));
                                                        }
                                                    }

                                                    if(!this.multiple) {
                                                        this.show = false;
                                                        this.placeholder = label;
                                                    }

                                                    selected_predefined_attribute_values['attribute.'+attribute.id] = this.selected_items;
                                                }
                                            }">
                                            <div
                                                class="justify-center h-full col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                                <span class="text-sm font-medium text-gray-900"
                                                    x-text="attribute.name"></span>
                                            </div>

                                            <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full">

                                                <div class="we-select relative w-full" x-data="{}"
                                                    @click.outside="show = false">
                                                    <div class="we-select__selector select-none w-full flex flex-wrap border pl-3 pt-2 pb-1 pr-6 relative cursor-pointer"
                                                        @click="show = !show">
                                                        @svg('heroicon-o-chevron-down', ['class' =>
                                                        'we-select__selector-arrow absolute w-[16px] h-[16px]
                                                        vertical-center', ':class' => "{'rotate-180': show}"])

                                                        <template x-if="!multiple">
                                                            <span class="block pb-1" x-text="getPlaceholder()"></span>
                                                        </template>

                                                        <template x-if="multiple">
                                                            <div class="w-full flex flex-wrap">
                                                                <template x-if="countSelected() > 0">
                                                                    <template x-for="item in items.filter(x => {
                                                                        return selected_items.indexOf(x.id) !== -1;
                                                                    })">
                                                                        <div
                                                                            class="we-select__selector-selected-item rounded mr-2 mb-1 relative">
                                                                            <span
                                                                                class="we-select__selector-selected-item-label pl-1 mr-1"
                                                                                x-text="item.values"></span>
                                                                            <button type="button"
                                                                                class="we-select__selector-selected-item-remove px-2"
                                                                                @click="event.stopPropagation(); select(item.id, item.values)">
                                                                                <span>×</span>
                                                                            </button>
                                                                        </div>
                                                                    </template>
                                                                </template>
                                                                <template x-if="countSelected() <= 0">
                                                                    <span class="block pb-1"
                                                                        x-text="getPlaceholder()"></span>
                                                                </template>
                                                            </div>
                                                        </template>
                                                    </div>

                                                    <div class="we-select__dropdown  absolute bg-white shadow border rounded mt-1  w-full"
                                                        x-show="show">
                                                        <ul class="we-select__dropdown-list select-none w-full">
                                                            <template x-for="item in items">
                                                                <li class="we-select__dropdown-list-item py-2 px-3 cursor-pointer"
                                                                    x-text="item.values"
                                                                    :class="{'selected': isSelected(item.id) }"
                                                                    @click="select(item.id, item.values)"></li>
                                                            </template>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <template
                                                    x-if="hasCustomProperty('multiple') && attribute.custom_properties.multiple">
                                                    <!-- Used for variations? -->
                                                    <div class="flex items-center pt-3 " x-data="{}">
                                                        <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                                            <span class="text-sm font-medium text-gray-900">{{
                                                                translate('Used for variations') }}</span>
                                                        </div>

                                                        <div
                                                            class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">

                                                            <button type="button"
                                                                @click="attribute.for_variations = !attribute.for_variations"
                                                                :class="{'bg-primary':attribute.for_variations, 'bg-gray-200':!attribute.for_variations}"
                                                                class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                                                                role="switch">
                                                                <span
                                                                    :class="{'translate-x-5':attribute.for_variations, 'translate-x-0':!attribute.for_variations}"
                                                                    class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <!-- END Used for variations? -->
                                                </template>
                                            </div>
                                        </div>
                                    </template>
                                    {{-- END Dropdown --}}


                                    {{-- Plain Text --}}
                                    <template x-if="attribute.type === 'plain_text'">
                                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                            x-data="{}">

                                            <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"
                                                x-text="attribute.name"></label>

                                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                <input type="text" class="form-standard"
                                                    :id="'attributes_'+attribute.id+'_attribute_values'"
                                                    x-model="attribute.attribute_values[0].values" />
                                            </div>
                                        </div>
                                    </template>
                                    {{-- END Plain Text --}}

                                    {{-- Number --}}
                                    <template x-if="attribute.type === 'number'">
                                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                            x-data="{}">

                                            <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"
                                                x-text="attribute.name"></label>

                                            <div class="mt-1 sm:mt-0 sm:col-span-2 flex rounded-md shadow-sm">
                                                <input type="number"
                                                    :id="'attributes_'+attribute.id+'_attribute_values'"
                                                    x-bind:min="getMinValue()" x-bind:max="getMaxValue()"
                                                    x-model="attribute.attribute_values[0].values"
                                                    class="form-standard !rounded-r-none">

                                                <template x-if="hasCustomProperty('unit')">
                                                    <span x-text="attribute.custom_properties.unit"
                                                        class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm"></span>
                                                </template>
                                            </div>
                                        </div>
                                    </template>
                                    {{-- END Number --}}


                                    {{-- Date --}}
                                    <template x-if="attribute.type === 'date'">
                                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                            x-data="{
                                                getDateOptions() {
                                                    let options = {
                                                        mode: 'single',
                                                        enableTime: false,
                                                    };

                                                    if(this.hasCustomProperty('with_time') && this.attribute.custom_properties.with_time) {
                                                        options.enableTime = true;
                                                        options.dateFormat = 'd.m.Y H:i';
                                                    } else {
                                                        options.dateFormat = 'd.m.Y';
                                                    }

                                                    if(this.hasCustomProperty('range') && this.attribute.custom_properties.range) {
                                                        options.mode = 'range';
                                                    }

                                                    return options;
                                                },
                                            }"
                                            x-init="$nextTick(() => { flatpickr('.js-flatpickr', getDateOptions()); });">

                                            <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"
                                                x-text="attribute.name"></label>

                                            <div class="mt-1 sm:mt-0 sm:col-span-2 flex rounded-md shadow-sm">
                                                <input x-model="attribute.attribute_values[0].values" type="text"
                                                    class="js-flatpickr flatpickr-custom form-standard"
                                                    placeholder="{{ translate('Pick a date(s)') }}" data-input />
                                            </div>
                                        </div>
                                    </template>
                                    {{-- END Date --}}


                                    {{-- Checkbox --}}
                                    <template x-if="attribute.type === 'checkbox'">
                                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                            x-data="{}">

                                            <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"
                                                x-text="attribute.name"></label>

                                            <div
                                                class="mt-1 sm:mt-0 sm:col-span-2 flex flex-col rounded-md shadow-sm space-y-4">
                                                <template
                                                    x-for="(attribute_value, index) in attribute.attribute_values">
                                                    <div class="relative flex items-center "
                                                        :class="{'!mt-0': index === 0}">
                                                        <div class="flex items-center h-6">
                                                            <input type="checkbox"
                                                                x-model="selected_predefined_attribute_values['attribute.'+attribute.id]"
                                                                :value="attribute_value.id"
                                                                :id="'attribute_'+attribute_value.id"
                                                                class="form-checkbox-standard">
                                                        </div>
                                                        <div class="ml-3 text-sm">
                                                            <label class="font-medium text-gray-700 cursor-pointer"
                                                                x-text="attribute_value.values"
                                                                :for="'attribute_'+attribute_value.id"></label>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </template>
                                    {{-- END Checkbox --}}

                                    {{-- Radio --}}
                                    <template x-if="attribute.type === 'radio'">
                                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                            x-data="{}">

                                            <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"
                                                x-text="attribute.name"></label>

                                            <div
                                                class="mt-1 sm:mt-0 sm:col-span-2 flex flex-col rounded-md shadow-sm space-y-4">
                                                <template
                                                    x-for="(attribute_value, index) in attribute.attribute_values">
                                                    <div class="relative flex items-center "
                                                        :class="{'!mt-0': index === 0}">
                                                        <div class="flex items-center h-6">
                                                            <input type="radio"
                                                                x-model="selected_predefined_attribute_values['attribute.'+attribute.id]"
                                                                :value="attribute_value.id"
                                                                :id="'attribute_'+attribute_value.id"
                                                                class="form-radio-standard">
                                                        </div>
                                                        <div class="ml-3 text-sm">
                                                            <label class="font-medium text-gray-700 cursor-pointer"
                                                                x-text="attribute_value.values"
                                                                :for="'attribute_'+attribute_value.id"></label>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </template>
                                    {{-- END Radio --}}


                                    {{-- Text List --}}
                                    <template x-if="attribute.type === 'text_list'">
                                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                            x-data="{
                                                items: attribute.attribute_values.map(x => x.values),
                                                hasID(index) {
                                                    return attribute.attribute_values[index].hasOwnProperty('id') && !isNaN(attribute.attribute_values[index].id) ? true : false;
                                                },
                                                count() {
                                                    if(this.attribute.attribute_values === undefined || this.attribute.attribute_values === null) {
                                                        this.attribute.attribute_values = [{
                                                            values: ''
                                                        }];
                                                    }

                                                    return this.attribute.attribute_values.length;
                                                },
                                                add() {
                                                    if(this.count() < getMaxRows()) {
                                                        this.attribute.attribute_values.push({
                                                            values: ''
                                                        });
                                                    }
                                                },
                                                remove(index) {
                                                    if(this.hasID(index)) {
                                                        $wire.removeAttributeValue(attribute.attribute_values[index].id);
                                                    }

                                                    attribute.attribute_values.splice(index, 1);
                                                },
                                            }" x-init="
                                                if(getMinRows() > 1) {
                                                    for(let i=1; i < getMinRows(); i++) {
                                                        add();
                                                    }
                                                }
                                            ">
                                            {{-- $watch('items', items => {
                                            items.forEach((item, index) => {
                                            if(attribute.attribute_values[index] === undefined ||
                                            attribute.attribute_values[index] === null) {
                                            attribute.attribute_values[index] = {
                                            values: item
                                            };
                                            } else {
                                            attribute.attribute_values[index].values = item;
                                            }
                                            });

                                            let diff = attribute.attribute_values.length - items.length;

                                            if(diff > 0) {
                                            Remove difference between attribute.attribute_values and mapped items.
                                            attribute.attribute_values = attribute.attribute_values.slice(0, -(diff));
                                            }
                                            }); --}}
                                            <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"
                                                x-text="attribute.name"></label>

                                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                <template x-if="count() <= 1">
                                                    <div class="flex w-full">
                                                        <input type="text" class="form-standard "
                                                            placeholder="{{ translate('Value 1') }}"
                                                            x-model="items[0]" />
                                                    </div>
                                                </template>
                                                <template x-if="count() > 1">
                                                    <template
                                                        x-for="(attribute_value, key) in attribute.attribute_values">
                                                        <div class="flex" :class="{'mt-2': key > 0}">
                                                            <input type="text" class="form-standard"
                                                                :id="'attribute-'+attribute.id+'-text-list-input-'+key"
                                                                x-bind:placeholder="'{{ translate('Value') }} '+(Number(key)+1)"
                                                                x-model="attribute_value.values" />
                                                            <template x-if="(key+1) > getMinRows()">
                                                                <span class="ml-2 flex items-center cursor-pointer"
                                                                    @click="remove(key)">
                                                                    @svg('heroicon-o-trash', ['class' => 'w-[22px]
                                                                    h-[22px] text-danger'])
                                                                </span>
                                                            </template>
                                                        </div>
                                                    </template>
                                                </template>

                                                <div href="javascript:;" class="btn-ghost !pl-0 !text-14 mt-1"
                                                    @click="add()" x-show="count() < getMaxRows()">
                                                    @svg('heroicon-o-plus', ['class' => 'h-3 w-3 mr-2'])
                                                    {{ translate('Add new') }}
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                    {{-- END Text List --}}

                                    {{-- Image --}}
                                    <template x-if="attribute.type === 'image'">
                                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                            x-data="{}">

                                            <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"
                                                x-text="attribute.name"></label>

                                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                <div class="w-full" x-data="{
                                                    id: 'attributes_'+attribute.id+'_attribute_values',
                                                    file_name: '',
                                                }" @we-media-selected-event.window="
                                                    if($event.detail.for_id === id) {
                                                        attribute.attribute_values[0].values = $event.detail.selected[0]['id'] || '';
                                                        file_name = $event.detail.selected[0]['file_name'] || '';
                                                    }
                                                ">
                                                    <div class="max-w-lg flex justify-center border-2 border-gray-300 border-dashed rounded-md cursor-pointer"
                                                        :class="{'px-6 pt-5 pb-6': attribute.attribute_values[0].values !== undefined && attribute.attribute_values[0].values !== null && attribute.attribute_values[0].values > 0 }"
                                                        @click="$wire.emit('showMediaLibrary', id, 'image', [{id:attribute.attribute_values[0].values, file_name:file_name}])">

                                                        <template
                                                            x-if="attribute.attribute_values[0].values !== undefined && attribute.attribute_values[0].values !== null && attribute.attribute_values[0].values > 0">
                                                            <div class="h-[200px] w-full rounded cursor-pointer">
                                                                <img class="w-full h-[200px] object-contain"
                                                                    x-bind:src="window.WE.IMG.url(file_name)" />
                                                            </div>
                                                        </template>

                                                        <template
                                                            x-if="!(attribute.attribute_values[0].values !== undefined && attribute.attribute_values[0].values !== null && attribute.attribute_values[0].values > 0)">
                                                            <div class="space-y-1 text-center py-7">
                                                                <svg class="mx-auto h-12 w-12 text-gray-400"
                                                                    stroke="currentColor" fill="none"
                                                                    viewBox="0 0 48 48" aria-hidden="true">
                                                                    <path
                                                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" />
                                                                </svg>
                                                                <div class="flex text-sm text-gray-600">
                                                                    <label
                                                                        class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                                        <span>{{ translate('Select a file') }}</span>
                                                                    </label>
                                                                    <p class="pl-1">{{ translate('or drag and drop') }}
                                                                    </p>
                                                                </div>
                                                                <p class="text-xs text-gray-500">{{ translate('PNG, JPG,
                                                                    GIF up to 3MB') }}</p>
                                                            </div>
                                                        </template>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                    {{-- END Image --}}

                                    {{-- TODO: Add wysiwyg, gallery, country type attribute --}}
                                </div>
                            </template>
                        </div>
                    </div>
                    {{-- END Attributes --}}


                    {{-- Inventory --}}
                    <div class="p-4 border bg-white border-gray-200 rounded-lg shadow mt-5 sm:mt-8" x-data="{}">
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('Inventory') }}</h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ translate('Track your product addon inventory')
                                }}</p>
                        </div>

                        <div class="mt-6 sm:mt-3 space-y-6 sm:space-y-5">

                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 "
                                x-data="{}">
                                <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                    <span class="text-sm font-medium text-gray-900">{{ translate('Track inventory?') }}</span>
                                </div>

                                <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                    <x-dashboard.form.toggle field="track_inventory" />
                                </div>
                            </div>


                            <div class="w-full space-y-6 sm:space-y-5" x-show="track_inventory">
                                {{-- SKU --}}
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                    x-data="{}">

                                    <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                        {{ translate('SKU') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <x-dashboard.form.input field="productAddon.sku" 
                                            placeholder="{{ translate('Product SKU') }}" />

                                        <small class="text-muted">{{ translate('Leave empty if you want to add only SKU
                                            of the variations.') }}</small>
                                    </div>
                                </div>
                                {{-- END SKU --}}

                                {{-- Barcode --}}
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                    x-data="{}">

                                    <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                        {{ translate('Barcode') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <x-dashboard.form.input field="productAddon.barcode" 
                                            placeholder="{{ translate('Product barcode') }}" />

                                        <small class="text-muted">{{ translate('Leave empty if you want to add only
                                            Barcode of the variations.') }}</small>
                                    </div>
                                </div>
                                {{-- END Barcode --}}

                                {{-- Use serial numbers --}}
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 "
                                    x-data="{}">
                                    <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                        <span class="text-sm font-medium text-gray-900">{{ translate('Uses serial numbers?') }}</span>
                                    </div>

                                    <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                        <x-dashboard.form.toggle field="use_serial" />
                                    </div>
                                </div>
                                {{-- END Use serial numbers --}}

                                {{-- Allow out of stock purchases --}}
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 "
                                    x-data="{}">
                                    <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                        <span class="text-sm font-medium text-gray-900">{{ translate('Allow selling even
                                            when out of stock?') }}</span>
                                    </div>

                                    <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                        <x-dashboard.form.toggle field="allow_out_of_stock_purchases" />
                                    </div>
                                </div>
                                {{-- END Allow out of stock purchases --}}

                                <div class="w-full" x-show="!use_serial">
                                    <!-- Minimum quantity user can purchase -->
                                    {{-- <div
                                        class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                        <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                            {{ translate('Minimum quantity user can purchase') }}
                                        </label>

                                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                                            <div class="grid grid-cols-10 gap-3">
                                                <div class="col-span-6">
                                                    <x-dashboard.form.input type="number" step="0.01" min="0" 
                                                        field="productAddon.min_qty" placeholder="0.00" />
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <!-- END Minimum quantity user can purchase -->

                                    <!-- Stock quantity -->
                                    <div
                                        class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4">
                                        <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                            {{ translate('Stock quantity') }}
                                        </label>

                                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                                            <div class="grid grid-cols-10 gap-3">
                                                <div class="col-span-6">
                                                    <x-dashboard.form.input type="number" step="0.01" min="0" 
                                                        field="productAddon.current_stock" placeholder="0.00" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END Stock quantity -->
                                </div>

                                {{-- Unit --}}
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                    x-data="{}">

                                    <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                        {{ translate('Unit') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <div class="grid grid-cols-10 gap-3">
                                            <div class="col-span-6">
                                                <x-dashboard.form.input field="productAddon.unit" 
                                                    placeholder="{{ translate('Product unit') }}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- END Unit --}}

                                <!-- Low stock quantity -->
                                <div
                                    class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                    <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                        {{ translate('Low stock quantity') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <div class="grid grid-cols-10 gap-3">
                                            <div class="col-span-6">
                                                <x-dashboard.form.input type="number" step="0.01" min="0" 
                                                        field="productAddon.low_stock_qty" placeholder="0.00" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END Low stock quantity -->
                            </div>

                        </div>
                    </div>
                    {{-- END Inventory --}}


                    {{-- Card Shipping --}}
                    {{-- <div class="p-4 border bg-white border-gray-200 rounded-lg shadow mt-5 sm:mt-8" x-data="{}"
                        x-show="type != 'digital' && type != 'event'">
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('Shipping') }}</h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ translate('Set available delivery options
                                for your product') }}</p>
                        </div>

                        <div class="mt-6 sm:mt-3 space-y-6 sm:space-y-5">
                            <!-- Is digital product? -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 "
                                x-data="{}">
                                <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                    <span class="text-sm font-medium text-gray-900">{{ translate('Is this a digital
                                        product?') }}</span>
                                </div>

                                <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                    <x-dashboard.form.toggle field="is_digital" />
                                </div>
                            </div>


                            <div class="w-full" x-show="is_digital">
                                TODO: Add Shipping methods first and then edit this part
                            </div>
                        </div>
                    </div> --}}
                    {{-- END Card Shipping --}}
                </div>
                {{-- END Left side --}}


                {{-- Right side --}}
                <div class="col-span-4">
                    {{-- Actions --}}
                    <div class="p-4 border bg-white border-gray-200 rounded-lg shadow">
                        <!-- Status -->
                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:pt-5">
                            <label class="flex items-center text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                <span class="mr-2">{{ translate('Status') }}</span>

                                @if($productAddon->status === App\Enums\StatusEnum::published()->value)
                                <span class="badge-success">{{ ucfirst($productAddon->status) }}</span>
                                @elseif($productAddon->status === App\Enums\StatusEnum::draft()->value)
                                <span class="badge-warning">{{ ucfirst($productAddon->status) }}</span>
                                @elseif($productAddon->status === App\Enums\StatusEnum::pending()->value)
                                <span class="badge-info">{{ ucfirst($productAddon->status) }}</span>
                                @elseif($productAddon->status === App\Enums\StatusEnum::private()->value)
                                <span class="badge-dark">{{ ucfirst($productAddon->status) }}</span>
                                @endif
                            </label>

                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                <x-dashboard.form.select :items="\App\Enums\StatusEnum::toArray('archived')"
                                    selected="status" :nullable="false"></x-dashboard.form.select>
                            </div>
                        </div>
                        <!-- END Status -->

                        <!-- Product Type -->
                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:pt-5">
                            <label class="flex items-center text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                <span class="mr-2">{{ translate('Product Type') }}</span>
                            </label>

                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                <x-dashboard.form.select :items="\App\Enums\ProductAddonTypeEnum::toArray()" selected="type"
                                    :nullable="false"></x-dashboard.form.select>
                            </div>
                        </div>
                        <!-- END Product Type -->

                        <div
                            class="w-full flex justify-between sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5">
                            @if($productAddon->id ?? null)
                                <button type="button" class="btn btn-danger btn-sm cursor-pointer">
                                    {{ translate('Delete') }}
                                </button>
                            @endif

                            <button type="button" class="btn btn-primary ml-auto btn-sm" @click="onSave()"
                                wire:click="saveProductAddon()">
                                {{ translate('Save') }}
                            </button>
                        </div>
                    </div>
                    {{-- END Actions --}}

                    {{-- Media --}}
                    <div class="p-4 mt-8 border bg-white border-gray-200 rounded-lg shadow">
                        <div class="w-full flex items-center justify-between border-b border-gray-200 pb-3 mb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('Media') }}</h3>
                        </div>

                        <div class="w-full">
                            {{-- Thumbnail --}}
                            <div class="sm:items-start">
                                <div class="flex flex-col " x-data="{}">

                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ translate('Thumbnail image') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0">
                                        <x-dashboard.form.file-selector field="thumbnail"
                                            error-field="productAddon.thumbnail" id="product-thumbnail-image"
                                            :selected-image="$productAddon->thumbnail"></x-dashboard.form.file-selector>
                                    </div>
                                </div>
                            </div>
                            {{-- END Thumbnail --}}

                            {{-- Cover --}}
                            <div class="sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5">
                                <div class="flex flex-col " x-data="{}">

                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ translate('Cover image') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0">
                                        <x-dashboard.form.file-selector field="cover" error-field="productAddon.cover"
                                            id="product-cover-image" :selected-image="$productAddon->cover">
                                        </x-dashboard.form.file-selector>
                                    </div>
                                </div>
                            </div>
                            {{-- END Cover --}}

                            {{-- Gallery --}}
                            <div class="sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5">
                                <div class="flex flex-col " x-data="{}">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ translate('Gallery') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0">
                                        <x-dashboard.form.file-selector
                                            id="product-gallery"
                                            field="gallery"
                                            error-field="productAddon.gallery"
                                            :file-type="\App\Enums\FileTypesEnum::image()->value"
                                            :selected-image="$productAddon->gallery"
                                            :multiple="true"
                                            add-new-item-label="{{ translate('Add new image') }}"></x-dashboard.form.file-selector>
                                    </div>
                                </div>
                            </div>
                            {{-- END Gallery --}}
                        </div>
                    </div>
                    {{-- END Media --}}

                    {{-- Category Selector --}}
                    <div class="mt-8 border bg-white border-gray-200 rounded-lg shadow select-none" x-data="{
                            open: true,
                        }" :class="{'p-4': open}">
                        <div class="w-full flex items-center justify-between cursor-pointer " @click="open = !open"
                            :class="{'border-b border-gray-200 pb-4 mb-4': open, 'p-4': !open}">
                            <h3
                                class="text-lg leading-6 font-medium text-gray-900 @error('selected_categories') !text-danger @enderror">
                                {{ translate('Categories') }}</h3>
                            @svg('heroicon-o-chevron-down', ['class' => 'h-4 w-4', ':class' => "{'rotate-180':open}"])
                        </div>

                        <div class="w-full" x-show="open">
                            <x-dashboard.form.category-selector> </x-dashboard.form.category-selector>
                        </div>
                    </div>
                    {{-- END Category Selector --}}

                    {{-- Core Meta --}}
                    <x-dashboard.form.blocks.core-meta-form></x-dashboard.form.blocks.core-meta-form>
                    {{-- Core Meta --}}

                    {{-- SEO --}}
                    <x-dashboard.global.meta-fields model-field="productAddon" :model="$productAddon"></x-dashboard.global.meta-fields>
                    {{-- END SEO --}}
                </div>
                {{-- END Right side --}}
            </div>
        </div>
    </div>
</div>
