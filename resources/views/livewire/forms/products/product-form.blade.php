@push('pre_head_scripts')
    <script>
        let all_categories = @json($categories);
    </script>
@endpush
<div class="lw-form" x-data="{}">

    <!-- Message Body -->
    <x-ev.alert id="successMessageContent" class="{{ !$insert_success ? 'd-none':'' }}"
                content-class="flex flex-column"
                type="success"
                title="{{ $insert_success ? translate('Product successfully created!') : '' }}">
        <span class="d-block">
            @if($insert_success)
                {{ translate('You have successfully create a new product! Preview or edit your newly added product:') }}
            @endif
        </span>
        <div class="d-flex align-items-center mt-3">
            <a class="btn btn-white btn-sm mr-3" href="{{ $product->permalink }}" target="_blank">{{ translate('Preview') }}</a>
            @if(!empty($product->id) && $insert_success)
                <a class="btn btn-white btn-sm mr-3" href="{{ route('ev-products.edit', $product->slug) }}" target="_parent">{{ translate('Edit') }}</a>
            @endif
        </div>
    </x-ev.alert>

    @if($insert_success)
    <div class="row">
        <div class="col-12">
            <h5>{{ translate('Your product preview:') }}</h5>
        </div>
        <div class="col-sm-4"></div>
        <div class="col-sm-4">
            <x-default.products.cards.product-card
            :product="$product"
            >
            </x-default.products.cards.product-card>
        </div>
        <div class="col-sm-4"></div>
    </div>

    @endif



    <!-- End Message Body -->

    <x-ev.toast id="product-updated-toast"
                position="bottom-center"
                content="{{ translate('Product successfully updated!') }}"
                class="bg-success border-success text-white h3"></x-ev.toast>

    @if(!$insert_success)
        <div class="card mb-3 mb-lg-5">
            <!-- Header -->
            <div class="card-header">
                <h4 class="card-header-title">
                    @if(!empty($product->id))
                        {{ translate('Edit Product') }}
                    @else
                        {{ translate('Add New Product') }}
                    @endif
                </h4>

                @if(!empty($product->id))
                    <button class="btn btn-primary btn-xs d-flex justify-content-center ml-auto"
                                 onclick="document.dispatchEvent(new CustomEvent('validate-step', {detail: {component: @this, params: ['seo', @this.page, true]}}))">
                        @svg('lineawesome-save', ['style' => 'width: 18px; height: 18px;', 'class' => 'mr-1'])
                        <span>{{ translate('Save') }}</span>
                    </button>
                @endif
            </div>
            <!-- End Header -->

            <!-- Body -->
            <div class="card-body position-relative">
                <x-ev.loaders.spinner class="absolute-center z-10 d-none"
                                      wire:target="validateSpecificSet"
                                      wire:loading.class.remove="d-none"></x-ev.loaders.spinner>

                <form class="js-step-form-1"
                      wire:loading.class="opacity-3"
                      wire:target="validateSpecificSet"
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

                                    <li class="step-item {{ $page === 'attributes' ? 'active':'' }}">
                                        <a class="step-content-wrapper" href="javascript:;"
                                           onClick="document.dispatchEvent(new CustomEvent('validate-step', {detail: {component: @this, params: ['attributes', 'attributes', false, ['attributes']]}}))"
                                        ><!-- wire:click="$set('page', 'attributes')" -->
                                            <span class="step-icon step-icon-soft-dark">4</span>
                                            <div class="step-content">
                                                <span class="step-title">{{ translate('Attributes') }}</span>
                                                <span class="step-title-description step-text font-size-1">{{ translate('Add product attributes') }}</span>
                                            </div>
                                        </a>
                                    </li>

                                    <li class="step-item {{ $page === 'variations' ? 'active':'' }}">
                                        <a class="step-content-wrapper" href="javascript:;"
                                           onClick="document.dispatchEvent(new CustomEvent('validate-step', {detail: {component: @this, params: ['variations', 'variations', false, ['variations']]}}))"
                                           wire:click="syncVariationsDatatable()"
                                        ><!-- wire:click="$set('page', 'variations')" -->
                                            <span class="step-icon step-icon-soft-dark">5</span>
                                            <div class="step-content">
                                                <span class="step-title">{{ translate('Variations') }}</span>
                                                <span class="step-title-description step-text font-size-1">{{ translate('Add product variations') }}</span>
                                            </div>
                                        </a>
                                    </li>

                                    <li class="step-item {{ $page === 'seo' ? 'active':'' }}">
                                        <a class="step-content-wrapper" href="javascript:;"
                                           onClick="document.dispatchEvent(new CustomEvent('validate-step', {detail: {component: @this, params: ['seo', 'seo', true]}}))">
                                            <span class="step-icon step-icon-soft-dark">6</span>
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

                                        <x-ev.form.categories-selector :items="$this->categories" :selected-categories="$this->levelSelectedCategories()" label="{{ translate('Categories') }}" :multiple="true" :required="true" :search="true" />

                                        <x-ev.form.select name="product.brand_id" :items="EVS::getMappedBrands()" label="{{ translate('Brand') }}" :search="true" placeholder="{{ translate('Select Brand...') }}" />

                                        <x-ev.form.select name="product.unit" :items="EVS::getMappedUnits()" label="{{ translate('Unit') }}" :required="true" placeholder="{{ translate('Choose the product unit...') }}" />

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
                                        <x-ev.form.select name="product.video_provider" :items="EVS::getMappedVideoProviders()" label="{{ translate('Video provider') }}"  placeholder="{{ translate('Select the provider...') }}" />
                                        <x-ev.form.input name="product.video_link" type="text" label="{{ translate('Video link') }}" placeholder="{{ translate('Link to the video...') }}" >
                                            <small class="text-muted">{{ translate('Use proper link without extra parameter. Don\'t use short share link/embeded iframe code.') }}</small>
                                        </x-ev.form.input>

                                        <!-- PDF Specification -->
                                        <x-ev.form.file-selector name="product.pdf" label="{{ translate('PDF Specification (optional)') }}" datatype="document" placeholder="{{ translate('Choose file...') }}"></x-ev.form.file-selector>

                                        <x-ev.form.wysiwyg name="product.description" label="{{ translate('Product Description') }}" placeholder=""></x-ev.form.wysiwyg>

                                        <x-ev.form.textarea name="product.excerpt" label="{{ translate('Excerpt (short description)') }}" >
                                            <small class="text-muted">{{ translate('If you leave excerpt empty, first 320 chars of description will be used as an excerpt.') }}</small>
                                        </x-ev.form.textarea>
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
                                        <!-- Main Product SKU -->
                                        <x-ev.form.input name="product.temp_sku" type="text" label="{{ translate('SKU') }}" placeholder="{{ translate('SKU of the main product (not variations).') }}" >
                                            <small class="text-muted">{{ translate('Leave empty if you want to add only SKU of the variations.') }}</small>
                                        </x-ev.form.input>

                                        <x-ev.form.input name="product.min_qty" type="number" label="{{ translate('Minimum quantity') }}" :required="true" min="1" step="1">
                                            <small class="text-muted">{{ translate('This is the minimum quantity user can purchase.') }}</small>
                                        </x-ev.form.input>
                                        <x-ev.form.input name="product.current_stock" type="number" label="{{ translate('Stock quantity') }}" :required="true"  min="0" step="1">
                                            <small class="text-muted">{{ translate('This is the current stock quantity.') }}</small>
                                        </x-ev.form.input>



                                        <x-ev.form.input name="product.low_stock_qty" type="number" label="{{ translate('Low stock quantity warning') }}"  min="0" step="1">
                                        </x-ev.form.input>

                                        <x-ev.form.radio name="product.stock_visibility_state" :items="EVS::getMappedStockVisibilityOptions()" label="{{ translate('Stock visibility state') }}" value="{{ $product->stock_visibility_state ?: '' }}"></x-ev.form.radio>

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

                                        <x-ev.form.radio name="product.shipping_type" :items="EVS::getMappedShippingTypePerProduct()" label="{{ translate('Shipping type') }}" value="{{ $product->shipping_type ?: '' }}" >
                                            <x-slot name="flat_rate">
                                                <x-ev.form.input name="product.shipping_cost" groupclass="{{ $product->shipping_type === 'flat_rate' ? '':'d-none' }}" type="number"  placeholder="{{ translate('Shipping cost') }}"  min="0" step="0.01"></x-ev.form.input>
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
                                                        onClick="document.dispatchEvent(new CustomEvent('validate-step', {detail: {component: @this, params: ['price_stock_shipping', 'attributes', false, ['attributes']]}}))"
                                                >
                                                    {{ translate('Continue') }} <i class="fas fa-angle-right ml-1"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Footer -->
                                </div>


                                <div id="productStepAttributes" class="{{ $page === 'attributes' ? 'active':'' }}" style="{{ $page !== 'attributes' ? "display: none;" : "" }}" >
                                    <!-- Header -->
                                    <div class="border-bottom pb-2 mb-3">
                                        <div class="flex-grow-1">
                                            <span class="d-lg-none">{{ translate('Step 4 of 5') }}</span>
                                            <h3 class="card-header-title">{{ translate('Attributes') }}</h3>
                                        </div>
                                    </div>
                                    <!-- End Header -->

                                    <!-- Body -->
                                    <div class="">
                                        <div class="full-width product-attributes-wrapper">
                                            <!--<x-ev.form.select name="attributes" :items="$attributes" value-property="id" label-property="name" :tags="true" label="{{ translate('Attributes') }}" :multiple="true" placeholder="{{ translate('Search available attributes...') }}">
                                                <small class="text-muted">{{ translate('Choose the attributes of this product and then input values of each attribute.') }}</small>
                                            </x-ev.form.select>-->

                                            @if($attributes)
                                                @foreach($attributes as $attribute)
                                                    @php
                                                        $attribute = (object) $attribute; // NOTE: Retard doesn't work properly without a cast, even though it is an object in livewire component (facepalm)
                                                        $custom_properties = (object) $attribute->custom_properties;
                                                    @endphp
                                                    @if($attribute->selected ?? null)
                                                        @if($attribute->type === 'dropdown')
                                                            <x-ev.form.select name="attributes.{{ $attribute->id }}.attribute_values"
                                                                              error-bag-name="attributes.{{ $attribute->id }}"
                                                                              label="{{ $attribute->name }}"
                                                                              :items="$attribute->attribute_values"
                                                                              value-property="id"
                                                                              label-property="values"
                                                                              :multiple="($custom_properties->multiple ?? null) ? true : false"
                                                                              placeholder="{{ translate('Search or add values...') }}"
                                                                              data-attribute-id="{{ $attribute->id }}"
                                                                              data-type="{{ $attribute->type }}"
                                                                              :is-wired="false">
                                                                @if($custom_properties->multiple ?? null)
                                                                    <x-ev.form.toggle name="attributes.{{ $attribute->id }}.for_variations"
                                                                                      class="mt-2 mb-2"
                                                                                      append-text="{{ translate('Used for variations') }}"
                                                                                      :selected="$attribute->for_variations ?? false">
                                                                    </x-ev.form.toggle>
                                                                @endif
                                                            </x-ev.form.select>
                                                        @elseif($attribute->type === 'plain_text')
                                                            <x-ev.form.input name="attributes.{{ $attribute->id }}.attribute_values.0.values"
                                                                             type="text"
                                                                             label="{{ $attribute->name }}"
                                                                             data-attribute-id="{{ $attribute->id }}"
                                                                             error-bag-name="attributes.{{ $attribute->id }}"
                                                                             :value="$attribute->attribute_values->values ?? ''"
                                                                             data-type="{{ $attribute->type }}"
                                                                             wireType="defer">
                                                            </x-ev.form.input>
                                                        @elseif($attribute->type === 'number')
                                                            <x-ev.form.input name="attributes.{{ $attribute->id }}.attribute_values.0.values"
                                                                             type="number"
                                                                             label="{{ $attribute->name }}"
                                                                             :placement="!empty($custom_properties->unit ?? null) ? 'append' : 'prepend'"
                                                                             :text="!empty($custom_properties->unit ?? null) ? $custom_properties->unit : ''"
                                                                             data-attribute-id="{{ $attribute->id }}"
                                                                             error-bag-name="attributes.{{ $attribute->id }}"
                                                                             :value="$attribute->attribute_values->values ?? ''"
                                                                             :min="isset($custom_properties->min_value) ? $custom_properties->min_value : 0"
                                                                             :max="isset($custom_properties->max_value) ? $custom_properties->max_value : 999999999999999999999"
                                                                             data-type="{{ $attribute->type }}"
                                                                             wireType="defer">
                                                            </x-ev.form.input>
                                                        @elseif($attribute->type === 'date')
                                                            @php
                                                                $options = [
                                                                    'dateFormat' => ($custom_properties->with_time ?? false) ? 'd.m.Y H:i' : 'd.m.Y',
                                                                    'enableTime' => (bool) ($custom_properties->with_time ?? false),
                                                                    'mode' => ($custom_properties->range ?? false) ? 'range' : 'single',
                                                                ];
                                                            @endphp
                                                            <x-ev.form.date-time-picker name="attributes.{{ $attribute->id }}.attribute_values.0.values"
                                                                                        id="{{ 'date_' . $attribute->id }}"
                                                                                        label="{{ $attribute->name }}"
                                                                                        placeholder="{{ translate('Choose Date(s)...') }}"
                                                                                        error-bag-name="attributes.{{ $attribute->id }}"
                                                                                        data-attribute-id="{{ $attribute->id }}"
                                                                                        value="$attribute->attribute_values->values ?? []"
                                                                                        :options="$options"
                                                                                        icon="heroicon-o-calendar"
                                                                                        data-type="{{ $attribute->type }}"
                                                                                        wireType="defer">
                                                            </x-ev.form.date-time-picker>
                                                        @elseif($attribute->type === 'checkbox')
                                                            <x-ev.form.checkbox name="attributes.{{ $attribute->id }}.attribute_values"
                                                                                :append-to-name="true"
                                                                                value-property="selected"
                                                                                label-property="values"
                                                                                :items="$attribute->attribute_values"
                                                                                error-bag-name="attributes.{{ $attribute->id }}"
                                                                                data-attribute-id="{{ $attribute->id }}"
                                                                                label="{{ $attribute->name }}"
                                                                                data-type="{{ $attribute->type }}"
                                                                                wireType="defer">
                                                            </x-ev.form.checkbox>
                                                        @elseif($attribute->type === 'radio')
                                                            <x-ev.form.radio name="attributes.{{ $attribute->id }}.attribute_values"
                                                                                :append-to-name="true"
                                                                                value-property="selected"
                                                                                label-property="values"
                                                                                :items="$attribute->attribute_values"
                                                                                error-bag-name="attributes.{{ $attribute->id }}"
                                                                                data-attribute-id="{{ $attribute->id }}"
                                                                                label="{{ $attribute->name }}"
                                                                                data-type="{{ $attribute->type }}"
                                                                                :isWired="false">
                                                            </x-ev.form.radio>
                                                        @endif
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
                                                        onClick="document.dispatchEvent(new CustomEvent('validate-step', {detail: {component: @this, params: ['attributes', 'variations', false, ['attributes']]}}))"
                                                        wire:click="syncVariationsDatatable()"
                                                >
                                                    {{ translate('Continue') }} <i class="fas fa-angle-right ml-1"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Footer -->
                                </div>


                                <div id="productStepVariations" class="{{ $page === 'variations' ? 'active':'' }}" style="{{ $page !== 'variations' ? "display: block !important;" : "" }}">
                                    <!-- Header -->
                                    <div class="border-bottom pb-2 mb-3">
                                        <div class="flex-grow-1">
                                            <span class="d-lg-none">{{ translate('Step 5 of 6') }}</span>
                                            <h3 class="card-header-title">{{ translate('Variations') }}</h3>
                                        </div>
                                    </div>
                                    <!-- End Header -->

                                    <!-- Body -->
                                    <div class="pb-4">
                                        <div class="full-width product-variations-wrapper">
                                            <x-ev.modal color="primary"
                                                        id="product_variations_modal"
                                                        dialog-class="modal-xl"
                                                        body-class="d-flex flex-column"
                                                        btn-text="{{ translate('Edit product variations') }}"
                                                        header-title="{{ translate('Product Variations') }}"
                                                        trigger-wire-click="">
                                                <livewire:forms.products.product-variations-datatable
                                                    class="{{ $productVariationsDatatableClass }}"
                                                    :paginationEnabled="false"
                                                    :showSearch="false"
                                                    :emptyMessage="translate('Please generate all variations or add them manually.')"
                                                    :product="$this->product"
                                                    :variation-attributes="$this->variations_attributes"
                                                    wire-target="setVariationsData">
                                                </livewire:forms.products.product-variations-datatable>
                                            </x-ev.modal>


                                        </div>
                                    </div>


                                    <!-- Footer -->
                                    <div class="border-top pt-3">
                                        <div class="d-flex align-items-center">
                                            <button type="button" class="btn btn-ghost-secondary d-flex align-items-center"
                                                    data-hs-step-form-prev-options='{
                                                     "targetSelector": "#productStepAttributes"
                                                   }'>
                                                @svg('heroicon-o-chevron-left', ['style'=>'width:18px;'])
                                                {{ translate('Previous step') }}
                                            </button>

                                            <div class="ml-auto">
                                                <button type="button" class="btn btn-primary"
                                                        data-hs-step-form-prev-options='{
                                                         "targetSelector": "#productStepSEO"
                                                       }'>
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
                                            <span class="d-lg-none">{{ translate('Step 6 of 6') }}</span>
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
                                        <x-ev.form.textarea name="product.meta_description" rows="5" label="{{ translate('Meta Description') }}" placeholder="{{ translate('Meta description is used for Meta, OpenGraph, Twitter...') }}">
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
                                                    @if(!empty($product->id))
                                                        {{ translate('Update Product') }}
                                                    @else
                                                        {{ translate('Add Product') }}
                                                    @endif

                                                    <i class="fas fa-angle-right ml-1"></i>
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

    @if($product->id)
        <!-- Attribute for variation used value removal modal -->
        <x-ev.modal id="remove-selected-attribute-modal"
                    header-title="{{ translate('Remove selected attribute?') }}"
                    body-class="d-flex flex-column justify-content-center"
                    :has-trigger="false">
            <div class="d-flex flex-column justify-content-center">
                <h5>{{ translate('Are you sure you want to remove the selected attribute value?') }}</h5>
                <span class="small">
                    {{ translate('*Variations containing the value you want to remove will be marked as removed and you won\'t see them in Variations modal, but they are not removed instantly. They\'ll be removed once you update variations in the modal.*') }}
                </span>
            </div>
            <div class="d-flex align-items-center flex-row justify-content-center mt-3" >
                <button type="button" class="btn btn-primary mr-3 remove-btn">{{ translate('Remove') }}</button>
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal" aria-label="Close">{{ translate('Cancel') }}</button>
            </div>
        </x-ev.modal>
        <!-- Attribute for variation used value removal modal -->
    @endif
</div>


