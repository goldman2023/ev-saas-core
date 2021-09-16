<!-- Hero Section -->

<div class="container space-2">
    <div class="row">
        <div class="col-lg-7 mb-7 mb-lg-0">
            <div class="pr-lg-4">
                <div class="position-relative">
                    <x-default.products.single.product-slider :product="$product">
                    </x-default.products.single.product-slider>
                    <!-- End Slider Nav -->

                </div>
                <div class="ev-product-price-list mt-3">
                    <x-ev.label class="h3" :label="ev_dynamic_translate('Price List', true)">
                    </x-ev.label>
                    <x-ev.dynamic-image class="avatar-img" :src="ev_dynamic_translate('#price-list-image')"
                        alt="Price list image" :widthInfos="[[300, '200w'], [1000, '1000w']]">
                    </x-ev.dynamic-image>
                </div>
            </div>
        </div>

        <!-- Product Description -->
        <div class="col-lg-5">
            <!-- Rating -->
            <div class="d-flex align-items-center small mb-2">
                <div class="text-warning mr-2">
                    @for ($i = 0; $i < 5; $i++)
                        @svg('heroicon-s-star', ['style' => 'width: 16px;'])
                    @endfor
                </div>

                <a class="link-underline" target="_blank" href="#reviewSection">
                    {{ translate('Read all') }} {{ $product->reviews()->count() }} {{ translate('reviews') }}
                </a>
            </div>
            <!-- End Rating -->

            <!-- Title -->
            <div class="mb-5">
                <h1 class="h2">{{ $product->getTranslation('name') }}</h1>
                <p>
                    {!! $product->short_description !!}
                </p>
            </div>

            <!-- End Title -->
            <div class="product-description mb-3">
                {{ $product->getTranslation('description') }}
            </div>

            <!-- Price -->
            <div class="mb-5">
                <h2 class="font-size-1 text-body mb-0">{{ translate('Price:') }}</h2>

                <span class="text-dark font-size-2 font-weight-bold">
                    {{ home_discounted_price($product->id) }}
                    @if ($product->unit != null)
                        <span class="opacity-70">/
                            {{ $product->getTranslation('unit') }}
                        </span>
                    @endif
                </span>
                @if (home_price($product->id) != home_discounted_price($product->id))
                    <span class="text-body ml-2"><del>{{ home_price($product->id) }}</del></span>
                @endif
            </div>
            <!-- End Price -->

            {{-- Brand --}}


            {{-- End Seller Info --}}
            {{-- End Brand --}}

            <!-- Quantity -->

            <!-- End Quantity -->

            <!-- Accordion -->

            <!-- End Accordion -->



            <div class="row">
                <div class="col-sm-12 col-md-12 mb-4 mb-sm-0">
                    <!-- Media -->
                    <div class="media">
                        <div class="avatar avatar-lg avatar-circle mr-3">
                            <x-ev.dynamic-image class="avatar-img"
                                :src="ev_dynamic_translate('#sales-agent-image', true)" alt="Sales agent image"
                                :widthInfos="[[300, '200w'], [1000, '1000w']]">
                            </x-ev.dynamic-image>
                        </div>

                        <div class="media-body">
                            <h4 class="mb-1">
                                <a class="text-dark" href="#">
                                    {{ translate('Sales Agent Name') }}
                                </a>
                            </h4>

                            <span class="d-block font-size-1 mb-1">
                                {{ translate('Sales Agent Phone') }}
                            </span>

                            <span class="d-block font-size-1 mb-1">
                                {{ translate('Sales Agent Email') }}
                            </span>

                            <a class="link" href="#">{{ translate('Sales Agent Title') }}</a>
                        </div>
                    </div>
                    <!-- End Media -->
                </div>


            </div>

            <!-- Help Link -->

            <!-- End Help Link -->

            <x-default.products.single.product-benefits> </x-default.products.single.product-benefits>
        </div>
        <!-- End Product Description -->
    </div>
</div>
<!-- End Hero Section -->

@push('footer_scripts')


    <!-- JS Plugins Init. -->
    <script>
        $(function() {
            // INITIALIZATION OF QUANTITY COUNTER
            // =======================================================
            $('.js-quantity-counter').each(function() {
                // var quantityCounter = new HSQuantityCounter($(this)).init();
            });
        });
    </script>
@endpush
