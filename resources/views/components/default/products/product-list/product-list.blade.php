    <!-- Products Section -->
    <div class="container">
        <!-- Title -->
        <div class="w-md-80 w-lg-40 text-center mx-md-auto mb-3">
            <x-ev.label tag="h2" :label="ev_dynamic_translate('Products List Title', true)">
            </x-ev.label>
        </div>
        <!-- End Title -->
        <!-- Products -->
        <div class="ev-slider mb-3">
            <div class="ev-slider-wrapper @if ($slider) js-slick-carousel @endif" data-hs-slick-carousel-options='{
                "slidesToShow": 4,
                "arrows": true,
                "dots": true,
                "responsive": [{
                  "breakpoint": 768,
                  "settings": {
                      "slidesToShow": 1,
                    "arrows": false
                  }
                }]
              }'>

                <!-- Product -->
                @if (!$slider)
                    <div class="row">
                @endif

                @if($products->isNotEmpty())
                    @foreach ($products as $product)
                        <div class="ev-slider-slide  @if ($slider) slick-slide @else col-sm-3 @endif mb-3 p-3">
                            <div class="w-100 h-100">
                                <x-default.products.cards.product-card :product="$product" class="product-card-detailed-2"
                                                                       style="{{ ev_dynamic_translate('product-card', true)->value }}">
                                </x-default.products.cards.product-card>
                            </div>
                        </div>
                    @endforeach
                @endif

                @if (!$slider)
                    </div>
                @endif

            <!-- End Product -->
        </div>
    </div>
    <div class="swiper-pagination"></div>
    </div>

    <!-- End Products -->

    <div class="text-center">

        <x-ev.link-button :href="ev_dynamic_translate('#product-grid-link', true)"
            :label="ev_dynamic_translate('Product Grid Button', true)"
            class="btn btn-primary btn-pill transition-3d-hover px-5">
        </x-ev.link-button>
    </div>
    </div>
    <!-- End Products Section -->
