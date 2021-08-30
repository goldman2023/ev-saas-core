<div class="container p-sm-0">

    <div class="w-md-80 w-lg-40 text-center mx-md-auto mb-3">
        <x-ev.label tag="h2" :label="ev_dynamic_translate('Brands List Title', true)">
        </x-ev.label>
    </div>

    <div class="swiper ev-brands-swiper">
        <div class="ev-brands-slider">
            <div class="swiper-wrapper">
                <!-- Product -->


                @foreach ($brands as $brand)
                    <div class="text-center swiper-slide">
                        <a href="{{ route('products.brand', $brand->slug) }}"
                            class="d-block p-3 mb-3 border border-light rounded hov-shadow-md">
                            <img src="{{ uploaded_asset($brand->logo) }}" class="lazyload mx-auto h-70px mw-100"
                                alt="{{ $brand->getTranslation('name') }}">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@push('footer_scripts')
    <style>
        .ev-brands-slider img {
            width: 100px;
            height: 100px;
            padding: 10px;
            border-radius: 100%;
            background: white;
            object-fit: contain;
            border: 3px solid red;
        }

        .swiper.ev-brands-swiper {
            padding: 0 !important;
        }

    </style>
    <script>
        $(document).ready(function() {

            var swiper = new Swiper(".ev-brands-slider", {
                breakpoints: {
                    // when window width is >= 320px
                    768: {
                        slidesPerView: 6,
                        spaceBetween: 20
                    },

                    // when window width is >= 320px
                    500: {
                        slidesPerView: 2,
                        spaceBetween: 20
                    },
                }
            });
        });
    </script>
@endpush
