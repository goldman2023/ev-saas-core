<!-- Hero Section -->
@php
$photos = explode(',', $product->photos);

@endphp
<div class="container space-2">
    <div class="row">
        <div class="col-lg-7 mb-7 mb-lg-0">
            <div class="pr-lg-4">
                <div class="position-relative">
                    <!-- Main Slider -->
                    <div id="heroSlider" class="js-slick-carousel slick border rounded-lg"
                        data-hs-slick-carousel-options='{
                   "fade": true,
                   "infinite": true,
                   "autoplay": true,
                   "autoplaySpeed": 7000,
                   "asNavFor": "#heroSliderNav"
                 }'>

                        @foreach ($photos as $photo)
                            <div class="js-slide">
                                <x-tenant.system.image class="img-fluid w-100 rounded-lg" :image="$photo">
                                </x-tenant.system.image>
                            </div>
                        @endforeach

                    </div>
                    <!-- End Main Slider -->

                    <!-- Slider Nav -->
                    <div class="position-absolute bottom-0 right-0 left-0 px-4 py-3">
                        <div id="heroSliderNav"
                            class="js-slick-carousel slick slick-gutters-1 slick-transform-off max-w-27rem mx-auto"
                            data-hs-slick-carousel-options='{
                     "infinite": true,
                     "autoplaySpeed": 7000,
                     "slidesToShow": 3,
                     "isThumbs": true,
                     "isThumbsProgress": true,
                     "thumbsProgressOptions": {
                       "color": "#377dff",
                       "width": 8
                     },
                     "thumbsProgressContainer": ".js-slick-thumb-progress",
                     "asNavFor": "#heroSlider"
                   }'>
                            @foreach ($photos as $photo)
                                <div class="js-slide p-1">
                                    <a class="js-slick-thumb-progress d-block avatar avatar-circle border p-1"
                                        href="javascript:;">
                                        <x-tenant.system.image class="avatar-img" :image="$photo">
                                        </x-tenant.system.image>
                                    </a>

                                </div>

                            @endforeach


                        </div>
                    </div>
                    <!-- End Slider Nav -->
                </div>
            </div>
        </div>

        <!-- Product Description -->
        <div class="col-lg-5">
            <!-- Rating -->
            <div class="d-flex align-items-center small mb-2">
                <div class="text-warning mr-2">
                    @svg('heroicon-s-star')
                </div>
                <a class="link-underline" href="#reviewSection">Read all 287 reviews</a>
            </div>
            <!-- End Rating -->

            <!-- Title -->
            <div class="mb-5">
                <h1 class="h2">{{ $product->getTranslation('name') }}</h1>
                <p>American label New Era manufacturing baseball hats for teams since the 1930s.</p>
            </div>

            <!-- End Title -->

            <!-- Price -->
            <div class="mb-5">
                <h2 class="font-size-1 text-body mb-0">{{ translate('Price:') }}</h2>

                <span class="text-dark font-size-2 font-weight-bold">
                    {{ home_discounted_price($product->id) }}
                    @if($product->unit != null)
                    <span class="opacity-70">/
                        {{ $product->getTranslation('unit') }}
                    </span>
                @endif
            </span>
            @if(home_price($product->id) != home_discounted_price($product->id))
                <span class="text-body ml-2"><del>{{ home_price($product->id) }}</del></span>
                @endif
            </div>
            <!-- End Price -->

            {{-- Brand --}}
            <div class="mb-5">
                <div class="row">
                    <div class="col-sm-6">
                        <small class="mr-2 opacity-50">{{ translate('Sold by') }}: </small><br>
                        @if ($product->added_by == 'seller' && \App\Models\BusinessSetting::where('type', 'vendor_system_activation')->first()->value == 1)
                            <a href="{{ route('shop.visit', $product->user->shop->slug) }}" class="text-reset">
                                {{ $product->user->shop->name }}
                            </a>
                        @else
                            {{ translate('Inhouse product') }}
                        @endif

                        @if (\App\Models\BusinessSetting::where('type', 'conversation_system')->first()->value == 1)
                            <button class="mt-2 btn btn-sm btn-soft-primary" onclick="show_chat_modal()">
                                {{ translate('Message Seller') }}
                            </button>
                        @endif
                    </div>
                    <div class="col-sm-6">
                        <small class="mr-2 opacity-50">{{ translate('Manufacturer:') }} </small><br>

                        @if ($product->brand != null)
                            <a href="{{ route('products.brand', $product->brand->slug) }}">
                                <img src="{{ uploaded_asset($product->brand->logo ?? '') }}"
                                    alt="{{ $product->brand->getTranslation('name') }}" height="30">
                            </a>
                        @endif
                    </div>
                </div>

            </div>

            {{-- Seller Info --}}
            <div class="mb-5">

            </div>

            {{-- End Seller Info --}}
            {{-- End Brand --}}

            <!-- Quantity -->
            <div class="border rounded-lg py-2 px-3 mb-3">
                <div class="js-quantity-counter row align-items-center">
                    <div class="col-7">
                        <small class="d-block text-body font-weight-bold">Select quantity</small>
                        <input class="js-result form-control h-auto border-0 rounded-lg p-0" type="text" value="1">
                    </div>
                    <div class="col-5 text-right">
                        <a class="js-minus btn btn-xs btn-icon btn-outline-secondary rounded-circle"
                            href="javascript:;">
                            <i class="la la-minus"></i>
                        </a>
                        <a class="js-plus btn btn-xs btn-icon btn-outline-secondary rounded-circle" href="javascript:;">
                            <i class="la la-plus"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!-- End Quantity -->

            <!-- Accordion -->
            <div id="shopCartAccordionExample2" class="accordion mb-5">
                <!-- Card -->
                <div class="card card-bordered shadow-none">
                    <div class="card-body card-collapse" id="shopCardHeadingOne">
                        <a class="btn btn-link btn-block card-btn collapsed" href="javascript:;" role="button"
                            data-toggle="collapse" data-target="#shopCardOne" aria-expanded="false"
                            aria-controls="shopCardOne">
                            <span class="row align-items-center">
                                <span class="col-9">
                                    <span class="media align-items-center">
                                        <span class="w-100 max-w-6rem mr-3">
                                            <img class="img-fluid"
                                                src="https://htmlstream.com/front/assets/svg/icons/icon-65.svg"
                                                alt="SVG">
                                        </span>
                                        <span class="media-body">
                                            <span class="d-block font-size-1 font-weight-bold">Free shipping</span>
                                        </span>
                                    </span>
                                </span>
                                <span class="col-3 text-right">
                                    <span class="card-btn-toggle">
                                        <span class="card-btn-toggle-default">+</span>
                                        <span class="card-btn-toggle-active">−</span>
                                    </span>
                                </span>
                            </span>
                        </a>
                    </div>
                    <div id="shopCardOne" class="collapse" aria-labelledby="shopCardHeadingOne"
                        data-parent="#shopCartAccordionExample2">
                        <div class="card-body">
                            <p class="small mb-0">We offer free shipping anywhere in the U.S. A skilled delivery team
                                will
                                bring the boxes into your office.</p>
                        </div>
                    </div>
                </div>
                <!-- End Card -->

                <!-- Card -->
                <div class="card card-bordered shadow-none">
                    <div class="card-body card-collapse" id="shopCardHeadingTwo">
                        <a class="btn btn-link btn-block card-btn collapsed" href="javascript:;" role="button"
                            data-toggle="collapse" data-target="#shopCardTwo" aria-expanded="false"
                            aria-controls="shopCardTwo">
                            <span class="row align-items-center">
                                <span class="col-9">
                                    <span class="media align-items-center">
                                        <span class="w-100 max-w-6rem mr-3">
                                            <img class="img-fluid"
                                                src="https://htmlstream.com/front/assets/svg/icons/icon-64.svg"
                                                alt="SVG">
                                        </span>
                                        <span class="media-body">
                                            <span class="d-block font-size-1 font-weight-bold">30 Days return</span>
                                        </span>
                                    </span>
                                </span>
                                <span class="col-3 text-right">
                                    <span class="card-btn-toggle">
                                        <span class="card-btn-toggle-default">+</span>
                                        <span class="card-btn-toggle-active">−</span>
                                    </span>
                                </span>
                            </span>
                        </a>
                    </div>
                    <div id="shopCardTwo" class="collapse" aria-labelledby="shopCardHeadingTwo"
                        data-parent="#shopCartAccordionExample2">
                        <div class="card-body">
                            <p class="small mb-0">If you're not satisfied, return it for a full refund. We'll take care
                                of
                                disassembly and return shipping.</p>
                        </div>
                    </div>
                </div>
                <!-- End Card -->
            </div>
            <!-- End Accordion -->

            <div class="mb-4">
                <button type="button" class="btn btn-block btn-primary btn-pill transition-3d-hover">Add to
                    Cart</button>
            </div>

            <!-- Help Link -->
            <div class="media align-items-center">
                <span class="w-100 max-w-6rem mr-2">
                    <img class="img-fluid" src="https://htmlstream.com/front/assets/svg/icons/icon-4.svg" alt="SVG">
                </span>
                <div class="media-body text-body small">
                    <span class="font-weight-bold mr-1">Need Help?</span>
                    <a class="link-underline" href="#">Chat now</a>
                </div>
            </div>
            <!-- End Help Link -->
        </div>
        <!-- End Product Description -->
    </div>
</div>
<!-- End Hero Section -->

@push('footer_scripts')
    <!-- JS Plugins Init. -->
    <script>
        $(document).on('ready', function() {
            // INITIALIZATION OF SLICK CAROUSEL
            // =======================================================
            $('.js-slick-carousel').each(function() {
                var slickCarousel = $.HSCore.components.HSSlickCarousel.init($(this));
            });

            // INITIALIZATION OF QUANTITY COUNTER
            // =======================================================
            $('.js-quantity-counter').each(function() {
                var quantityCounter = new HSQuantityCounter($(this)).init();
            });

        });
    </script>
@endpush
