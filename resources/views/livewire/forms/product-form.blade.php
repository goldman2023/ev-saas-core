<div class="lw-form">

    @if(!$insert_success)
        <div class="card mb-3 mb-lg-5">
            <!-- Header -->
            <div class="card-header">
                <h4 class="card-header-title">{{ translate('Add New Product') }}</h4>
            </div>
            <!-- End Header -->

            <!-- Body -->
            <div class="card-body">
                <form class=" js-step-form-1"
                      data-hs-step-form-options='{
                      "progressSelector": "#productStepFormProgress",
                      "stepsSelector": "#productStepFormContent",
                      "endSelector": "#uploadResumeFinishBtn",
                      "isValidate": false
                    }'>
                    <div class="row">
                        <div id="stickyBlockStartPoint" class="col-lg-4">
                            <!-- Sticky Block
                               .js-sticky-block
                                data-hs-sticky-block-options='{
                                   "parentSelector": "#stickyBlockStartPoint",
                                   "breakpoint": "lg",
                                   "startPoint": "#stickyBlockStartPoint",
                                   "endPoint": "#stickyBlockEndPoint",
                                   "stickyOffsetTop": 20,
                                   "stickyOffsetBottom": 0
                                 }'
                            -->
                            <div class="">
                                <!-- Step -->
                                <ul id="productStepFormProgress" class="js-step-progress step step-icon-xs step-border-last-0 mt-2">
                                    <li class="step-item {{ $page === 'general' ? 'active':'' }}">
                                        <a class="step-content-wrapper" href="javascript:;"
                                           onClick="document.dispatchEvent(new CustomEvent('validate-step', {detail: {component: @this, params: ['general', 'general']}}))">
                                            <span class="step-icon step-icon-soft-dark">1</span>
                                            <div class="step-content">
                                                <span class="step-title">{{ translate('General') }}</span>
                                                <span class="step-title-description step-text font-size-1">{{ translate('General product info') }}</span>
                                            </div>
                                        </a>
                                    </li>

                                    <li class="step-item {{ $page === 'content' ? 'active':'' }}">
                                        <a class="step-content-wrapper" href="javascript:;"
                                           onClick="document.dispatchEvent(new CustomEvent('validate-step', {detail: {component: @this, params: ['content', 'content']}}))">
                                            <span class="step-icon step-icon-soft-dark">2</span>
                                            <div class="step-content">
                                                <span class="step-title">{{ translate('Content') }}</span>
                                                <span class="step-title-description step-text font-size-1">{{ translate('Beautify your product!') }}</span>
                                            </div>
                                        </a>
                                    </li>

                                    <li class="step-item {{ $page === 'price_stock_shipping' ? 'active':'' }}">
                                        <a class="step-content-wrapper" href="javascript:;"
                                           onClick="document.dispatchEvent(new CustomEvent('validate-step', {detail: {component: @this, params: ['price_stock_shipping', 'price_stock_shipping']}}))">
                                            <span class="step-icon step-icon-soft-dark">3</span>
                                            <div class="step-content">
                                                <span class="step-title">{{ translate('Price, stock and shipping') }}</span>
                                                <span class="step-title-description step-text font-size-1">{{ translate('Price, stock and shipping details') }}</span>
                                            </div>
                                        </a>
                                    </li>

                                    <li class="step-item {{ $page === 'attributes_variations' ? 'active':'' }}">
                                        <a class="step-content-wrapper" href="javascript:;"
                                           wire:click="$set('page', 'attributes_variations')"
                                        ><!-- onClick="document.dispatchEvent(new CustomEvent('validate-step', {detail: {component: @this, params: ['attributes_variations', 'attributes_variations']}}))"-->
                                            <span class="step-icon step-icon-soft-dark">4</span>
                                            <div class="step-content">
                                                <span class="step-title">{{ translate('Attributes & variations') }}</span>
                                                <span class="step-title-description step-text font-size-1">{{ translate('Add product attributes and variations') }}</span>
                                            </div>
                                        </a>
                                    </li>

                                    <li class="step-item {{ $page === 'seo' ? 'active':'' }}">
                                        <a class="step-content-wrapper" href="javascript:;"
                                           onClick="document.dispatchEvent(new CustomEvent('validate-step', {detail: {component: @this, params: ['seo', 'seo']}}))">
                                            <span class="step-icon step-icon-soft-dark">5</span>
                                            <div class="step-content">
                                                <span class="step-title">{{ translate('SEO') }}</span>
                                                <span class="step-title-description step-text font-size-1">{{ translate('Edit product SEO settings') }}</span>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                                <!-- End Step -->
                            </div>
                            <!-- End Sticky Block -->
                        </div>

                        <div id="formContainer" class="col-lg-8">
                            <!-- Content Step Form -->
                            <div id="productStepFormContent">
                                <!-- Card -->
                                <div id="productStepGeneral" class="{{ $page === 'general' ? 'active':'' }}" style="{{ $page !== 'general' ? "display: none;" : "" }}">
                                    <!-- Header -->
                                    <div class="border-bottom pb-2 mb-3">
                                        <div class="flex-grow-1">
                                            <span class="d-lg-none">{{ translate('Step 1 of 5') }}</span>
                                            <h3 class="card-header-title">{{ translate('General') }}</h3>
                                        </div>
                                    </div>
                                    <!-- End Header -->

                                    <!-- Body -->
                                    <div class="">
                                        <x-ev.form.input name="product.name" type="text" label="{{ translate('Product name') }}" :required="true" placeholder="{{ translate('Think of some catchy name...') }}" />

                                        <x-ev.form.select name="product.category_id" :items="EV::getMappedCategories()" label="{{ translate('Category') }}" :required="true" :search="true" placeholder="{{ translate('Select the category...') }}" />

                                        <x-ev.form.select name="product.brand_id" :items="EV::getMappedBrands()" label="{{ translate('Brand') }}" :search="true" placeholder="{{ translate('Select Brand...') }}" />

                                        <x-ev.form.select name="product.unit" :items="EV::getMappedUnits()" label="{{ translate('Unit') }}" :required="true" placeholder="{{ translate('Choose the product unit...') }}" />

                                        <x-ev.form.select name="product.tags" :tags="true" label="{{ translate('Tags') }}" :multiple="true" placeholder="{{ translate('Type and hit enter to add a tag...') }}">
                                            <small class="text-muted">{{ translate('This is used for search. Input relevant words by which customer can find this product.') }}</small>
                                        </x-ev.form.select>
                                    </div>
                                    <!-- End Body -->

                                    <!-- Footer -->
                                    <div class="border-top pt-3">
                                        <div class="d-flex justify-content-end align-items-center">
                                            <button type="button" class="btn btn-primary"
                                                    onClick="document.dispatchEvent(new CustomEvent('validate-step', {detail: {component: @this, params: ['general', 'content']}}))"
                                            >
                                                {{ translate('Continue') }} <i class="fas fa-angle-right ml-1"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- End Footer -->
                                </div>
                                <!-- End Card -->

                                <div id="productStepContent" class="{{ $page === 'content' ? 'active':'' }}" style="{{ $page !== 'content' ? "display: none;" : "" }}">
                                    <!-- Header -->
                                    <div class="border-bottom pb-2 mb-3">
                                        <div class="flex-grow-1">
                                            <span class="d-lg-none">{{ translate('Step 2 of 5') }}</span>
                                            <h3 class="card-header-title">{{ translate('Content') }}</h3>
                                        </div>
                                    </div>
                                    <!-- End Header -->

                                    <!-- Body -->
                                    <div class="pb-4">
                                        <!-- Images -->
                                        <x-ev.form.file-selector name="product.thumbnail_img" label="{{ translate('Thumbnail image') }}" data_type="image" placeholder="{{ translate('Choose file...') }}"></x-ev.form.file-selector>
                                        <x-ev.form.file-selector name="product.photos" label="{{ translate('Gallery image') }}" :multiple="true" data_type="image" placeholder="{{ translate('Choose file...') }}"
                                                                 :sortable="true"
                                                                 :sortable-options='["animation" => 150, "group" => "photosPreviewGroup"]'
                                        ></x-ev.form.file-selector>

                                        <!-- Video -->
                                        <x-ev.form.select name="product.video_provider" :items="EV::getMappedVideoProviders()" label="{{ translate('Video provider') }}"  placeholder="{{ translate('Select the provider...') }}" />
                                        <x-ev.form.input name="product.video_link" type="text" label="{{ translate('Video link') }}" placeholder="{{ translate('Link to the video...') }}" >
                                            <small class="text-muted">{{ translate('Use proper link without extra parameter. Don\'t use short share link/embeded iframe code.') }}</small>
                                        </x-ev.form.input>

                                        <!-- PDF Specification -->
                                        <x-ev.form.file-selector name="product.pdf" label="{{ translate('PDF Specification (optional)') }}" datatype="document" placeholder="{{ translate('Choose file...') }}"></x-ev.form.file-selector>

                                        <x-ev.form.wysiwyg name="product.description" label="{{ translate('Product Description') }}" placeholder=""></x-ev.form.wysiwyg>
                                    </div>
                                    <!-- End Body -->

                                    <!-- Footer -->
                                    <div class="border-top pt-3">
                                        <div class="d-flex align-items-center">
                                            <button type="button" class="btn btn-ghost-secondary d-flex align-items-center"
                                                    data-hs-step-form-prev-options='{
                                             "targetSelector": "#productStepGeneral"
                                           }'>
                                                @svg('heroicon-o-chevron-left', ['style'=>'width:18px;'])
                                                {{ translate('Previous step') }}
                                            </button>

                                            <div class="ml-auto">
                                                <button type="button" class="btn btn-primary"
                                                        onClick="document.dispatchEvent(new CustomEvent('validate-step', {detail: {component: @this, params: ['content', 'price_stock_shipping']}}))"
                                                >
                                                    {{ translate('Continue') }} <i class="fas fa-angle-right ml-1"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Footer -->
                                </div>

                                <div id="productStepPriceStockShipping" class="{{ $page === 'price_stock_shipping' ? 'active':'' }}" style="{{ $page !== 'price_stock_shipping' ? "display: none;" : "" }}" >
                                    <!-- Header -->
                                    <div class="border-bottom pb-2 mb-3">
                                        <div class="flex-grow-1">
                                            <span class="d-lg-none">{{ translate('Step 3 of 5') }}</span>
                                            <h3 class="card-header-title">{{ translate('Price, stock and shipping') }}</h3>
                                        </div>
                                    </div>
                                    <!-- End Header -->

                                    <!-- Body -->
                                    <div class="">
                                        <x-ev.form.input name="product.min_qty" type="number" label="{{ translate('Minimum quantity') }}" :required="true" min="1" step="1">
                                            <small class="text-muted">{{ translate('This is the minimum quantity user can purchase.') }}</small>
                                        </x-ev.form.input>
                                        <x-ev.form.input name="product.current_stock" type="number" label="{{ translate('Stock quantity') }}" :required="true"  min="0" step="1">
                                            <small class="text-muted">{{ translate('This is the current stock quantity.') }}</small>
                                        </x-ev.form.input>
                                        <x-ev.form.input name="product.low_stock_quantity" type="number" label="{{ translate('Low stock quantity warning') }}"  min="0" step="1">
                                        </x-ev.form.input>

                                        <x-ev.form.input name="product.unit_price" type="number" label="{{ translate('Unit price') }}" :required="true"  min="0" step="0.01">

                                        </x-ev.form.input>
                                        <x-ev.form.input name="product.purchase_price" type="number" label="{{ translate('Purchase price') }}" min="0" step="0.01">

                                        </x-ev.form.input>

                                        <div class="row">
                                            <div class="col-12 col-md-8">
                                                <x-ev.form.input name="product.discount" type="number" label="{{ translate('Discount') }}" :required="true" min="0" step="0.01"></x-ev.form.input>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <x-ev.form.select name="product.discount_type" :items="['amount'=>translate('Flat'),'percent'=>translate('Percent')]" label="{{ translate('Discount type') }}" :required="true"/>
                                            </div>
                                        </div>

                                        <x-ev.form.radio name="product.stock_visibility_state" :items="EV::getMappedStockVisibilityOptions()" label="{{ translate('Stock visibility state') }}"></x-ev.form.radio>

                                        <x-ev.form.radio name="product.shipping_type" :items="EV::getMappedShippingTypePerProduct()" label="{{ translate('Shipping configuration') }}">
                                            <x-slot name="flat_rate">
                                                <x-ev.form.input name="product.flat_shipping_cost" groupclass="{{ $product->shipping_type === 'flat_rate' ? '':'d-none' }}" type="number"  placeholder="{{ translate('Shipping cost') }}"  min="0" step="0.01"></x-ev.form.input>
                                            </x-slot>
                                        </x-ev.form.radio>

                                        <x-ev.form.checkbox name="product.is_quantity_multiplied" :items="['1' => translate('Multiply shipping by product quantity')]"  label="{{ translate('Quantity multiple') }}"></x-ev.form.checkbox>

                                        <x-ev.form.input name="product.est_shipping_days" type="number" label="{{ translate('Estimate shipping time') }}" placement="append" text="{{ translate('Days') }}" min="1" step="1"></x-ev.form.input>
                                    </div>
                                    <!-- End Body -->

                                    <!-- Footer -->
                                    <div class="border-top pt-3">
                                        <div class="d-flex align-items-center">
                                            <button type="button" class="btn btn-ghost-secondary d-flex align-items-center"
                                                    data-hs-step-form-prev-options='{
                                         "targetSelector": "#productStepContent"
                                       }'>
                                                @svg('heroicon-o-chevron-left', ['style'=>'width:18px;'])
                                                {{ translate('Previous step') }}
                                            </button>

                                            <div class="ml-auto">
                                                <button type="button" class="btn btn-primary"
                                                        onClick="document.dispatchEvent(new CustomEvent('validate-step', {detail: {component: @this, params: ['price_stock_shipping', 'attributes_variations']}}))"
                                                >
                                                    {{ translate('Continue') }} <i class="fas fa-angle-right ml-1"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Footer -->
                                </div>


                                <div id="productStepAttributesVariations" class="{{ $page === 'attributes_variations' ? 'active':'' }}" style="{{ $page !== 'attributes_variations' ? "display: none;" : "" }}" >
                                    <!-- Header -->
                                    <div class="border-bottom pb-2 mb-3">
                                        <div class="flex-grow-1">
                                            <span class="d-lg-none">{{ translate('Step 4 of 5') }}</span>
                                            <h3 class="card-header-title">{{ translate('Attributes & variations') }}</h3>
                                        </div>
                                    </div>
                                    <!-- End Header -->

                                    <!-- Body -->
                                    <div class="">
                                        <div class="full-width product-attributes-wrapper">
                                            <x-ev.form.select name="attributes" :items="$attributes" value-property="id" label-property="name" :tags="true" label="{{ translate('Attributes') }}" :multiple="true" placeholder="{{ translate('Search available attributes...') }}">
                                                <small class="text-muted">{{ translate('Choose the attributes of this product and then input values of each attribute.') }}</small>
                                            </x-ev.form.select>

                                            @if($attributes)
                                                @foreach($attributes as $attribute)
                                                    @php $attribute = (object) $attribute; @endphp
                                                    @if($attribute->selected ?? null)
                                                        <x-ev.form.select name="attributes.{{ $attribute->id }}.attribute_values"
                                                                          error-bag-name="attributes.{{ $attribute->id }}"
                                                                          label="{{ $attribute->name }}"
                                                                          :items="$attribute->attribute_values"
                                                                          value-property="id"
                                                                          label-property="values"
                                                                          :tags="true"
                                                                          :multiple="true"
                                                                          placeholder="{{ translate('Search or add values...') }}"
                                                                          data-attribute-id="{{ $attribute->id }}">
                                                            <x-ev.form.toggle name="attributes.{{ $attribute->id }}.for_variations"
                                                                              class="mt-2 mb-2"
                                                                              append-text="{{ translate('Used for variations') }}"
                                                                              :selected="$attribute->for_variations ?? false">
                                                            </x-ev.form.toggle>
                                                        </x-ev.form.select>
                                                    @endif

                                                @endforeach
                                            @endif

                                        </div>
                                    </div>
                                    <!-- End Body -->

                                    <!-- Footer -->
                                    <div class="border-top pt-3">
                                        <div class="d-flex align-items-center">
                                            <button type="button" class="btn btn-ghost-secondary d-flex align-items-center"
                                                    data-hs-step-form-prev-options='{
                                         "targetSelector": "#productStepPriceStockShipping"
                                       }'>
                                                @svg('heroicon-o-chevron-left', ['style'=>'width:18px;'])
                                                {{ translate('Previous step') }}
                                            </button>

                                            <div class="ml-auto">
                                                <button type="button" class="btn btn-primary"
                                                        onClick="document.dispatchEvent(new CustomEvent('validate-step', {detail: {component: @this, params: ['attributes_variations', 'seo']}}))"
                                                >
                                                    {{ translate('Continue') }} <i class="fas fa-angle-right ml-1"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Footer -->
                                </div>

                                <div id="productStepSEO" class="{{ $page === 'seo' ? 'active':'' }}" style="{{ $page !== 'seo' ? "display: none;" : "" }}">
                                    <!-- Header -->
                                    <div class="border-bottom pb-2 mb-3">
                                        <div class="flex-grow-1">
                                            <span class="d-lg-none">{{ translate('Step 5 of 5') }}</span>
                                            <h3 class="card-header-title">{{ translate('SEO') }}</h3>
                                        </div>
                                    </div>
                                    <!-- End Header -->

                                    <!-- Body -->
                                    <div class="pb-4">
                                        <!-- SEO Meta Title -->
                                        <x-ev.form.input name="product.meta_title" type="text" label="{{ translate('Meta Title') }}" placeholder="{{ translate('Meta title is used for Meta, OpenGraph, Twitter...') }}" >
                                            <small class="text-muted">{{ translate('This title will be used for SEO and Social. Real product title will be used as fallback if this is empty.') }}</small>
                                        </x-ev.form.input>

                                        <!-- SEO Meta Description -->
                                        <x-ev.form.textarea name="product.meta_description" label="{{ translate('Meta Description') }}" placeholder="{{ translate('Meta description is used for Meta, OpenGraph, Twitter...') }}">
                                            <small class="text-muted">{{ translate('Have in mind that description should be between 70 and max 200 characters. Facebook up to 200 chars, Twitter up to 150 chars max.') }}</small>
                                        </x-ev.form.textarea>

                                        <!-- SEO Meta Image -->
                                        <x-ev.form.file-selector name="product.meta_img" label="{{ translate('Meta image') }}" data_type="image" placeholder="Choose file..."></x-ev.form.file-selector>
                                    </div>
                                    <!-- End Body -->

                                    <!-- Footer -->
                                    <div class="border-top pt-3">
                                        <div class="d-flex align-items-center">
                                            <button type="button" class="btn btn-ghost-secondary d-flex align-items-center"
                                                    data-hs-step-form-prev-options='{
                                             "targetSelector": "#productStepAttributesVariations"
                                           }'>
                                                @svg('heroicon-o-chevron-left', ['style'=>'width:18px;'])
                                                {{ translate('Previous step') }}
                                            </button>

                                            <div class="ml-auto">
                                                <button type="button" class="btn btn-primary"
                                                        onClick="document.dispatchEvent(new CustomEvent('validate-step', {detail: {component: @this, params: ['seo', '', true]}}))"
                                                >
                                                    {{ translate('Add Product') }} <i class="fas fa-angle-right ml-1"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Footer -->
                                </div>

                            </div>

                            <!-- Sticky Block End Point -->
                            <div id="stickyBlockEndPoint"></div>
                        </div>
                    </div>
                    <!-- End Row -->
                </form>
            </div>
        </div>
    @endif


    <!-- Message Body -->
    <x-ev.alert id="successMessageContent" class="{{ !$insert_success ? 'd-none':'' }}" content-class="flex flex-column" type="success" title="{{ translate('Product successfully created!') }}">
        <span class="d-block">{{ translate('You have successfully create a new product! Preview or edit your newly added product:') }}</span>
        <div class="d-flex align-items-center mt-3">
            <a class="btn btn-white mr-3" href="{{ $product->permalink }}">{{ translate('Preview') }}</a>
            <a class="btn btn-white mr-3" href="{{ route('ev-products.create') }}">{{ translate('Edit') }}</a>
            <!-- TODO: ^^^ Change route for edit to actually be ev-product edit route, not create! This is just for testing. ^^^ -->
        </div>
    </x-ev.alert>
    <!-- End Message Body -->
</div>


