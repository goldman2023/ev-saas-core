    <!-- Products Section -->
    <div class="ev-top-products-slider-section" style="padding: 0;">

        <!-- End Title -->

        <!-- Products -->
        <div class="ev-slider">
            <div class="ev-slider-wrapper @if ($slider) js-slick-carousel slick-equal-height @endif" data-hs-slick-carousel-options='
            {
                "slidesToShow": 4,
                "centerPadding": "40px",
                "slidesToShow": 3,
                "infinite": false
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
    <!-- End Products Section -->

    @push('footer_scripts')

    @endpush
