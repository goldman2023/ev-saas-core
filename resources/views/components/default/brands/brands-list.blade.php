<div class="container space-1 mt-3 mt-lg-0">

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
                "autoplaySpeed": 7000,
                "responsive": [{
                    "breakpoint": 768,
                    "settings": {
                    "slidesToShow": 4,
                      "arrows": false
                    }}]
                }'>
                <!-- Product -->


                @foreach ($brands as $key => $brand)
                <div class="text-center slick-slide">
                    <a href="{{ route('products.brand', $brand->slug) }}" class="d-block rounded hov-shadow-md position-relative">
                        <img src="{{ uploaded_asset($brand->logo) }}" class="lazyload mx-auto h-70px mw-100 bg-white"
                            alt="{{ $brand->getTranslation('name') }}">

                        <span class="badge badge-pill badge-primary mt-2">
                            {{ $brand->products()->count() }} {{ translate('Items') }}
                        </span>
                        {{-- TODO Make this dynamic --}}
                        @if($key == 1)
                        <span class="badge badge-pill badge-success mt-2 position-absolute top-0 left-3 z-index-10">
                            {{ translate('New!') }}
                        </span>
                        @endif

                        @if($key == 3)
                        <span class="badge badge-pill badge-warning text-white mt-2 position-absolute top-0 left-3">
                            {{ translate('Promotion!') }}
                        </span>
                        @endif
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
        object-fit: scale-down;
        border: 2px solid red;
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
