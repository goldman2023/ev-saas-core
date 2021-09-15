    <!-- Products Section -->
    <div class="container" style="padding: 0;">
        <!-- Title -->
        <div class="w-md-80 w-lg-40 text-center mx-md-auto mb-3">
            <x-ev.label tag="h2" :label="ev_dynamic_translate('Products List Title', true)">
            </x-ev.label>
        </div>
        <!-- End Title -->

        <!-- Products -->
        <div class="ev-slider mb-3">
            <div class="ev-slider-wrapper @if ($slider) js-slick-carousel @endif"

            data-hs-slick-carousel-options='{
                "slidesToShow": 4,
                "responsive": [{
                  "breakpoint": 768,
                  "settings": {
                    "arrows": false
                  }
                }]
              }'
          >

                <!-- Product -->

                @foreach ($products as $product)
                <div class="col-sm-4">
                    <div class="ev-slider-slide slick-slide">
                        <div class="w-100">
                            <x-default.products.cards.product-card :product="$product"
                                style="{{ ev_dynamic_translate('product-card', true)->value }}">
                            </x-default.products.cards.product-card>
                        </div>
                    </div>
                </div>

                @endforeach
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

    @push('footer_scripts')
        @if ($slider)

            @push('footer_scripts')


            @endpush
        @endif
    @endpush
