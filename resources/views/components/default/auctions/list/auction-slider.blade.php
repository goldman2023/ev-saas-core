<style>
    .ev-auction-badge {
        position: absolute;
        top: 0;
        margin-left: auto;
        margin-right: auto;
    }

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

<div class="container">

    <div class="w-md-80 w-lg-40 text-center mx-md-auto mb-3 d-none">
        <x-ev.label tag="h3" :label="ev_dynamic_translate('Brands List Title', true)">
        </x-ev.label>
    </div>

    <div class="ev-brands-swiper">
        <div class="ev-brands-slider">
            <div class="row d-flex flex-nowrap" style="overflow: auto;">
                <!-- Product -->


                @foreach ($products as $key => $product)
                    <div class="col-3 col-sm text-center slick-slide position-relative">
                        <a href="{{ $product->getPermalink() }}" class="d-block rounded hov-shadow-md">
                            <x-tenant.system.image alt="{{ $product->getTranslation('name') }}"
                                class="lazyload mx-auto h-70px mw-100 bg-white" :image="$product->getThumbnail()">
                            </x-tenant.system.image>
                            @if ($key < 2)
                                <span class="badge badge-pill badge-success mt-2 ev-auction-badge">
                                    <div class="js-countdown text-white"
                                    data-hs-countdown-options='{
                                        "endDate": "2021/12/30"
                                    }'>
                                        <span class="js-cd-hours"></span>
                                        <span>H</span>
                                        <span class="js-cd-minutes"></span>
                                        <span>m</span>
                                        <span class="js-cd-seconds"></span>
                                        <span>s</span>
                                    </div>
                                </span>
                                {{-- TODO: Make this dynamic, with countdown option --}}
                                <span class="badge badge-pill badge-danger mt-2">
                                    {{ translate('Live now') }}
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
    <script src="https://cdn.jsdelivr.net/npm/jquery-countdown@2.2.0/dist/jquery.countdown.min.js"></script>
    <script src="{{ static_asset('vendor/hs.countdown.js', false, true) }}"></script>

    <script>
        // INITIALIZATION OF COUNTDOWNS
        // =======================================================
        $('.js-countdown').each(function() {
            var countdown = $.HSCore.components.HSCountdown.init($(this));
        });
    </script>


@endpush
