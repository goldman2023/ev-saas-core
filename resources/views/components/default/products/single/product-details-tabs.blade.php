<div class="mb-9 mb-lg-0  p-3 ">
    <div class="row justify-content-lg-between mb-7">
        <div class="col-12 col-sm-7 mb-5 mb-sm-0">
            <h1 class="h2 mb-0">{{ $product->name }}</h1>
            <span class="d-block text-dark mb-3">
                <div class="d-flex ml-auto">
                    @for ($i = 0; $i < 5; $i++)
                        @svg('heroicon-s-star', ["class"=> 'text-warning ev-icon__xs'])
                    @endfor
                </div>
            </span>

            <ul class="list-inline list-separator font-size-1 text-body d-flex">
                <li class="list-inline-item align-items-center d-flex">
                    @svg('heroicon-s-eye', ["class" => 'ev-icon__xs mr-2'])
                    {{ translate('Views: ') }} {{ $product->public_view_count() }}
                </li>
                <li class="list-inline-item align-items-center d-flex">
                    @svg('heroicon-s-location-marker', ["class" => 'text-success ev-icon__xs mr-1'])
                    {{-- TODO: make this dynamic --}}
                    {{ translate('Item Location:') }} Lithuania
                </li>
                <li class="list-inline-item  align-items-center d-flex">
                    @svg('heroicon-s-globe', ["class" => 'ev-icon__xs mr-1'])
                    {{ translate('Shipping globaly') }}
                </li>
            </ul>
        </div>

        <div class="col-sm-5 column-divider-sm">
            <div class="pl-md-4">
                <h2 class="mb-0">
                    @if ($product->getBasePrice() != $product->getTotalPrice())
                    <del class="h3 fw-600 opacity-50 mr-1">
                        {{ $product->getBasePrice(true) }}
                    </del>
                    @endif
                    <span class="h2 fw-700 text-primary">
                        {{ $product->getTotalPrice(true) }}</span>
                    </span>
                </h2>
                <span class="d-block text-dark mb-3">Est. Shipping 30€</span>
                @guest
                <a href="{{ route('register') }}">Register and get shipping price</a>
                @endguest
            </div>
        </div>
    </div>
    <!-- End Row -->

    <!-- Nav Classic -->
    <ul class="nav nav-segment nav-fill" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="property-details-tab" data-toggle="pill" href="#property-details" role="tab"
                aria-controls="property-details" aria-selected="true">
                <div class="d-md-flex justify-content-md-center align-items-md-center">
                    @svg('heroicon-o-book-open', ['class' => 'ev-icon__xs mr-1'])


                    {{ translate('Details') }}
                </div>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" id="property-map-tab" data-toggle="pill" href="#property-map" role="tab"
                aria-controls="property-map" aria-selected="false">
                <div class="d-md-flex justify-content-md-center align-items-md-center">
                    @svg('heroicon-o-star', ['class' => 'ev-icon__xs mr-1'])

                    {{ translate('Reviews') }}
                </div>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="property-market-stats-tab" data-toggle="pill" href="#property-market-stats"
                role="tab" aria-controls="property-market-stats" aria-selected="false">
                <div class="d-md-flex justify-content-md-center align-items-md-center">
                    @svg('heroicon-o-user-group', ['class' => 'ev-icon__xs mr-1'])

                    {{ translate('Book a Reservation') }}
                </div>
            </a>
        </li>
    </ul>
    <!-- End Nav Classic -->

    <!-- Tab Content -->
    <div class="tab-content">
        <div class="tab-pane fade mt-6 show active" id="property-details" role="tabpanel"
            aria-labelledby="property-details-tab">
            <!-- View Info -->


            <div class="border-top border-bottom py-4 mt-4 mb-7">
                <div class="row justify-content-sm-between">
                    <div class="col-sm-6 text-sm-right mb-2 mb-sm-0">
                        <div class="pr-md-4">
                            <span>Last 30 days:</span>
                            <span class="text-dark font-weight-bold">{{ $product->public_view_count() }} page views</span>
                        </div>
                    </div>
                    <div class="col-sm-6 column-divider-sm">
                        <div class="pl-md-4">
                            <span>Since listed:</span>
                            <span class="text-dark font-weight-bold">471 page views</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End View Info -->
            <div class="row">

                <div class="col-sm-6">
                    <h4 class="mb-4">Description</h4>

                    <div class="c-product-description">
                        {!! $product->description !!}
                    </div>
                    <hr>
                    <div class="mt-3">
                        @isset($product->brand)
                        <x-default.products.single.product-brand-box :product="$product">
                        </x-default.products.single.product-brand-box>
                        @endisset
                    </div>
                    <hr>
                    <div class="mt-3">
                        <x-default.products.single.product-video :product="$product">
                        </x-default.products.single.product-video>
                    </div>



                </div>
                <div class="col-sm-6">
                    <h4 class="mb-0">{{ translate('Product Details') }}:
                        {{ $product->name }}</h4>

                    <x-default.products.single.product-specification-table :product="$product">
                    </x-default.products.single.product-specification-table>
                </div>
            </div>
            <!-- End Row -->
        </div>

        <div class="tab-pane fade mt-6" id="property-map" role="tabpanel" aria-labelledby="property-map-tab">
            <h4 class="mb-4">{{ translate('Reviews') }}</h4>

            <div class="row">
                <div class="col-md-6">
                    <!-- Accessibility List -->
                    <ul class="list-unstyled list-sm-article mb-0">
                        <li class="d-flex align-items-center">
                            <h6 class="mb-0">Location</h6>

                            <div class="d-flex ml-auto">
                                @for ($i = 0; $i < 5; $i++) @svg('heroicon-s-star', ["class"=> 'text-warning
                                    ev-icon__small'])
                                    @endfor
                            </div>
                        </li>

                        <li class="d-flex align-items-center">
                            <h6 class="mb-0">Area safety</h6>

                            <div class="d-flex ml-auto">
                                @for ($i = 0; $i < 5; $i++) @svg('heroicon-s-star', ["class"=> 'text-warning
                                    ev-icon__small'])
                                    @endfor
                            </div>
                        </li>

                        <li class="d-flex align-items-center">
                            <h6 class="mb-0">Close to schools</h6>

                            <div class="d-flex ml-auto">
                                @for ($i = 0; $i < 5; $i++) @svg('heroicon-s-star', ["class"=> 'text-warning
                                    ev-icon__small'])
                                    @endfor
                            </div>
                        </li>
                    </ul>
                    <!-- End Accessibility List -->
                </div>

                <div class="col-md-6">
                    <!-- Accessibility List -->
                    <ul class="list-unstyled list-sm-article mb-0">
                        <li class="d-flex align-items-center">
                            <h6 class="mb-0">Low cost</h6>

                            <div class="d-flex ml-auto">
                                @for ($i = 0; $i < 5; $i++) @svg('heroicon-s-star', ["class"=> 'text-warning
                                    ev-icon__small'])
                                    @endfor
                            </div>
                        </li>

                        <li class="d-flex align-items-center">
                            <h6 class="mb-0">Built around</h6>

                            <div class="d-flex ml-auto">
                                @for ($i = 0; $i < 5; $i++) @svg('heroicon-s-star', ["class"=> 'text-warning
                                    ev-icon__small'])
                                    @endfor
                            </div>
                        </li>

                        <li class="d-flex align-items-center">
                            <h6 class="mb-0">Value</h6>

                            <div class="d-flex ml-auto">
                                @for ($i = 0; $i < 5; $i++) @svg('heroicon-s-star', ["class"=> 'text-warning
                                    ev-icon__small'])
                                    @endfor
                            </div>
                        </li>
                    </ul>
                    <!-- End Accessibility List -->
                </div>
            </div>
            <!-- End Row -->
        </div>

        <div class="tab-pane fade mt-6" id="property-market-stats" role="tabpanel"
            aria-labelledby="property-market-stats-tab">
            <!-- Stats -->


            <!-- Stats -->
            <div class="mb-5">
                <x-default.calendar.calendly-widget></x-default.calendar.calendly-widget>
                <!-- End Row -->
            </div>
            <!-- End Stats -->
        </div>
    </div>
    <!-- End Tab Content -->

    <hr class="my-6">

    <h4 class="mb-4">{{ translate('Need an advice?') }}</h4>

    <div class="row">
        <div class="col-sm-6 col-md-5 mb-4 mb-sm-0">
            <!-- Media -->
            <div class="media">
                <span class="avatar avatar-lg avatar-soft-danger avatar-circle mr-3">
                    <span class="avatar-initials">{{ $product->shop->name }}</span>
                </span>

                <div class="media-body">
                    <h4 class="mb-1">
                        <a class="text-dark" href="{{ $product->shop->getPermalink() }}">{{ $product->shop->name }}</a>
                    </h4>


                    <span class="d-block font-size-1 mb-1">
                        <i class="fas fa-phone mr-1"></i>
                        {{-- TODO: Make this dynamic by vendor --}}
                        +1 416 346 8780
                    </span>
                    @if (get_setting('conversation_system') == 1)
                    <button class="mt-2 btn btn-xs btn-soft-primary mr-auto" onclick="show_chat_modal()">
                        {{ translate('Message Seller') }}
                    </button>
                    @endif
                </div>
            </div>
            <!-- End Media -->
        </div>

        <div class="col-sm-6 col-md-5">
            <!-- Media -->
            <div class="media">
                <span class="avatar avatar-lg avatar-soft-danger avatar-circle mr-3">
                    <span class="avatar-initials">KP</span>
                </span>

                <div class="media-body">
                    <a class="btn  btn-sm btn-primary" href="#">Register</a>
                </div>
            </div>
            <!-- End Media -->
        </div>
    </div>
    <!-- End Row -->
</div>
