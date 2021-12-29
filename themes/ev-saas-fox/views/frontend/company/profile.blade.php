@extends('frontend.layouts.'.$globalLayout)

@section('content')
<div class="container space-top-1 space-top-sm-2 space-bottom-2">
    <div class="row">
        <div id="stickyBlockStartPoint" class="col-md-5 col-lg-4 mb-7 mb-md-0">
            <div class="js-sticky-block card border p-4" data-hs-sticky-block-options="{
               &quot;parentSelector&quot;: &quot;#stickyBlockStartPoint&quot;,
               &quot;breakpoint&quot;: &quot;md&quot;,
               &quot;startPoint&quot;: &quot;#stickyBlockStartPoint&quot;,
               &quot;endPoint&quot;: &quot;#stickyBlockEndPoint&quot;,
               &quot;stickyOffsetTop&quot;: 12,
               &quot;stickyOffsetBottom&quot;: 12
             }">
                <div class="text-center">
                    <!-- User Content -->
                    <img class="img-fluid rounded-circle mx-auto" src="{{ $shop->get_company_logo() }}"
                        alt="{{ $shop->name }}" width="120" height="120">
                    <div>
                        <h1> {{ $shop->name }}</h1>
                    </div>

                    <span class="d-block text-body font-size-1 mt-3">{{ translate('Joined in') }} {{
                        $shop->created_at->format("Y") }}</span>
                    {{-- TODO: Change this to active_at --}}
                    <span class="d-block text-body font-size-1 mt-3">{{ translate('Last active') }} {{
                        $shop->created_at->diffForHumans() }}</span>

                    <div class="mt-3 d-flex align-items-center justify-content-center">
                        <a class="btn btn btn-outline-primary transition-3d-hover mr-3" href="#">
                            @svg('heroicon-o-chat', ['class' => 'd-block d-sm-inline-block mb-sm-0 mr-1', 'style' =>
                            'width: 16px;'])

                            {{ translate('Send Message') }}
                        </a>

                        <livewire:actions.wishlist-button :object="$shop" :action="translate('Follow')" template="wishlist-button-detailed" />

                    </div>
                    <!-- End User Content -->
                </div>

                <div class="media text-body font-size-1 mb-3">
                    <i class="fas fa-briefcase mt-1 mr-2"></i>
                    <div class="media-body">
                        {{ $shop->description }}
                    </div>
                </div>

                <p></p>

                <!-- Read More - Collapse -->
                <div class="collapse" id="collapseDescriptionSection">
                    {{-- TODO: add real description here --}}
                    <p>Over the course of her career she has developed a skill set in analyzing data and she hopes to
                        use her experience in teaching and data science to help other people learn the power of
                        programming the ability to analyze data, as well as present the data in clear and beautiful
                        visualizations.</p>
                </div>
                <!-- End Read More - Collapse -->

                <!-- Link -->
                <a class="link link-collapse small font-size-1 font-weight-bold" data-toggle="collapse"
                    href="#collapseDescriptionSection" role="button" aria-expanded="false"
                    aria-controls="collapseDescriptionSection">
                    <span class="link-collapse-default">Read more</span>
                    <span class="link-collapse-active">Read less</span>
                    <span class="link-icon ml-1">+</span>
                </a>
                <!-- End Link -->

                <div class="border-top pt-4 mt-4">
                    <div class="row">
                        <div class="col-6 col-md-12 col-lg-6 mb-4">
                            <!-- Icon Block -->
                            <div class="media">
                                <div class="d-flex">
                                    <span class="avatar avatar-xs mr-3">
                                        <img class="avatar-img"
                                            src="https://htmlstream.com/preview/front-v3.1.1/assets/svg/illustrations/review-rating-shield.svg"
                                            alt="Image Description">
                                    </span>
                                    <span class="text-body font-size-1 mt-1">533 Reviews</span>
                                </div>
                            </div>
                            <!-- End Icon Block -->
                        </div>

                        <div class="col-6 col-md-12 col-lg-6 mb-4">
                            <!-- Icon Block -->
                            <div class="d-flex">
                                <span class="avatar avatar-xs mr-3">
                                    <img class="avatar-img"
                                        src="https://htmlstream.com/preview/front-v3.1.1/assets/svg/illustrations/star.svg"
                                        alt="Image Description">
                                </span>
                                <span class="text-body font-size-1 mt-1">4.87 rating</span>
                            </div>
                            <!-- End Icon Block -->
                        </div>

                        <div class="col-6 col-md-12 col-lg-6 mb-4 col-6 col-md-12 mb-lg-0">
                            <!-- Icon Block -->
                            <div class="d-flex">
                                <span class="avatar avatar-xs mr-3">
                                    <img class="avatar-img"
                                        src="https://htmlstream.com/preview/front-v3.1.1/assets/svg/illustrations/medal.svg"
                                        alt="Image Description">
                                </span>
                                <span class="text-body font-size-1 mt-1">Top teacher</span>
                            </div>
                            <!-- End Icon Block -->
                        </div>

                        <div class="col-6 col-md-12 col-lg-6">
                            <!-- Icon Block -->
                            <div class="d-flex">
                                <span class="avatar avatar-xs mr-3">
                                    <img class="avatar-img"
                                        src="https://htmlstream.com/preview/front-v3.1.1/assets/svg/illustrations/add-file.svg"
                                        alt="Image Description">
                                </span>
                                <span class="text-body font-size-1 mt-1">29 courses</span>
                            </div>
                            <!-- End Icon Block -->
                        </div>
                    </div>
                </div>

                <div class="border-top pt-4 mt-4">
                    <h1 class="h4 mb-4">{{ translate('Connected accounts') }}</h1>

                    <div class="row">
                        <div class="col-6 col-md-12 col-lg-6 mb-4">
                            <!-- Social Profiles -->
                            <a class="media" href="#">
                                <div class="icon icon-xs icon-soft-secondary mr-3">
                                    <i class="fab fa-github"></i>
                                </div>
                                <div class="media-body">
                                    <span class="d-block font-size-1 font-weight-bold">Behance</span>
                                    <small class="d-block text-body">1.2k followers</small>
                                </div>
                            </a>
                            <!-- End Social Profiles -->
                        </div>

                        <div class="col-6 col-md-12 col-lg-6 mb-4">
                            <!-- Social Profiles -->
                            <a class="media" href="#">
                                <div class="icon icon-xs icon-soft-secondary mr-3">
                                    <i class="fab fa-slack"></i>
                                </div>
                                <div class="media-body">
                                    <span class="d-block font-size-1 font-weight-bold">Slack</span>
                                    <small class="d-block text-body">4.5k followers</small>
                                </div>
                            </a>
                            <!-- End Social Profiles -->
                        </div>

                        <div class="col-6 col-md-12 col-lg-6 mb-0 mb-md-4 mb-lg-0">
                            <!-- Social Profiles -->
                            <a class="media" href="#">
                                <div class="icon icon-xs icon-soft-secondary mr-3">
                                    <i class="fab fa-twitter"></i>
                                </div>
                                <div class="media-body">
                                    <span class="d-block font-size-1 font-weight-bold">Twitter</span>
                                    <small class="d-block text-body">2.7k followers</small>
                                </div>
                            </a>
                            <!-- End Social Profiles -->
                        </div>

                        <div class="col-6 col-md-12 col-lg-6">
                            <!-- Social Profiles -->
                            <a class="media" href="#">
                                <div class="icon icon-xs icon-soft-secondary mr-3">
                                    <i class="fab fa-facebook-f"></i>
                                </div>
                                <div class="media-body">
                                    <span class="d-block font-size-1 font-weight-bold">Facebook</span>
                                    <small class="d-block text-body">3k followers</small>
                                </div>
                            </a>
                            <!-- End Social Profiles -->
                        </div>
                    </div>
                </div>


            </div>
        </div>

        <div class="col-md-7 col-lg-8 card p-0">
            <div class="card-body p-3 p-sm-3">

                <div class="js-nav-scroller hs-nav-scroller-horizontal">
                    <span class="hs-nav-scroller-arrow-prev" style="display: none;">
                        <a class="hs-nav-scroller-arrow-link" href="javascript:;">
                            <i class="bi-chevron-left"></i>
                        </a>
                    </span>

                    <span class="hs-nav-scroller-arrow-next" style="display: flex;">
                        <a class="hs-nav-scroller-arrow-link" href="javascript:;">
                            <i class="bi-chevron-right"></i>
                        </a>
                    </span>

                    <!-- Nav -->
                    <ul class="nav nav-segment nav-fill mb-7" id="propertyOverviewNavTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" href="#propertyOverviewNavOne" id="propertyOverviewNavOne-tab"
                                data-bs-toggle="tab" data-bs-target="#propertyOverviewNavOne" role="tab"
                                aria-controls="propertyOverviewNavOne" aria-selected="true" style="min-width: 7rem;">
                                {{ translate('Products') }}
                            </a>
                        </li>

                        <li class="nav-item" role="presentation">
                            <a class="nav-link" href="#propertyOverviewNavTwo" id="propertyOverviewNavTwo-tab"
                                data-bs-toggle="tab" data-bs-target="#propertyOverviewNavTwo" role="tab"
                                aria-controls="propertyOverviewNavTwo" aria-selected="false" style="min-width: 7rem;">
                                {{ translate('Activity') }}

                            </a>
                        </li>

                        <li class="nav-item" role="presentation">
                            <a class="nav-link" href="#propertyOverviewNavThree" id="propertyOverviewNavThree-tab"
                                data-bs-toggle="tab" data-bs-target="#propertyOverviewNavThree" role="tab"
                                aria-controls="propertyOverviewNavThree" aria-selected="false" style="min-width: 7rem;">
                                {{ translate('Reviews') }}
                            </a>
                        </li>

                    </ul>
                    <!-- End Nav -->
                </div>

                <div class="tab-content">
                    <div class="tab-pane fade active show" id="propertyOverviewNavOne" role="tabpanel"
                        aria-labelledby="propertyOverviewNavOne-tab">
                        <div class="mb-4">
                            <h3 class="mb-4">{{ $shop->name }} {{ translate('Products') }}</h3>

                            <!-- Course -->
                            <div class="row pt-0 mt-0 ev-horizontal-slider d-flex flex-nowrap pb-5"
                                style="overflow-x: auto;">
                                @foreach($shop->products as $product)
                                <div class="col-10 col-sm-5">
                                    <x-default.products.cards.product-card :product="$product">
                                    </x-default.products.cards.product-card>
                                </div>

                                @endforeach

                            </div>
                            <!-- End Course -->

                            <div class="text-right font-size-1 mt-6">
                                <a class="font-weight-bold" href="courses-listing.html">See all Courses <i
                                        class="fas fa-angle-right fa-sm ml-1"></i></a>
                            </div>
                        </div>


                        <!-- Collapse Link -->

                        <!-- End Collapse Link -->


                        <!-- End Row -->
                    </div>

                    <div class="tab-pane fade" id="propertyOverviewNavTwo" role="tabpanel"
                        aria-labelledby="propertyOverviewNavTwo-tab">
                    </div>

                    <div class="tab-pane fade" id="propertyOverviewNavThree" role="tabpanel"
                        aria-labelledby="propertyOverviewNavThree-tab">
                        <!-- Gmap -->

                    </div>

                    <div class="tab-pane fade" id="propertyOverviewNavFour" role="tabpanel"
                        aria-labelledby="propertyOverviewNavFour-tab">

                    </div>
                </div>


                <!-- End Courses -->
                <!-- Sticky Block End Point -->
                <div id="stickyBlockEndPoint"></div>
            </div>
        </div>
    </div>
</div>

@endsection
