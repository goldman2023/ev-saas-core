<form class="lw-form js-step-form-1"
      data-hs-step-form-options='{
          "progressSelector": "#productStepFormProgress",
          "stepsSelector": "#productStepFormContent",
          "endSelector": "#uploadResumeFinishBtn",
          "isValidate": false
        }'>
        <div class="row">
            <div id="stickyBlockStartPoint" class="col-lg-4">
                <!-- Sticky Block -->
                <div class="js-sticky-block"
                     data-hs-sticky-block-options='{
                                           "parentSelector": "#stickyBlockStartPoint",
                                           "breakpoint": "lg",
                                           "startPoint": "#stickyBlockStartPoint",
                                           "endPoint": "#stickyBlockEndPoint",
                                           "stickyOffsetTop": 20,
                                           "stickyOffsetBottom": 0
                                         }'>
                    <!-- Step -->
                    <ul id="productStepFormProgress" class="js-step-progress step step-icon-xs step-border-last-0 mt-2">
                        <li class="step-item {{ $page === 'general' ? 'active':'' }}">
                            <a class="step-content-wrapper" href="javascript:;"
                               data-hs-step-form-next-options='{
                                                      "targetSelector": "#productStepGeneral"
                                                    }'
                                wire:click="$set('page', 'general')">
                                <span class="step-icon step-icon-soft-dark">1</span>
                                <div class="step-content">
                                    <span class="step-title">{{ translate('General') }}</span>
                                    <span class="step-title-description step-text font-size-1">{{ translate('General product info') }}</span>
                                </div>
                            </a>
                        </li>

                        <li class="step-item {{ $page === 'content' ? 'active':'' }}">
                            <a class="step-content-wrapper" href="javascript:;"
                               data-hs-step-form-next-options='{
                                                      "targetSelector": "#productStepContent"
                                                   }'
                               wire:click="$set('page', 'content')">
                                <span class="step-icon step-icon-soft-dark">2</span>
                                <div class="step-content">
                                    <span class="step-title">{{ translate('Content') }}</span>
                                    <span class="step-title-description step-text font-size-1">{{ translate('Beautify your product!') }}</span>
                                </div>
                            </a>
                        </li>

                        <li class="step-item {{ $page === 'price_stock_shipping' ? 'active':'' }}">
                            <a class="step-content-wrapper" href="javascript:;"
                               data-hs-step-form-next-options='{
                                  "targetSelector": "#productStepPriceStockShipping"
                                }'
                               wire:click="$set('page', 'price_stock_shipping')">
                                <span class="step-icon step-icon-soft-dark">3</span>
                                <div class="step-content">
                                    <span class="step-title">{{ translate('Price, stock and shipping') }}</span>
                                    <span class="step-title-description step-text font-size-1">{{ translate('Price, stock and shipping details') }}</span>
                                </div>
                            </a>
                        </li>

                        <li class="step-item {{ $page === 'attributes_variations' ? 'active':'' }}">
                            <a class="step-content-wrapper" href="javascript:;"
                               data-hs-step-form-next-options='{
                                  "targetSelector": "#productStepAttributesVariations"
                                }'
                               wire:click="$set('page', 'attributes_variations')">
                                <span class="step-icon step-icon-soft-dark">4</span>
                                <div class="step-content">
                                    <span class="step-title">{{ translate('Attributes & variations') }}</span>
                                    <span class="step-title-description step-text font-size-1">{{ translate('Add product attributes and variations') }}</span>
                                </div>
                            </a>
                        </li>

                        <li class="step-item">
                            <a class="step-content-wrapper" href="javascript:;"
                               data-hs-step-form-next-options='{
                      "targetSelector": "#uploadResumeStepTypeOfJob"
                    }'>
                                <span class="step-icon step-icon-soft-dark">5</span>
                                <div class="step-content">
                                    <span class="step-title">Job type</span>
                                    <span class="step-title-description step-text font-size-1">The type of job you are looking for</span>
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

                            <x-ev.form.select name="product.unit" :items="EV::getMappedUnits()" label="{{ translate('Unit') }}" placeholder="{{ translate('Choose the product unit...') }}" />

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
                            <x-ev.form.file-selector name="product.thumbnail_img" label="Thumbnail image" data_type="image" placeholder="Choose file..."></x-ev.form.file-selector>
                            <x-ev.form.file-selector name="product.photos" label="Gallery images" :multiple="true" data_type="image" placeholder="Choose files..."></x-ev.form.file-selector>

                            <!-- Video -->
                            <x-ev.form.select name="product.video_provider" :items="EV::getMappedVideoProviders()" label="{{ translate('Video provider') }}"  placeholder="{{ translate('Select the provider...') }}" />
                            <x-ev.form.input name="product.video_link" type="text" label="{{ translate('Video link') }}" placeholder="{{ translate('Link to the video...') }}" >
                                <small class="text-muted">{{ translate('Use proper link without extra parameter. Don\'t use short share link/embeded iframe code.') }}</small>
                            </x-ev.form.input>

                            <!-- PDF Specification -->
                            <x-ev.form.file-selector name="product.pdf" label="{{ translate('PDF Specification (optional)') }}" datatype="document" placeholder="Choose file..."></x-ev.form.file-selector>

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
                            <x-ev.form.input name="product.purchase_price" type="number" label="{{ translate('Purchase price') }}" :required="true"  min="0" step="0.01">

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

                            <x-ev.form.input name="product.set_shipping_days" type="number" label="{{ translate('Estimate shipping time') }}" placement="append" text="{{ translate('Days') }}" min="1" step="1"></x-ev.form.input>
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
                                        @if($attribute->selected)
                                            <x-ev.form.select name="attributes.{{ $attribute->id }}.attribute_values"
                                                              label="{{ $attribute->name }}"
                                                              :items="$attribute->attribute_values"
                                                              value-property="id"
                                                              label-property="values"
                                                              :tags="true"
                                                              :multiple="true"
                                                              placeholder="{{ translate('Search or add values...') }}">
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


                            <script>
                                $(function() {
                                    $('select[name="attributes"]').on('change', function(e, data) {
                                        if(data && data.init) return;

                                        let $att_idx = $(this).val().map(x => parseInt(x, 10));
                                        let $atts = @this.get('attributes');

                                        for (const index in $atts) {
                                            if($att_idx.indexOf($atts[index].id) === -1) {
                                                @this.set('attributes.'+$atts[index].id+'.selected', false);
                                            } else {
                                                @this.set('attributes.'+$atts[index].id+'.selected', true);
                                            }
                                        }
                                    });
                                });
                            </script>
                        </div>
                        <!-- End Body -->

                        <!-- Footer -->
                        <div class="border-top pt-3">
                            <div class="d-flex align-items-center">
                                <button type="button" class="btn btn-ghost-secondary d-flex align-item-scenter"
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
                </div>

                <!-- Message Body -->
                <div id="successMessageContent" style="display: none;">
                    <div class="text-center">
                        <img class="img-fluid mb-3" src="../assets/svg/illustrations/medal.svg" alt="Image Description" style="max-width: 15rem;">

                        <div class="mb-4">
                            <h2>Successful!</h2>
                            <p>Your resume job has been successfully created.</p>
                        </div>

                        <div class="d-flex justify-content-center">
                            <a class="btn btn-primary" href="employee.html">
                                Go to profile <i class="fas fa-angle-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- End Message Body -->

                <!-- Sticky Block End Point -->
                <div id="stickyBlockEndPoint"></div>
            </div>
        </div>
        <!-- End Row -->
</form>
