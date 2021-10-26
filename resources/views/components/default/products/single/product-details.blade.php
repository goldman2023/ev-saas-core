<!-- Hero Section -->

<div class="container space-2" id="productDetailsContainer">
    <div class="row">
        <div class="col-lg-7 mb-7 mb-lg-0">
            <div class="pr-lg-4">
                <div class="position-relative">
                    <x-default.products.single.product-slider :product="$product">
                    </x-default.products.single.product-slider>
                    <!-- End Slider Nav -->
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
                <a class="link-underline" href="#reviewSection">
                    {{ translate('Read all') }} {{ $product->reviews()->count() }} {{ translate('reviews') }}
                </a>
            </div>
            <!-- End Rating -->

            <!-- Title -->
            <div class="mb-3">
                <h1 class="h2">{{ $product->getTranslation('name') }}</h1>
                @if (!empty($product->excerpt))
                    <p>
                        {!! $product->excerpt !!}
                    </p>
                @endif
            </div>

            <!-- Price -->
            <div class="mb-3">
                <h2 class="font-size-1 text-body mb-0">{{ translate('Price:') }}</h2>

            </div>

            <!-- End Price -->

            {{-- Brand --}}
            <div class="mb-5">
                <div class="row">
                    <div class="col-sm-6 d-flex flex-column">
                        <small class="mr-2 opacity-50">{{ translate('Sold by') }}: </small>
                        @if ($product->added_by == 'seller' && get_setting('vendor_system_activation') == 1)
                            <a href="{{ route('shop.visit', $product->shop->slug) }}" class="text-reset font-weight-bold ">
                                {{ $product->shop->name }}
                            </a>
                        @else
                            {{-- {{ translate('Inhouse product') }} --}}
                            <strong class="text-reset">{{ get_site_name() }}</strong>
                        @endif

                        @if (get_setting('conversation_system') == 1)
                            <button class="mt-2 btn btn-xs btn-soft-primary mr-auto" onclick="show_chat_modal()">
                                {{ translate('Message Seller') }}
                            </button>
                        @endif
                    </div>
                    @if ($product->brand != null)
                        <div class="col-sm-6">
                            <small class="mr-2 opacity-50">{{ translate('Manufacturer:') }} </small>
                            <a href="{{ route('products.brand', $product->brand->slug) }}">
                                <img class="" src="{{ uploaded_asset($product->brand->logo ?? '') }}"
                                    alt="{{ $product->brand->getTranslation('name') }}" height="60">
                            </a>
                        </div>
                    @endif
                </div>

            </div>
            {{-- End Brand --}}


            <!-- Price -->
            <div class="mb-3">
                <h2 class="font-size-1 text-body mb-2">{{ translate('Price:') }}</h2>
                <livewire:tenant.product.price :product="$product"></livewire:tenant.product.price>
            </div>
            <!-- End Price -->

            {{-- Seller Info --}}
            {{-- End Seller Info --}}

            <!-- Product: Variations -->
            @if ($product->has_variations())
                <livewire:tenant.product.product-variations-selector :product="$product">
                </livewire:tenant.product.product-variations-selector>
            @endif
            <!-- End Product: Variations -->

            <!-- Quantity -->
            <div class="border rounded-lg py-2 px-3 mb-3">
                <div class="js-quantity-counter row align-items-center">
                    <div class="col-7">
                        <small class="d-block text-body font-weight-bold">
                            {{ translate('Select quantity') }}
                        </small>
                        <input class="js-result form-control h-auto border-0 rounded-lg p-0" type="text" value="1">
                    </div>
                    <div class="col-5 text-right">
                        <a class="js-minus btn btn-xs btn-icon btn-outline-secondary rounded-circle"
                            href="javascript:;">
                            <i class="la la-plus"></i>
                            <span class="card-btn-toggle-active">−</span>
                        </a>
                        <a class="js-plus btn btn-xs btn-icon btn-outline-secondary rounded-circle" href="javascript:;">
                            <span class="card-btn-toggle-active">+</span>
                        </a>
                    </div>
                </div>
            </div>
            <!-- End Quantity -->

            <!-- Product: Benefits -->
            <!-- End Product: Benefits -->

            <div class="d-flex justify-content-end my-4">
                <x-ev.button class="btn btn-outline-dark btn-pill px-4 w-auto mr-3 d-flex align-items-center">
                    @svg('heroicon-o-heart', ['style' => 'width: 18px; height: 18px; margin-right: 8px; position:
                    relative; top: -1px;'])
                    {{ translate('Add to wishlist') }}
                </x-ev.button>
                <x-ev.button class="btn btn-primary btn-pill px-4 w-auto d-flex align-items-center">
                    {{ translate('Add to cart') }}
                </x-ev.button>
            </div>

            <x-default.products.single.product-benefits> </x-default.products.single.product-benefits>


            <!-- Help Link -->
            <div class="media align-items-center pt-2 border-top">
                <span class="w-100 max-w-6rem mr-2">
                    @svg('heroicon-s-chat-alt-2')
                </span>
                <div class="media-body text-body small">
                    <span class="font-weight-bold mr-1">{{ translate('Need Help?') }}</span>
                    <a class="link-underline" href="#">{{ translate('Contact support') }}</a>
                </div>
            </div>
            <!-- End Help Link -->
        </div>
        <!-- End Product Description -->
    </div>
</div>
<!-- End Hero Section -->


@push('footer_scripts')
    <script src="{{ static_asset('vendor/hs-quantity-counter/dist/hs-quantity-counter.min.js', false, true) }}"></script>

    <!-- JS Plugins Init. -->
    <script>
        $(function() {

            // INITIALIZATION OF STICKY BLOCK
            $('.js-sticky-block').each(function() {
                var stickyBlock = new HSStickyBlock($(this)).init();
            });

            // INITIALIZATION OF QUANTITY COUNTER
            // =======================================================
            $('.js-quantity-counter').each(function() {
                let quantityCounter = new HSQuantityCounter($(this)).init();
            });
        });
    </script>
@endpush
