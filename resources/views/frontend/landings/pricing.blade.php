@extends('frontend.layouts.app')

@section('content')
    <div class="">
        <!-- Hero Section -->
        <div class="bg-img-hero" style="background-image: url(./assets/svg/components/abstract-shapes-12.svg);">
            <div class="container space-top-3 space-top-lg-2 space-bottom-2 space-bottom-lg-4">
                <div class="w-md-80 w-lg-60 text-center mx-auto mb-9">
                    <h1>B2BWood Club Pricing</h1>
                </div>

                <!-- Toggle Switch -->
                <div class="d-flex justify-content-center align-items-center mb-9 mb-lg-n10">
                    <span class="font-size-1 text-muted">Monthly</span>
                    <label class="toggle-switch mx-2" for="customSwitch">
                        <input type="checkbox" class="js-toggle-switch toggle-switch-input" id="customSwitch" checked="" data-hs-toggle-switch-options="{
                       &quot;targetSelector&quot;: &quot;#pricingCount1, #pricingCount2, #pricingCount3&quot;
                     }">
                        <span class="toggle-switch-label">
                <span class="toggle-switch-indicator"></span>
              </span>
                    </label>
                    <div class="position-relative">
                        <span class="font-size-1 text-muted">Annual</span>

                        <!-- Arrow -->
                        <figure class="position-absolute top-0 text-nowrap mt-n5 ml-3 ml-md-5">
                            <svg class="d-block position-absolute mt-n2 ml-n4" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 99.3 57" width="48">
                                <path fill="none" stroke="#bdc5d1" stroke-width="4" stroke-linecap="round" stroke-miterlimit="10" d="M2,39.5l7.7,14.8c0.4,0.7,1.3,0.9,2,0.4L27.9,42"></path>
                                <path fill="none" stroke="#bdc5d1" stroke-width="4" stroke-linecap="round" stroke-miterlimit="10" d="M11,54.3c0,0,10.3-65.2,86.3-50"></path>
                            </svg>
                            <span class="badge badge-primary badge-pill py-sm-2 px-sm-3">Save up to 10%</span>
                        </figure>
                        <!-- End Arrow -->
                    </div>
                </div>
                <!-- End Toggle Switch -->
            </div>
        </div>
        <!-- End Hero Section -->

        <!-- Pricing Section -->
        <div class="container mt-n10">
            <div class="w-lg-80 mx-lg-auto position-relative">
                <div class="row position-relative z-index-2 mx-n2 mb-5">
                    <div class="col-sm-6 col-md-4 px-2 mb-3">
                        <!-- Pricing -->
                        <div class="card h-100">
                            <!-- Header -->
                            <div class="card-header text-center">
                                <span class="d-block h3">Free</span>
                                <span class="d-block mb-2">
                    <span class="text-dark align-top">$</span>
                    <span class="font-size-4 text-dark font-weight-bold mr-n2">
                      <span id="pricingCount1" data-hs-toggle-switch-item-options="{
                               &quot;min&quot;: 0,
                               &quot;max&quot;: 0
                             }">Free!    </span>
                    </span>
                    <span class="font-size-1">0/ mon</span>
                  </span>
                            </div>
                            <!-- End Header -->

                            <!-- Body -->
                            <div class="card-body">
                                <div class="media font-size-1 text-body mb-3">
                                    <i class="fas fa-check-circle text-success mt-1 mr-2"></i>
                                    <div class="media-body">
                                        1 User
                                    </div>
                                </div>
                                <div class="media font-size-1 text-body mb-3">
                                    <i class="fas fa-check-circle text-success mt-1 mr-2"></i>
                                    <div class="media-body">
                                        Front plan features
                                    </div>
                                </div>
                                <div class="media font-size-1 text-body mb-3">
                                    <i class="fas fa-check-circle text-success mt-1 mr-2"></i>
                                    <div class="media-body">
                                        1 app
                                    </div>
                                </div>
                                <div class="media font-size-1 text-body">
                                    <i class="fas fa-check-circle text-success mt-1 mr-2"></i>
                                    <div class="media-body">
                                        Integrations
                                    </div>
                                </div>
                            </div>
                            <!-- End Body -->

                            <div class="card-footer border-0">
                                <button type="button" class="btn btn-soft-primary btn-block transition-3d-hover">Get Started</button>
                            </div>
                        </div>
                        <!-- End Pricing -->
                    </div>

                    <div class="col-sm-6 col-md-4 px-2 mb-3">
                        <!-- Pricing -->
                        <div class="card bg-primary text-white h-100 shadow-primary-lg">
                            <!-- Header -->
                            <div class="card-header border-0 bg-primary text-white text-center">
                                <span class="d-block h3 text-white">Pro</span>
                                <span class="d-block mb-2">
                    <span class="text-white align-top">$</span>
                    <span class="font-size-4 text-white font-weight-bold mr-n2">
                      <span id="pricingCount2" data-hs-toggle-switch-item-options="{
                               &quot;min&quot;: 64,
                               &quot;max&quot;: 54
                             }">54</span>
                    </span>
                    <span class="font-size-1">/ mon</span>
                  </span>
                            </div>
                            <!-- End Header -->

                            <div class="border-top opacity-xs"></div>

                            <!-- Body -->
                            <div class="card-body">
                                <div class="media font-size-1 mb-3">
                                    <i class="fas fa-check-circle mt-1 mr-2"></i>
                                    <div class="media-body">
                                        3 Users
                                    </div>
                                </div>
                                <div class="media font-size-1 mb-3">
                                    <i class="fas fa-check-circle mt-1 mr-2"></i>
                                    <div class="media-body">
                                        Front plan features
                                    </div>
                                </div>
                                <div class="media font-size-1 mb-3">
                                    <i class="fas fa-check-circle mt-1 mr-2"></i>
                                    <div class="media-body">
                                        3 apps
                                    </div>
                                </div>
                                <div class="media font-size-1 mb-3">
                                    <i class="fas fa-check-circle mt-1 mr-2"></i>
                                    <div class="media-body">
                                        Integrations
                                    </div>
                                </div>
                                <div class="media font-size-1">
                                    <i class="fas fa-check-circle mt-1 mr-2"></i>
                                    <div class="media-body">
                                        Product Support
                                    </div>
                                </div>
                            </div>
                            <!-- End Body -->

                            <div class="card-footer border-0 bg-primary text-white">
                                <button type="button" class="btn btn-light text-primary btn-block transition-3d-hover">Get Started</button>
                            </div>
                        </div>
                        <!-- End Pricing -->
                    </div>

                    <div class="col-sm-6 col-md-4 px-2 mb-3">
                        <!-- Pricing -->
                        <div class="card h-100">
                            <!-- Header -->
                            <div class="card-header text-center">
                                <span class="d-block h3">Enterprise</span>
                                <span class="d-block mb-2">
                    <span class="text-dark align-top">$</span>
                    <span class="font-size-4 text-dark font-weight-bold mr-n2">
                      <span id="pricingCount3" data-hs-toggle-switch-item-options="{
                               &quot;min&quot;: 89,
                               &quot;max&quot;: 79
                             }">79</span>
                    </span>
                    <span class="font-size-1">/ mon</span>
                  </span>
                            </div>
                            <!-- End Header -->

                            <!-- Body -->
                            <div class="card-body">
                                <div class="media font-size-1 text-body mb-3">
                                    <i class="fas fa-check-circle text-success mt-1 mr-2"></i>
                                    <div class="media-body">
                                        5 Users
                                    </div>
                                </div>
                                <div class="media font-size-1 text-body mb-3">
                                    <i class="fas fa-check-circle text-success mt-1 mr-2"></i>
                                    <div class="media-body">
                                        Front plan features
                                    </div>
                                </div>
                                <div class="media font-size-1 text-body mb-3">
                                    <i class="fas fa-check-circle text-success mt-1 mr-2"></i>
                                    <div class="media-body">
                                        All apps
                                    </div>
                                </div>
                                <div class="media font-size-1 text-body mb-3">
                                    <i class="fas fa-check-circle text-success mt-1 mr-2"></i>
                                    <div class="media-body">
                                        Integrations
                                    </div>
                                </div>
                                <div class="media font-size-1 text-body">
                                    <i class="fas fa-check-circle text-success mt-1 mr-2"></i>
                                    <div class="media-body">
                                        Product Support
                                    </div>
                                </div>
                            </div>
                            <!-- End Body -->

                            <div class="card-footer border-0">
                                <button type="button" class="btn btn-soft-primary btn-block transition-3d-hover">Get Started</button>
                            </div>
                        </div>
                        <!-- End Pricing -->
                    </div>
                </div>

                <!-- Info -->
                <div class="position-relative z-index-2 text-center">
                    <div class="d-inline-block font-size-1 border bg-white text-center rounded-pill py-3 px-4">
                        Prefer to start with the Trial version? <a class="d-block d-sm-inline-block font-weight-bold ml-sm-3" href="#fullPricingSection">Go here <span class="fas fa-angle-right ml-1"></span></a>
                    </div>
                </div>
                <!-- End Info -->

                <!-- SVG Elements -->
                <figure class="max-w-11rem w-100 position-absolute top-0 right-0">
                    <div class="mt-n11 mr-n11">
                        <img class="img-fluid" src="./assets/svg/components/dots-1.svg" alt="Image Description">
                    </div>
                </figure>
                <figure class="max-w-13rem w-100 position-absolute bottom-0 left-0">
                    <div class="mb-3 ml-n9">
                        <img class="img-fluid" src="https://htmlstream.com/front/assets/svg/components/abstract-shapes-10.svg" alt="Image Description">
                    </div>
                </figure>
                <!-- End SVG Elements -->
            </div>
        </div>
        <!-- End Pricing Section -->
    </div>
    <div class="mt-10"></div>
@endsection
