    <!-- Products Section -->
    <div class="container" style="padding: 0;">
        <!-- Title -->
        <div class="w-md-80 w-lg-40 text-center mx-md-auto mb-3">
            <x-ev.label tag="h2" :label="ev_dynamic_translate('Products List Title', true)">
            </x-ev.label>
        </div>
        <!-- End Title -->

        <!-- Products -->
        <div class="ev-slider">
            <div class="ev-slider-wrapper @if ($slider) js-slick-carousel slick-equal-height slick-gutters-2 slick-center-mode-right slick-center-mode-right-offset @endif" data-hs-slick-carousel-options='
            {
                "slidesToShow": 4,
                "infinite": false,
                "responsive": [{
                  "breakpoint": 1200,
                    "settings": {
                      "slidesToShow": 4
                    }
                  }, {
                  "breakpoint": 992,
                    "settings": {
                      "slidesToShow": 3
                    }
                  }, {
                  "breakpoint": 768,
                  "settings": {
                    "centerMode": true,
                    "slidesToShow": 2
                  }
                  }, {
                  "breakpoint": 554,
                  "settings": {
                    "slidesToShow": 1
                  }
                }]
              }
          '>

                <!-- Product -->
                @foreach ($products as $product)
                    <div class="ev-slider-slide slick-slide">
                        <div class="w-100">
                            <x-default.products.cards.product-card :product="$product"
                                style="{{ ev_dynamic_translate('product-card', true)->value }}">
                            </x-default.products.cards.product-card>
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

                <script src="{{ static_asset('front/js/hs.slick-carousel.js') }}"></script>

                <link href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css" rel="stylesheet">
                <link href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" rel="stylesheet">
                <!-- JS Plugins Init. -->
                <script>
                    $(function() {

                        // INITIALIZATION OF SLICK CAROUSEL
                        // =======================================================
                        $('.js-slick-carousel').each(function() {
                            var slickCarousel = $.HSCore.components.HSSlickCarousel.init($(this));
                        });
                    });
                </script>
            @endpush
        @endif
    @endpush
