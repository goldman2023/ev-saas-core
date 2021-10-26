<div class="mb-9 mb-lg-0  p-3 ">
    <div class="row justify-content-lg-between mb-7">
        <div class="col-12 col-sm-7 mb-5 mb-sm-0">
            <h1 class="h1 mb-0">{{ $product->getTranslation('name') }}</h1>
            <span class="d-block text-dark mb-3">
                <div class="d-flex ml-auto">
                    @for ($i = 0; $i < 5; $i++)
                        @svg('heroicon-s-star', ["class" => 'text-warning ev-icon__xs'])
                    @endfor
                </div>
            </span>

            <ul class="list-inline list-separator font-size-1 text-body d-flex">
                <li class="list-inline-item align-items-center d-flex">
                    @svg('heroicon-s-eye', ["class" => 'ev-icon__xs mr-2'])
                    {{-- TODO: make this dynamic --}}
                    3 Views
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
                    @if (home_base_price($product->id) != home_discounted_base_price($product->id))
                        <del class="h3 fw-600 opacity-50 mr-1">
                            {{ home_base_price($product->id) }}
                        </del>
                    @endif
                    <span class="h2 fw-700 text-primary">
                        {{ home_discounted_base_price($product->id) }}</span>
                    </span>
                </h2>
                <span class="d-block text-dark mb-3">Est. Shipping 76€</span>
                <a href="#">Register and get shipping price</a>
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

                    {{ translate('Questions & Answers') }}
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
                            <span class="text-dark font-weight-bold">920 page views</span>
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
                        {{ $product->getTranslation('description') }}

                    </div>


                </div>
                <div class="col-sm-6">
                    <h4 class="mb-0">{{ translate('Product Details') }}:
                        {{ $product->getTranslation('name') }}</h4>

                    <x-default.products.single.product-specification-table :product="$product">
                    </x-default.products.single.product-specification-table>
                </div>
            </div>


            <!-- End Row -->

            <hr class="my-6">

            <h4 class="mb-1">Estimated running costs</h4>
            <p class="small">Based on available 3rd party data</p>

            <div class="row">
                <div class="col-md-6">
                    <span class="h1">£810</span>
                    <p>Approximate costs per month</p>
                </div>

                <div class="col-md-6">
                    <dl class="row">
                        <dt class="col-sm-6 text-dark">
                            <i class="fas fa-hand-holding-usd nav-icon"></i> Mortgage
                        </dt>
                        <dd class="col-sm-6 text-sm-right">£700 p/m</dd>

                        <dt class="col-sm-6 text-dark">
                            <i class="fas fa-burn nav-icon"></i> Energy
                        </dt>
                        <dd class="col-sm-6 text-sm-right">from £72 p/m</dd>

                        <dt class="col-sm-6 text-dark">
                            <i class="fas fa-tint nav-icon"></i> Water
                        </dt>
                        <dd class="col-sm-6 text-sm-right">
                            from £38 p/m
                        </dd>

                        <dt class="col-sm-6 text-dark">
                            <i class="fas fa-shield-alt nav-icon"></i> Home insurance
                        </dt>
                        <dd class="col-sm-6 text-sm-right">not known</dd>
                    </dl>
                    <!-- End Row -->
                </div>
            </div>
            <!-- End Row -->
        </div>

        <div class="tab-pane fade mt-6" id="property-floorplan" role="tabpanel"
            aria-labelledby="property-floorplan-tab">
            <!-- Gallery -->
            <a class="js-fancybox media-viewer" href="javascript:;" data-hs-fancybox-options="{
             &quot;src&quot;: &quot;../assets/img/others/img1.png&quot;,
             &quot;fancybox&quot;: &quot;fancyboxGalleryFloorPlan&quot;,
             &quot;caption&quot;: &quot;Front in frames - image #01&quot;,
             &quot;speed&quot;: 700,
             &quot;loop&quot;: true
           }">
                <img class="img-fluid" src="../assets/img/others/img1.png" alt="Image Description">
            </a>
            <!-- End Gallery -->

            <small class="form-text">Image source from <a href="https://floorplanner.com/"
                    target="_blank">floorplanner.com</a></small>
        </div>

        <div class="tab-pane fade mt-6" id="property-map" role="tabpanel" aria-labelledby="property-map-tab">
            <h4 class="mb-4">Accessibility</h4>

            <div class="row">
                <div class="col-md-6">
                    <!-- Accessibility List -->
                    <ul class="list-unstyled list-sm-article mb-0">
                        <li class="d-flex align-items-center">
                            <h6 class="mb-0">Location</h6>

                            <div class="d-flex ml-auto">
                                @for ($i = 0; $i < 5; $i++)
                                    @svg('heroicon-s-star', ["class" => 'text-warning ev-icon__small'])
                                @endfor
                            </div>
                        </li>

                        <li class="d-flex align-items-center">
                            <h6 class="mb-0">Area safety</h6>

                            <div class="d-flex ml-auto">
                                @for ($i = 0; $i < 5; $i++)
                                    @svg('heroicon-s-star', ["class" => 'text-warning ev-icon__small'])
                                @endfor
                            </div>
                        </li>

                        <li class="d-flex align-items-center">
                            <h6 class="mb-0">Close to schools</h6>

                            <div class="d-flex ml-auto">
                                @for ($i = 0; $i < 5; $i++)
                                    @svg('heroicon-s-star', ["class" => 'text-warning ev-icon__small'])
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
                                @for ($i = 0; $i < 5; $i++)
                                    @svg('heroicon-s-star', ["class" => 'text-warning ev-icon__small'])
                                @endfor
                            </div>
                        </li>

                        <li class="d-flex align-items-center">
                            <h6 class="mb-0">Built around</h6>

                            <div class="d-flex ml-auto">
                                @for ($i = 0; $i < 5; $i++)
                                    @svg('heroicon-s-star', ["class" => 'text-warning ev-icon__small'])
                                @endfor
                            </div>
                        </li>

                        <li class="d-flex align-items-center">
                            <h6 class="mb-0">Value</h6>

                            <div class="d-flex ml-auto">
                                @for ($i = 0; $i < 5; $i++)
                                    @svg('heroicon-s-star', ["class" => 'text-warning ev-icon__small'])
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
            <div class="mb-5">
                <h5>Sale activity</h5>
                <p>Average estimated value for a flat in HG2:</p>

                <h3 class="text-primary mb-0">£271,401</h3>
                <i class="fas fa-angle-down text-danger"></i>
                <span>£7,710 (-2.762%)</span>
                <small class="text-muted ml-1">Over the last 12 months</small>
            </div>
            <!-- End Stats -->

            <!-- Stats -->
            <div class="mb-5">
                <h5>In the last 12 months</h5>

                <div class="row justify-content-sm-between">
                    <div class="col-sm-6">
                        <span class="d-block">Average sale price</span>
                        <h3 class="text-primary mb-0">£267,606</h3>
                    </div>

                    <div class="col-sm-6">
                        <span class="d-block">Properties sold</span>
                        <h3 class="text-primary mb-0">51</h3>
                    </div>
                </div>
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
                    <span class="avatar-initials">MT</span>
                </span>

                <div class="media-body">
                    <h4 class="mb-1">
                        <a class="text-dark" href="#">MTBaltic</a>
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
                    <h4 class="mb-1">
                        <a class="text-dark" href="#">GunOB</a>
                    </h4>


                    <a class="btn  btn-sm btn-primary" href="#">Register</a>
                </div>
            </div>
            <!-- End Media -->
        </div>
    </div>
    <!-- End Row -->
</div>
