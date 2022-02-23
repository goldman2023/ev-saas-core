<div x-data="{
        status: @js($product->status ?? App\Enums\StatusEnum::draft()->value),
        is_digital: {{ $product->digital === true ? 'true' : 'false' }},
        use_serial: {{ $product->use_serial === 1 ? 'true' : 'false' }},
        base_currency: @js($product->base_currency),
        discount_type: @js($product->discount_type),
        tax_type: @js($product->tax_type),
        attributes: @js($attributes),
        selected_attribute_values: @js($selected_predefined_attribute_values),
        predefined_types: @js(\App\Enums\AttributeTypeEnum::getPredefined() ?? []),
        onSave() {
            $wire.set('product.description', $('[name=\'product.description\']').val(), true);
            $wire.set('product.thumbnail', $('[name=\'product.thumbnail\']').val(), true);
            $wire.set('product.gallery', $('[name=\'product.gallery\']').val(), true);
            $wire.set('product.pdf', $('[name=\'product.pdf\']').val(), true);
            $wire.set('product.video_provider', getSafe(fn => $('[name=\'product.video_provider\']').select2('data')[0].id, null), true);
            $wire.set('product.base_currency', getSafe(fn => $('[name=\'product.base_currency\']').select2('data')[0].id, null), true);
            $wire.set('product.discount_type', getSafe(fn => $('[name=\'product.discount_type\']').select2('data')[0].id, null), true);
            $wire.set('product.tax_type', getSafe(fn => $('[name=\'product.tax_type\']').select2('data')[0].id, null), true);
            $wire.set('product.use_serial', this.use_serial, true);
            $wire.set('product.digital', this.is_digital, true);
            $wire.set('selected_predefined_attribute_values', this.selected_attribute_values, true);
            $wire.set('attributes', this.attributes, true);
            $wire.set('product.meta_img', $('[name=\'product.meta_img\']').val(), true);
            $wire.set('product.status', this.status, true);
            $wire.set('product.tags', $('[name=\'product.tags\']').select2('data').map(x => x.id), true);
            let $selected_categories = [];
            $('[name=\'selected_categories\']').each(function(index, item) {
                $selected_categories = [...$selected_categories, ...$(item).select2('data').map(x => x.id)];
            });
            $wire.set('selected_categories', $selected_categories, true);
            $wire.set('product.brand_id', getSafe(fn => $('[name=\'product.brand_id\']').select2('data')[0].id, null), true);
        }
    }"
     class="lw-form container-fluid"
     @init-product-form.window=""
     @validation-errors.window="$scrollToErrors($event.detail.errors, 700);"
     x-cloak>

    <div class="position-relative">
        <x-ev.loaders.spinner class="absolute-center z-10 d-none"
                              wire:target="saveProduct"
                              wire:loading.class.remove="d-none"></x-ev.loaders.spinner>

        {{-- FIXME: The opacity issue --}}
        <div class="row w-100"
            wire:loading.class="opacity-6 prevent-pointer-events"
            wire:target="saveProduct">

            {{-- Left column --}}
            <div class="col-12 col-md-8">
                {{-- Card Basic --}}
                <div class="card mb-3 mb-lg-5">
                    <div class="card-body position-relative">
                        <h5 class="pb-2 mb-3 border-bottom">{{ translate('Basic info') }}</h5>

                        <div class="w-100">
                            <x-ev.form.input name="product.name" class="form-control-sm" type="text" label="{{ translate('Title') }}" :required="true" placeholder="{{ translate('Think of some catchy name...') }}" />

                            <x-ev.form.textarea name="product.excerpt" label="{{ translate('Excerpt (short description)') }}" >
                                <small class="text-muted">{{ translate('If you leave excerpt empty, first 320 chars of description will be used as an excerpt.') }}</small>
                            </x-ev.form.textarea>

                            {{-- TODO: Add a function to check height of the content - if it's bigger then height of the editor, make editor bigger! Same as Shopify! --}}
                            <x-ev.form.wysiwyg name="product.description" options='{"height":"300px","minHeight":"300px"}' label="{{ translate('Product Description') }}" placeholder=""></x-ev.form.wysiwyg>
                        </div>
                    </div>
                </div>
                {{-- END Card Basic --}}


                {{-- Card Media --}}
                <div class="card mb-3 mb-lg-5" x-data="{
                        show_video: {{ !empty($product->video_link) ? 'true':'false' }},
                        show_pdf: {{ !empty($product->pdf) ? 'true':'false' }},
                    }">
                    <div class="card-body position-relative pb-2">
                        <h5 class="pb-2 mb-3 border-bottom">{{ translate('Media') }}</h5>

                        <div class="w-100">
                            <!-- Images -->
                            <x-ev.form.file-selector name="product.thumbnail" class="form-control-sm" label="{{ translate('Thumbnail') }}" data_type="image" placeholder="{{ translate('Choose file...') }}" :required="true"></x-ev.form.file-selector>
                            <x-ev.form.file-selector name="product.gallery" class="form-control-sm" label="{{ translate('Gallery') }}" :multiple="true" data_type="image" placeholder="{{ translate('Choose file...') }}"
                                                    :sortable="true"
                                                    :sortable-options='["animation" => 150, "group" => "photosPreviewGroup"]'
                            ></x-ev.form.file-selector>

                            <div class="w-100 d-flex mb-4">
                                <label class="toggle-switch mr-3">
                                    <input type="checkbox" x-model="show_video" class="js-toggle-switch toggle-switch-input">
                                    <span class="toggle-switch-label">
                                        <span class="toggle-switch-indicator"></span>
                                    </span>

                                    <span class="ml-3">{{ translate('Has video') }}</span>
                                </label>

                                <label class="toggle-switch mx-2">
                                    <input type="checkbox" x-model="show_pdf" class="js-toggle-switch toggle-switch-input">
                                    <span class="toggle-switch-label">
                                        <span class="toggle-switch-indicator"></span>
                                    </span>

                                    <span class="ml-3">{{ translate('Has specification document') }}</span>
                                </label>
                            </div>

                            <div class="w-100" :class="{'d-none': !show_video}">
                                <!-- Video -->
                                <x-ev.form.select name="product.video_provider" :items="EVS::getMappedVideoProviders()" label="{{ translate('Video provider') }}"  placeholder="{{ translate('Select the provider...') }}" />
                                <x-ev.form.input name="product.video_link" class="form-control-sm" type="text" label="{{ translate('Video link') }}" placeholder="{{ translate('Link to the video...') }}" >
                                    <small class="text-muted">{{ translate('Use proper link without extra parameter. Don\'t use short share link/embeded iframe code.') }}</small>
                                </x-ev.form.input>
                            </div>

                            <div class="w-100" :class="{'d-none': !show_pdf}">
                                <!-- PDF Specification -->
                                <x-ev.form.file-selector name="product.pdf" class="form-control-sm" label="{{ translate('PDF Specification (optional)') }}" datatype="document" placeholder="{{ translate('Choose file...') }}"></x-ev.form.file-selector>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- END Card Media --}}

                {{-- Card Pricing --}}
                <div class="card mb-3 mb-lg-5" x-data="{
                        show_tax: {{ !empty($product->tax) ? 'true':'false' }},
                    }">
                    <div class="card-body position-relative">
                        <h5 class="pb-2 mb-3 border-bottom">{{ translate('Pricing') }}</h5>

                        <div class="w-100">
                            <!-- Price -->
                            <div class="row form-group">
                                <div class="col-12 col-sm-7">
                                    <label class="w-100">{{ translate('Price') }}</label>

                                    <div class="input-group input-group-sm-down-break">
                                        <input type="number"
                                                step="0.01"
                                                min="0"
                                                class="form-control form-control-sm @error('product.unit_price') is-invalid @enderror"
                                                placeholder="{{ translate('0.00') }}"
                                                wire:model.defer="product.unit_price" />
                                    </div>

                                    <x-default.system.invalid-msg field="product.unit_price" type="slim"></x-default.system.invalid-msg>
                                </div>

                                <div class="col-12 col-sm-5"  x-init="
                                    $('#product-base_currency').on('select2:select', (event) => {
                                        base_currency = event.target.value;
                                    });
                                    $watch('base_currency', (value) => {
                                        $('#product-base_currency').val(value).trigger('change');
                                    });
                                ">
                                    <label class="w-100">{{ translate('Base currency') }}</label>

                                    <select class="form-control custom-select custom-select-sm"
                                            name="product.base_currency"
                                            id="product-base_currency"
                                            x-model="base_currency"
                                            data-hs-select2-options='{
                                                "minimumResultsForSearch": "Infinity",
                                                "selectionCssClass": "custom-select-sm"
                                            }'>
                                        @foreach(\FX::getAllCurrencies() as $currency)
                                            <option value="{{ $currency->code }}" >
                                                {{ $currency->code }} ({{ $currency->symbol }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- END Price -->

                            <!-- Discount and Discount type -->
                            <div class="row form-group mt-3">

                                <div class="col-12 col-sm-7">
                                    <label class="w-100">{{ translate('Discount') }}</label>

                                    <div class="input-group input-group-sm-down-break">
                                        <input type="number" step="0.01" class="form-control form-control-sm @error('product.discount') is-invalid @enderror"
                                                name="product.discount"
                                                id="product-discount"
                                                min="0"
                                                placeholder="{{ translate('Product discount (fixed or percentage)') }}"
                                                wire:model.defer="product.discount" />
                                    </div>

                                    <x-default.system.invalid-msg field="product.discount" type="slim"></x-default.system.invalid-msg>
                                </div>

                                <div class="col-12 col-sm-5" x-data="{}" x-init="
                                    $('#product-discount_type').on('select2:select', (event) => {
                                        discount_type = event.target.value;
                                    });
                                    $watch('discount_type', (value) => {
                                        $('#product-discount_type').val(value).trigger('change');
                                    });
                                ">
                                    <label class="w-100">{{ translate('Discount type') }}</label>

                                    <select class="form-control custom-select custom-select-sm"
                                            name="product.discount_type"
                                            id="product-discount_type"
                                            x-model="discount_type"
                                            data-hs-select2-options='{
                                                "minimumResultsForSearch": "Infinity",
                                                "selectionCssClass": "custom-select-sm"
                                        }'>
                                        @foreach(\App\Enums\AmountPercentTypeEnum::toArray() as $type => $label)
                                            <option value="{{ $type }}" >
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- END Discount and discount type -->

                            <!-- Has additional fee -->
                            <div class="w-100 d-flex">
                                <label class="toggle-switch mr-3">
                                    <input type="checkbox" x-model="show_tax" class="js-toggle-switch toggle-switch-input">
                                    <span class="toggle-switch-label">
                                        <span class="toggle-switch-indicator"></span>
                                    </span>

                                    <span class="ml-3">{{ translate('Additional fee') }}</span>
                                </label>
                            </div>

                            <!-- Tax and Tax type -->
                            <div class="row form-group mt-3" :class="{'d-none': !show_tax}">
                                <div class="col-12 col-sm-7">
                                    <label class="w-100 ">{{ translate('Additional Fee') }}</label>

                                    <div class="input-group input-group-sm-down-break">
                                        <input type="number" step="0.01" class="form-control @error('product.tax') is-invalid @enderror"
                                                name="product.tax"
                                                id="product-tax"
                                                min="0"
                                                placeholder="{{ translate('Additional fee (fixed or percentage)') }}"
                                                wire:model.defer="product.tax" />
                                    </div>

                                    <x-default.system.invalid-msg field="product.tax" type="slim"></x-default.system.invalid-msg>
                                </div>

                                <div class="col-12 col-sm-5" x-data="{}" x-init="
                                    $('#product-tax_type').on('select2:select', (event) => {
                                        tax_type = event.target.value;
                                    });
                                    $watch('tax_type', (value) => {
                                        $('#product-tax_type').val(value).trigger('change');
                                    });
                                ">
                                    <label class="w-100">{{ translate('Fee type') }}</label>

                                    <select class="form-control custom-select custom-select-sm"
                                            name="product.tax_type"
                                            id="product-tax_type"
                                            x-model="tax_type"
                                            data-hs-select2-options='{
                                                "minimumResultsForSearch": "Infinity"
                                        }'>
                                        @foreach(\App\Enums\AmountPercentTypeEnum::toArray() as $type => $label)
                                            <option value="{{ $type }}" >
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- END Tax and Tax type -->

                            <hr class="my-2 mt-3" />

                            <div class="row form-group mt-0 mb-0">
                                <div class="col-12">
                                    <label class="w-100 col-form-label input-label pt-1">{{ translate('Cost per item') }}</label>

                                    <div class="input-group input-group-sm-down-break">
                                        <input type="number"
                                                step="0.01"
                                                min="0"
                                                class="form-control form-control-sm @error('product.purchase_price') is-invalid @enderror"
                                                placeholder="{{ translate('0.00') }}"
                                                wire:model.defer="product.purchase_price" />

                                        <small class="w-100 mt-2">
                                            {{ translate('Customers won\'t see this. For your reference and reports only.') }}
                                        </small>
                                    </div>

                                    <x-default.system.invalid-msg field="product.purchase_price" type="slim"></x-default.system.invalid-msg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- END Card Pricing --}}


                {{-- Card Inventory --}}
                <div class="card mb-3 mb-lg-5" x-data="{}">
                    <div class="card-body position-relative">
                        <h5 class="pb-2 mb-3 border-bottom">{{ translate('Inventory') }}</h5>

                        <div class="w-100">
                            <div class="row form-group mt-0 mb-0">
                                <div class="col-12 col-sm-6">
                                    <x-ev.form.input name="product.sku" class="form-control-sm" groupclass="mb-0" type="text" label="{{ translate('SKU (Stock keeping unit)') }}" placeholder="{{ translate('SKU of the main product (not variations).') }}" >
                                        <small class="text-muted">{{ translate('Leave empty if you want to add only SKU of the variations.') }}</small>
                                    </x-ev.form.input>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <x-ev.form.input name="product.barcode" class="form-control-sm" groupclass="mb-0" type="text" label="{{ translate('Barcode (ISBN, UPC, GTIN, etc.)') }}" placeholder="{{ translate('Barcode of the main product (not variations).') }}" >
                                        <small class="text-muted">{{ translate('Leave empty if you want to add only Barcode of the variations.') }}</small>
                                    </x-ev.form.input>
                                </div>
                            </div>
                        </div>

                        <!-- Uses Serial -->
                        <div class="w-100 pt-3 d-flex">
                            <label class="toggle-switch mr-3">
                                <input type="checkbox" x-model="use_serial" class="js-toggle-switch toggle-switch-input">
                                <span class="toggle-switch-label">
                                    <span class="toggle-switch-indicator"></span>
                                </span>

                                <span class="ml-3">{{ translate('Uses serial numbers?') }}</span>
                            </label>
                        </div>
                        <!-- END Uses Serial -->

                        <!-- Allow out of stock purchases -->
                        <div class="w-100 pt-2 d-flex">
                            <label class="toggle-switch mr-3">
                                <input type="checkbox" wire:model.defer="product.allow_out_of_stock_purchases" class="js-toggle-switch toggle-switch-input">
                                <span class="toggle-switch-label">
                                    <span class="toggle-switch-indicator"></span>
                                </span>

                                <span class="ml-3">{{ translate('Allow selling even when out of stock?') }}</span>
                            </label>
                        </div>
                        <!-- END Allow out of stock purchases -->

                        <!-- Standard Inventory tracking -->
                        <div class="w-100 pt-3" :class="{'d-none': use_serial}">
                            <x-ev.form.input name="product.min_qty" class="form-control-sm"  type="number" label="{{ translate('Minimum quantity user can purchase') }}" :required="true" min="1" step="1">
                                <small class="text-muted">{{ translate('This is the minimum quantity user can purchase.') }}</small>
                            </x-ev.form.input>

                            <x-ev.form.input name="product.current_stock" class="form-control-sm" groupclass="mb-0" type="number" label="{{ translate('Stock quantity') }}" :required="true"  min="0" step="1">
                                <small class="text-muted">{{ translate('This is the current stock quantity.') }}</small>
                            </x-ev.form.input>
                        </div>
                        <!-- END Standard Inventory tracking -->

                        <!-- Low stock quantity warning threshold -->
                        <div class="w-100 pt-3">
                            <x-ev.form.input name="product.unit" class="form-control-sm" type="text" label="{{ translate('Unit') }}" placeholder="{{ translate('pc/kg/m/per meter/gram etc.') }}">
                            </x-ev.form.input>

                            <x-ev.form.input name="product.low_stock_qty" class="form-control-sm" groupclass="mb-0" type="number" label="{{ translate('Low stock quantity warning threshold') }}"  min="0" step="1">
                            </x-ev.form.input>
                        </div>
                        <!-- END ow stock quantity warning threshold -->
                    </div>
                </div>
                {{-- END Card Inventory --}}


                {{-- Card Shipping --}}
                <div class="card mb-3 mb-lg-5" x-data="{}">
                    <div class="card-body position-relative">
                        <h5 class="pb-2 mb-3 border-bottom">{{ translate('Shipping') }}</h5>

                        <div class="w-100">
                            <!-- Is digital product? -->
                            <div class="w-100 d-flex">
                                <label class="toggle-switch mr-3">
                                    <input type="checkbox" x-model="is_digital" class="js-toggle-switch toggle-switch-input">
                                    <span class="toggle-switch-label">
                                        <span class="toggle-switch-indicator"></span>
                                    </span>

                                    <span class="ml-3">{{ translate('Is this a digital product?') }}</span>
                                </label>
                            </div>
                        </div>

                        <div class="w-100" :class="{'d-none': is_digital}">
                        {{-- TODO: Add Shipping methods first and then edit this part --}}
                        </div>
                    </div>
                </div>
                {{-- END Card Shipping --}}


                {{-- Card Attributes --}}
                <div class="card mb-3 mb-lg-5" x-data="" wire:ignore>
                    <div class="card-body position-relative">
                        <h5 class="pb-2 mb-3 border-bottom">{{ translate('Attributes') }}</h5>

                        <template x-for="attribute in attributes" >
                            <div class="w-100 mb-3" x-data="{
                                    getSelectorID() { 
                                        return 'attributes_'+this.attribute.id+'_attribute_values'; 
                                    },
                                    hasCustomProperty(name) {
                                        return this.attribute.custom_properties !== null &&
                                                this.attribute.custom_properties !== undefined &&
                                                this.attribute.custom_properties.hasOwnProperty(name);
                                    },
                                }" x-cloak >

                                {{-- Dropdown --}}
                                <template x-if="attribute.type === 'dropdown'">
                                    <div class="w-100" x-data="{
                                        items: attribute.attribute_values,
                                        selected_items: selected_attribute_values['attribute.'+attribute.id],
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
    
                                            selected_attribute_values['attribute.'+attribute.id] = this.selected_items;
                                        }
                                    }" >
                                            <label class="w-100 input-label" x-text="attribute.name"></label>

                                            <div class="we-select position-relative w-100" x-data="{}" @click.outside="show = false">
                                                <div class="we-select__selector noselect w-100 d-flex flex-wrap border pl-3 pt-2 pb-1 pr-6 position-relative pointer" 
                                                     @click="show = !show">
                                                    @svg('heroicon-o-chevron-down', ['class' => 'we-select__selector-arrow position-absolute square-16 vertical-center', ':class' => "{'rotate-180deg': show}"])
                                
                                                    <template x-if="!multiple">
                                                        <span class="d-block pb-1" x-text="getPlaceholder()"></span>
                                                    </template>

                                                    <template x-if="multiple">
                                                        <div class="w-100 d-flex flex-wrap">
                                                            <template x-if="countSelected() > 0">
                                                                <template x-for="item in items.filter(x => {
                                                                    return selected_items.indexOf(x.id) !== -1;
                                                                  })">
                                                                    <div class="we-select__selector-selected-item rounded mr-2 mb-1 position-relative">
                                                                        <span class="we-select__selector-selected-item-label pl-1 mr-1" x-text="item.values"></span>
                                                                        <button type="button" class="we-select__selector-selected-item-remove px-2" 
                                                                                @click="event.stopPropagation(); select(item.id, item.values)">
                                                                            <span>×</span>
                                                                        </button>
                                                                    </div>
                                                                </template>
                                                            </template>
                                                            <template x-if="countSelected() <= 0">
                                                                <span class="d-block pb-1" x-text="getPlaceholder()"></span>
                                                            </template>
                                                        </div>
                                                    </template>
                                                </div>
                
                                                <div class="we-select__dropdown  position-absolute bg-white shadow border rounded mt-1  w-100" x-show="show">
                                                    <ul class="we-select__dropdown-list noselect w-100">
                                                        <template x-for="item in items">
                                                            <li class="we-select__dropdown-list-item py-2 px-3 pointer" 
                                                                x-text="item.values"
                                                                :class="{'selected': isSelected(item.id) }"
                                                                @click="select(item.id, item.values)"></li>
                                                        </template>
                                                    </ul>
                                                </div>
                                            </div>

                                            {{-- <select class="form-control custom-select custom-select-sm"
                                                    :id="'attributes_'+attribute.id+'_attribute_values'"
                                                    x-bind:multiple="isMultiple(attribute)"
                                                    x-model="selected_attribute_values['attribute.'+attribute.id]"
                                                    data-hs-select2-options='{
                                                        "minimumResultsForSearch": "Infinity",
                                                        "selectionCssClass": "custom-select-sm",
                                                        "placeholder": "{{ translate('Select value') }}"
                                                }'>
                                                    <option></option>
                                                    <template x-for="attribute_value in attribute.attribute_values">
                                                        <option :value="attribute_value.id" x-text="attribute_value.values">
                                                        </option>
                                                    </template>
                                            </select> --}}

                                            <template x-if="hasCustomProperty('multiple') && attribute.custom_properties.multiple">
                                                <div class="w-100 d-flex mt-2 mb-2">
                                                    <label class="toggle-switch mr-3">
                                                        <input type="checkbox" x-model="attribute.for_variations" class="js-toggle-switch toggle-switch-input">
                                                        <span class="toggle-switch-label">
                                                            <span class="toggle-switch-indicator"></span>
                                                        </span>

                                                        <span class="ml-3">{{ translate('Used for variations') }}</span>
                                                    </label>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                                {{-- END Dropdown --}}

                                {{-- Plain Text --}}
                                <template x-if="attribute.type === 'plain_text'">
                                    <div class="w-100" x-data="{}" x-init="">
                                        <label class="w-100 input-label" x-text="attribute.name"></label>

                                        <input type="text"
                                            class="form-control form-control-sm"
                                            :id="'attributes_'+attribute.id+'_attribute_values'"
                                            x-model="attribute.attribute_values[0].values" />
                                    </div>
                                </template>
                                {{-- END Plain Text --}}

                                {{-- Number --}}
                                <template x-if="attribute.type === 'number'">
                                    <div class="w-100" x-data="{
                                        getMinValue() { 
                                            return this.hasCustomProperty(this.attribute, 'min_value') ? this.attribute.custom_properties.min_value : 0; 
                                        },
                                        getMaxValue() { 
                                            return this.hasCustomProperty(this.attribute, 'max_value') ? this.attribute.custom_properties.max_value : 999; 
                                        },
                                    }" x-init="">
                                        <label class="w-100 input-label" x-text="attribute.name"></label>

                                        <div class="input-group" :class="{'input-group-merge': !hasCustomProperty('unit')}">

                                            <input type="number"
                                            class="form-control form-control-sm"
                                            :id="'attributes_'+attribute.id+'_attribute_values'"
                                            x-bind:min="getMinValue()"
                                            x-bind:max="getMaxValue()"
                                            x-model="attribute.attribute_values[0].values" />

                                            <template x-if="hasCustomProperty('unit')">
                                                <div class="input-group-append">
                                                    <span class="input-group-text input-group-text-sm" x-text="attribute.custom_properties.unit"></span>
                                                </div>
                                            </template>
                                        </div>

                                    </div>
                                </template>
                                {{-- END Number --}}


                                {{-- Date --}}
                                <template x-if="attribute.type === 'date'">
                                    <div class="w-100" x-data="{
                                            getDateOptions() {
                                                let options = {
                                                    mode: 'single',
                                                    enableTime: false,
                                                };
                                    
                                                if(this.hasCustomProperty('with_time') && this.attribute.custom_properties.with_time) {
                                                    options.enableTime = true;
                                                    options.dateFormat = 'd.m.Y H:i';
                                                }
                                    
                                                if(this.hasCustomProperty('range') && this.attribute.custom_properties.range) {
                                                    options.mode = 'range';
                                                }
                                    
                                                return JSON.stringify(options);
                                            },
                                        }" x-init="">
                                        <label class="w-100 input-label" x-text="attribute.name"></label>

                                        <input x-model="attribute.attribute_values[0].values"
                                                    type="text"
                                                    class="js-flatpickr form-control form-control-sm flatpickr-custom"
                                                    placeholder="{{ translate('Pick date') }}"
                                                    :data-hs-flatpickr-options='getDateOptions()'
                                                    data-input />

                                    </div>
                                </template>
                                {{-- END Date --}}


                                {{-- Checkbox --}}
                                <template x-if="attribute.type === 'checkbox'">
                                    <div class="w-100" x-data="{}" >
                                        <label class="w-100 input-label" x-text="attribute.name"></label>

                                        <template x-for="attribute_value in attribute.attribute_values">
                                            <div class="form-control form-control-sm mb-2">
                                                <div class="custom-control custom-checkbox">
                                                    <input x-model="selected_attribute_values['attribute.'+attribute.id]"
                                                        type="checkbox"
                                                        :value="attribute_value.id"
                                                        :id="'attribute_'+attribute_value.id"
                                                        class="custom-control-input">

                                                    <label class="custom-control-label" x-text="attribute_value.values" :for="'attribute_'+attribute_value.id">
                                                    </label>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </template>
                                {{-- END Checkbox --}}

                                {{-- Radio --}}
                                <template x-if="attribute.type === 'radio'">
                                    <div class="w-100" x-data="{}">
                                        <label class="w-100 input-label" x-text="attribute.name"></label>

                                        <template x-for="attribute_value in attribute.attribute_values">
                                            <div class="form-control form-control-sm mb-2">
                                                <div class="custom-control custom-radio">
                                                    <input x-model="selected_attribute_values['attribute.'+attribute.id]"
                                                        type="radio"
                                                        :value="attribute_value.id"
                                                        :id="'attribute_'+attribute_value.id"
                                                        class="custom-control-input">

                                                    <label class="custom-control-label" x-text="attribute_value.values" :for="'attribute_'+attribute_value.id">
                                                    </label>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </template>
                                {{-- END Radio --}}


                                {{-- Text List --}}
                                <template x-if="attribute.type === 'text_list'">
                                    <div class="w-100" x-data="{
                                            hasID(index) {
                                                return this.attribute.attribute_values[index].hasOwnProperty('id') && !isNaN(this.attribute.attribute_values[index].id) ? true : false;
                                            },
                                            count() {
                                                if(this.attribute.attribute_values === undefined || this.attribute.attribute_values === null) {
                                                    this.attribute.attribute_values = [{values: ''}];
                                                }
                                    
                                                return this.attribute.attribute_values.length;
                                            },
                                            add() {
                                                this.attribute.attribute_values.push({values:''});
                                            },
                                            remove(index) {
                                                if(this.hasID(index)) {
                                                    $wire.removeAttributeValue(this.attribute.attribute_values[index]['id']);
                                                }
                                                this.attribute.attribute_values.splice(index, 1);
                                            },
                                        }">
                                        <label class="w-100 input-label" x-text="attribute.name"></label>
                                        {{-- FIX: There's an 'cannot acces X of undefined' error when removing item, but it doesn't fuck up the logic  --}}
                                        <div class="row form-group" x-data="{}"
                                        >
                                        <div class="col-12 col-sm-9">
                                            <template x-if="count() <= 1">
                                                <div class="d-flex">
                                                    <input type="text"
                                                            class="form-control"
                                                            placeholder="{{ translate('Value 1') }}"
                                                            x-model="attribute.attribute_values[0]['values']" />
                                                </div>
                                            </template>
                                            <template x-if="count() > 1">
                                                <template x-for="[key, value] of Object.entries(attribute.attribute_values)">
                                                    <div class="d-flex" :class="{'mt-2': key > 0}">
                                                        <input type="text"
                                                            class="form-control"
                                                            x-bind:placeholder="'{{ translate('Value') }} '+(Number(key)+1)"
                                                            x-model="attribute.attribute_values[key]['values']" />
                                                        <template x-if="key > 0">
                                                            <span class="ml-2 d-flex align-items-center pointer" @click="remove(key)">
                                                                @svg('heroicon-o-trash', ['class' => 'square-22 text-danger'])
                                                            </span>
                                                        </template>
                                                    </div>
                                                </template>
                                            </template>

                                            <a href="javascript:;"
                                                class="js-create-field form-link btn btn-xs btn-no-focus btn-ghost-primary" @click="add()">
                                                <i class="tio-add"></i> {{ translate('Add value') }}
                                            </a>
                                        </div>
                                    </div>
                                </template>
                                {{-- END Text List --}}

                                {{-- TODO: Add wysiwyg, image, gallery, country type attribute --}}

                                {{-- Image --}}
                                {{-- <template x-if="attribute.type === 'image'">
                                    <div class="w-100" x-data="{}" x-init="
                                        $nextTick(() => {
                                            console.log($('#attribute_'+attribute.id));
                                            $('#attribute_'+attribute.id).on('change', function() {
                                                console.log('asdasd');
                                            });
                                        });

                                    ">
                                        <label class="w-100 input-label" x-text="attribute.name"></label>

                                        <div class="input-group" data-toggle="aizuploader"
                                            data-type="image"
                                            data-is-sortable="false"
                                            data-template="input">

                                            <div class="input-group-prepend">
                                                <div class="input-group-text input-group-text-sm bg-soft-secondary font-weight-medium">{{ translate('Browse') }}</div>
                                            </div>
                                            <div class="form-control form-control-sm file-amount">{{ translate('Choose image') }}</div>

                                            <input type="hidden" :id="'attribute_'+attribute.id" class="selected-files" x-model="attribute.attribute_values[0].values">
                                        </div>
                                    </div>
                                </template> --}}
                                {{-- END Image --}}
                            </div>
                        </template>
                    </div>
                </div>
                {{-- END Card Attributes --}}

                {{-- Card SEO --}}
                <div class="card mb-3 mb-lg-5" x-data="{
                        collapse: true,
                    }">
                    <div class="card-body position-relative pt-0 pb-0">
                        <h5 class="mb-0 pt-4 d-flex justify-content-between pointer" :class="{'pb-4': collapse, 'pb-3': !collapse}" @click="collapse = !collapse">
                            {{ translate('SEO') }}

                            @svg('heroicon-o-chevron-down', ['class' => 'square-20', ':class' => "{'rotate-180': !collapse}"])
                        </h5>

                        <div class="w-100 pt-3 border-top" :class="{'d-none': collapse}">
                            <!-- SEO Meta Title -->
                            <x-ev.form.input name="product.meta_title" class="form-control-sm" type="text" label="{{ translate('Meta Title') }}" placeholder="{{ translate('Meta title is used for Meta, OpenGraph, Twitter...') }}" >
                                <small class="text-muted">{{ translate('This title will be used for SEO and Social. Real product title will be used as fallback if this is empty.') }}</small>
                            </x-ev.form.input>

                            <!-- SEO Meta Description -->
                            <x-ev.form.textarea name="product.meta_description" rows="4" label="{{ translate('Meta Description') }}" placeholder="{{ translate('Meta description is used for Meta, OpenGraph, Twitter...') }}">
                                <small class="text-muted">{{ translate('Have in mind that description should be between 70 and max 200 characters. Facebook up to 200 chars, Twitter up to 150 chars max.') }}</small>
                            </x-ev.form.textarea>

                            <!-- SEO Meta Image -->
                            <x-ev.form.file-selector name="product.meta_img" label="{{ translate('Meta image') }}" data_type="image" placeholder="Choose file..."></x-ev.form.file-selector>
                        </div>
                    </div>
                </div>
                {{-- END Card SEO --}}
            </div>
            {{-- END Left column --}}

            {{-- Right column --}}
            <div class="col-12 col-md-4">
                {{-- Card Actions --}}
                <div class="card mb-3 mb-lg-5" x-data="{}">
                    <div class="card-body position-relative ">
                        <h5 class="pb-2 mb-3 border-bottom">{{ translate('Actions') }}</h5>

                        <div class="w-100 d-flex justify-content-between">
                            {{-- <div type="button" class="btn btn-danger btn-sm pointer"
                                wire:click="">
                                {{ translate('Delete') }}
                            </div> --}}

                            <div type="button"
                            data-test="we-product-submit"
                            class="btn btn-primary btn-sm pointer ml-auto"
                                    @click="onSave()"
                                    wire:click="saveProduct()">
                                {{ translate('Save') }}
                            </div>
                        </div>

                    </div>
                </div>
                {{-- Card Actions --}}

                {{-- Card Status --}}
                <div class="card mb-3 mb-lg-5" x-data="{}">
                    <div class="card-body position-relative">
                        <h5 class="pb-2 mb-3 border-bottom">{{ translate('Status') }}</h5>

                        <div class="w-100">
                            <div class="w-100"
                                x-init="
                                    $($refs.status_selector).on('select2:select', (event) => {
                                        status = event.target.value;
                                    });

                                    $watch('status', (value) => {
                                        $($refs.status_selector).val(value).trigger('change');
                                    });
                                ">
                                <select
                                    wire:model.defer="product.status"
                                    name="product.status"
                                    x-ref="status_selector"
                                    id="status_selector"
                                    class="js-select2-custom custom-select select2-hidden-accessible"
                                    data-hs-select2-options='
                                        {"minimumResultsForSearch":"Infinity"}
                                    '
                                >
                                    @foreach(\App\Enums\StatusEnum::toArray() as $key => $status)
                                        <option value="{{ $key }}">
                                            {{ $status }}
                                        </option>
                                    @endforeach
                                </select>

                                <div class="d-flex align-items-center mt-2 pl-1">
                                    <span class="mr-2 text-14">{{ translate('Current status:') }}</span>

                                    @if($product->status === App\Enums\StatusEnum::published()->value)
                                        <span class="badge badge-soft-success">
                                            <span class="legend-indicator bg-success mr-1"></span> {{ ucfirst($product->status) }}
                                        </span>
                                    @elseif($product->status === App\Enums\StatusEnum::draft()->value)
                                        <span class="badge badge-soft-warning">
                                            <span class="legend-indicator bg-warning mr-1"></span> {{ ucfirst($product->status) }}
                                        </span>
                                    @elseif($product->status === App\Enums\StatusEnum::pending()->value)
                                        <span class="badge badge-soft-info">
                                            <span class="legend-indicator bg-info mr-1"></span> {{ ucfirst($product->status) }}
                                        </span>
                                    @elseif($product->status === App\Enums\StatusEnum::archived()->value)
                                        <span class="badge badge-soft-danger">
                                            <span class="legend-indicator bg-danger mr-1"></span> {{ ucfirst($product->status) }}
                                        </span>
                                    @elseif($product->status === App\Enums\StatusEnum::private()->value)
                                        <span class="badge badge-soft-dark">
                                            <span class="legend-indicator bg-dark mr-1"></span> {{ ucfirst($product->status) }}
                                        </span>
                                    @endif
                                </div>

                                <x-default.system.invalid-msg field="product.status" type="slim"></x-default.system.invalid-msg>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- END Card Status --}}

                {{-- Card Categories and Tags --}}
                <div class="card mb-3 mb-lg-5" x-data="{}">
                    <div class="card-body position-relative">
                        <h5 class="pb-2 mb-3 border-bottom">{{ translate('Categories and Tags') }}</h5>

                        <div class="w-100">
                            <x-ev.form.categories-selector class="mb-3" error-bag-name="selected_categories" :items="$this->categories" :selected-categories="$this->levelSelectedCategories()" label="{{ translate('Categories') }}" :multiple="true" :required="true" :search="true" />

                            <x-ev.form.select name="product.tags" class="mb-0" :tags="true" label="{{ translate('Tags') }}" :multiple="true" placeholder="{{ translate('Type and hit enter to add a tag...') }}">
                                <small class="text-muted">{{ translate('This is used for search. Input relevant words by which customer can find this product.') }}</small>
                            </x-ev.form.select>
                        </div>
                    </div>
                </div>
                {{-- END Card Categories and Tags --}}

                {{-- Card Brand --}}
                <div class="card mb-3 mb-lg-5" x-data="{}">
                    <div class="card-body position-relative">
                        <h5 class="pb-2 mb-3 border-bottom">{{ translate('Brand') }}</h5>

                        <div class="w-100">
                            <x-ev.form.select name="product.brand_id" :items="EVS::getMappedBrands()" class="mb-1" :search="true" placeholder="{{ translate('Select Brand...') }}" />
                        </div>
                    </div>
                </div>
                {{-- END Card Brand --}}


                {{-- Card Actions --}}
                <div class="card mb-3 mb-lg-5" x-data="{}">
                    <div class="card-body position-relative d-flex">
                        <div type="button" class="btn btn-primary btn-sm pointer ml-auto"
                                @click="onSave()"
                                wire:click="saveProduct()">
                            {{ translate('Save') }}
                        </div>
                    </div>
                </div>
                {{-- Card Actions --}}
            </div>
            {{-- END Right column --}}
        </div>

        {{-- <script type="text/javascript">
            window.addEventListener('', event => {
                alert('Name updated to: ' + event.detail.newName);
            });
        </script> --}}
    </div>
</div>

