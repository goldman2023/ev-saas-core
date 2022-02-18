<div x-data="{
        is_digital: {{ $product->digital === true ? 'true' : 'false' }},
        use_serial: {{ $product->use_serial === 1 ? 'true' : 'false' }}
    }"
     class="container-fluid"
     @validation-errors.window="$scrollToErrors($event.detail.errors, 700);"
     x-cloak>

    <div class="row">

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
                    base_currency: @js($product->base_currency),
                    discount_type: @js($product->discount_type),
                    tax_type: @js($product->tax_type),
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

                                <x-default.system.invalid-msg field="product.unit_price"></x-default.system.invalid-msg>
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

                                <x-default.system.invalid-msg field="product.discount"></x-default.system.invalid-msg>
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

                                <x-default.system.invalid-msg field="plan.tax"></x-default.system.invalid-msg>
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

                                <x-default.system.invalid-msg field="product.purchase_price"></x-default.system.invalid-msg>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            {{-- END Card Pricing --}}
            

            {{-- Card Inventory --}}
            <div class="card mb-3 mb-lg-5" x-data="
                    
                ">
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
                        <x-ev.form.input name="product.min_qty" class="form-control-sm"  type="number" label="{{ translate('Minimum quantity') }}" :required="true" min="1" step="1">
                            <small class="text-muted">{{ translate('This is the minimum quantity user can purchase.') }}</small>
                        </x-ev.form.input>

                        <x-ev.form.input name="product.current_stock" class="form-control-sm" groupclass="mb-0" type="number" label="{{ translate('Stock quantity') }}" :required="true"  min="0" step="1">
                            <small class="text-muted">{{ translate('This is the current stock quantity.') }}</small>
                        </x-ev.form.input>
                    </div>
                    <!-- END Standard Inventory tracking -->

                    <!-- Low stock quantity warning threshold -->
                    <div class="w-100 pt-3">
                        <x-ev.form.input name="product.low_stock_qty" class="form-control-sm" groupclass="mb-0" type="number" label="{{ translate('Low stock quantity warning threshold') }}"  min="0" step="1">
                        </x-ev.form.input>
                    </div>
                    <!-- END ow stock quantity warning threshold -->

                </div>
            </div>
            {{-- END Card Inventory --}}


            {{-- Card Shipping --}}
            <div class="card mb-3 mb-lg-5" x-data="
                    
                ">
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
                       
                    </div>
                </div>
            </div>
            {{-- END Card Shipping --}}

        </div>
        {{-- END Left column --}}

        {{-- Right column --}}
        <div class="col-12 col-md-4">
            {{-- Card Status --}}
            <div class="card mb-3 mb-lg-5" x-data="{
                status: @js($plan->status ?? App\Enums\StatusEnum::draft()->value),
            }">
                <div class="card-body position-relative">
                    <h5 class="pb-2 mb-3 border-bottom">{{ translate('Status') }}</h5>

                    <div class="w-100">
                        {{-- <label for="plan-status" class="w-100 input-label d-flex align-items-center">
                            {{ translate('Status') }}
                        </label> --}}
    
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
    
                            <x-default.system.invalid-msg field="plan.status"></x-default.system.invalid-msg>
                        </div>
                    </div>
                </div>
            </div>
            {{-- END Card Status --}}


            {{-- Card Categories and Tags --}}
            <div class="card mb-3 mb-lg-5" x-data="{
                
            }">
                <div class="card-body position-relative">
                    <h5 class="pb-2 mb-3 border-bottom">{{ translate('Categories and Tags') }}</h5>

                    <div class="w-100">
                        <x-ev.form.categories-selector class="mb-3" error-bag-name="selected_categories" :items="$this->categories" :selected-categories="$this->levelSelectedCategories()" label="{{ translate('Categories') }}" :multiple="true" :required="true" :search="true" />

                        <x-ev.form.select name="product.tags" :tags="true" label="{{ translate('Tags') }}" :multiple="true" placeholder="{{ translate('Type and hit enter to add a tag...') }}">
                            <small class="text-muted">{{ translate('This is used for search. Input relevant words by which customer can find this product.') }}</small>
                        </x-ev.form.select>
                    </div>
                </div>
            </div>
            {{-- END Card Categories and Tags --}}

            {{-- Card Brand --}}
            <div class="card mb-3 mb-lg-5" x-data="{
                
            }">
                <div class="card-body position-relative">
                    <h5 class="pb-2 mb-3 border-bottom">{{ translate('Brand') }}</h5>

                    <div class="w-100">
                        <x-ev.form.select name="product.brand_id" :items="EVS::getMappedBrands()" class="mb-1" :search="true" placeholder="{{ translate('Select Brand...') }}" />
                    </div>
                </div>
            </div>
            {{-- END Card Brand --}}
        </div>
        {{-- END Right column --}}
    </div>
</div>