    <!-- Products Section -->
    <div class="container" style="padding: 0;">
        <!-- Title -->
        <div class="w-md-80 w-lg-40 text-center mx-md-auto mb-3">
            <x-ev.label tag="h2" :label="ev_dynamic_translate('Products List Title', true)">
            </x-ev.label>
        </div>
        <!-- End Title -->

        <!-- Products -->
        @if ($slider)
            <div class="swiper">
                <div class="ev-slider">
                    <div class="swiper-wrapper">
                        <!-- Product -->
                        @foreach ($products as $product)
                            <div class="swiper-slide">
                                <x-default.products.cards.product-card :product="$product"
                                    style="{{ ev_dynamic_translate('product-card', true)->value }}">
                                </x-default.products.cards.product-card>
                            </div>
                        @endforeach


                        <!-- End Product -->

                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        @else
            <div class="row">
                <!-- Product -->
                @foreach ($products as $product)
                    <div class="col-sm-3">
                        <x-default.products.cards.product-card :product="$product"
                            style="product-card-detailed">
                        </x-default.products.cards.product-card>
                    </div>
                @endforeach


                <!-- End Product -->

            </div>
    </div>
    @endif
    <!-- End Products -->

    <div class="text-center">

        <x-ev.link-button :href="ev_dynamic_translate('#product-grid-link', true)"
        :label="ev_dynamic_translate('Product Grid Button', true)" class="btn btn-primary btn-pill transition-3d-hover px-5">
        </x-ev.link-button>
    </div>
    </div>
    <!-- End Products Section -->

    @push('footer_scripts')
        @if ($slider)

            <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

            <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
            <script>
                $(document).ready(function() {

                    if (window.innerWidth < 768) {
                        var swiper = new Swiper(".ev-slider", {
                            spaceBetween: 20,
                            effect: "cards",
                            slidesPerView: 1,
                            grabCursor: true,
                            autoplay: {
                                delay: 2500,
                                disableOnInteraction: true,

                            },

                            pagination: {
                                el: ".swiper-pagination",
                                clickable: true,
                            },
                        });
                    } else {
                        var swiper = new Swiper(".ev-slider", {
                            spaceBetween: 20,
                            slidesPerView: 4,
                            grabCursor: true,
                            pagination: {
                                el: ".swiper-pagination",
                                clickable: true,
                            },
                            autoHeight: true,
                        });
                    }


                });
            </script>

            <style>
                .swiper {
                    padding: 50px;
                }

            </style>
        @endif
    @endpush
