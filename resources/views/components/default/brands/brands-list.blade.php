<div class="container space-1">

    <div class="w-md-80 w-lg-40 text-center mx-md-auto mb-3 d-none">
        <x-ev.label tag="h3" :label="ev_dynamic_translate('Brands List Title', true)">
        </x-ev.label>
    </div>

    <div class="ev-brands-swiper">
        <div class="ev-brands-slider">
            <div class="js-slick-carousel" data-hs-slick-carousel-options='{
                "slidesToShow" : 6,
                "fade": false,
                "infinite": false,
                "autoplay": true,
                "autoplaySpeed": 7000
                }'>
                <!-- Product -->


                @foreach ($brands as $brand)
                    <div class="text-center slick-slide">
                        <a href="{{ route('products.brand', $brand->slug) }}"
                            class="d-block border border-light rounded hov-shadow-md">
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

        @media(max-width: 768px) {
            .ev-brands-slider img {
                width: 65px;
                height: 65px;
                padding: 3px;
            }
        }

    </style>

@endpush
