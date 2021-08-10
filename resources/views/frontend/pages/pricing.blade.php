@extends('frontend.layouts.app')

@section('content')
@php 
    $plans = App\Models\SellerPackage::all();
@endphp
    <div class="overflow-hidden space-bottom-2">
        <!-- Hero Section -->
        <div class="bg-img-hero"
            style="">
            <div class="container space-top-2 space-bottom-2 space-bottom-lg-2">
                <div class="w-md-80 w-lg-60 text-center mx-auto mb-9">
                    <h1>{{ translate('B2BWood Membership options') }}</h1>
                </div>
            </div>
        </div>
        <!-- End Hero Section -->

        <!-- Pricing Section -->
        <div class="container mt-n10" >
            <div class="w-lg-80 mx-lg-auto position-relative">
                <div class="row position-relative z-index-2 mx-n2 mb-5">
                    <div class="col-sm-6 col-md-4 px-2 mb-3">
                        <!-- Pricing -->
                        <div class="card h-100">
                            <!-- Header -->
                            <div class="card-header text-center">
                                <span class="d-block h3">{{ translate('Prospect') }}</span>
                                <span class="d-block mb-2">
                                    <span class="text-dark align-top">$</span>
                                    <span class="font-size-4 text-dark font-weight-bold">
                                        <span id="pricingCount1Example2" data-hs-toggle-switch-item-options='{
                                                                                   "min": 42,
                                                                                   "max": 32
                                                                                 }'>0</span>
                                    </span>
                                    <span class="font-size-1">{{ translate('Free') }}</span>
                                </span>
                            </div>
                            <!-- End Header -->

                            <!-- Body -->
                            <div class="card-body">
                                <div class="media font-size-1 text-body mb-3">
                                    <i class="fas fa-check-circle text-success mt-1 mr-2"></i>
                                    <div class="media-body">
                                        <i class="las la-check text-success mr-2"></i>

                                        {{ translate('Digital Pasport') }}
                                    </div>
                                </div>
                                <div class="media font-size-1 text-body mb-3">
                                    <i class="fas fa-check-circle text-success mt-1 mr-2"></i>
                                    <div class="media-body">
                                        <i class="las la-times text-danger mr-2"></i>

                                        {{ translate('Verification') }}

                                    </div>
                                </div>
                                <div class="media font-size-1 text-body mb-3">
                                    <i class="fas fa-check-circle text-success mt-1 mr-2"></i>
                                    <div class="media-body">
                                        <i class="las la-times text-danger mr-2"></i>

                                        {{ translate('Press releases') }}

                                    </div>
                                </div>
                                <div class="media font-size-1 text-body mb-3">
                                    <i class="fas fa-check-circle text-success mt-1 mr-2"></i>
                                    <div class="media-body">
                                        <i class="las la-times text-danger mr-2"></i>

                                        {{ translate('Trade options') }}
                                    </div>
                                </div>

                                <div class="media font-size-1 text-body mb-3">
                                    <i class="fas fa-check-circle text-success mt-1 mr-2"></i>
                                    <div class="media-body">
                                        <i class="las la-times text-danger mr-2"></i>

                                        {{ translate('Content Management') }}
                                    </div>
                                </div>

                                <div class="media font-size-1 text-body">
                                    <i class="fas fa-check-circle text-success mt-1 mr-2"></i>
                                    <div class="media-body">
                                        <i class="las la-angle-down text-danger mr-2"></i>
                                        {{ translate('Visibility') }}
                                    </div>
                                </div>
                            </div>
                            <!-- End Body -->

                            <div class="card-footer border-0">
                                <a href="{{ route('shops.create') }}" type="button"
                                    class="btn btn-soft-secondary btn-block transition-3d-hover">
                                    {{ translate('Become a member') }}
                                </a>
                            </div>
                        </div>
                        <!-- End Pricing -->
                    </div>

                    <div class="col-sm-6 col-md-4 px-2 mb-3">
                        <!-- Pricing -->
                        <div class="card bg-primary text-white h-100 shadow-primary-lg">
                            <!-- Header -->
                            <div class="card-header border-0 bg-primary text-white text-center">
                                <span class="d-block h3 text-white">
                                    {{ translate('Basic Membership') }}
                                </span>
                                <div>
                                    <div>
                                        <span class="d-block mb-2">
                                            <span class="text-success align-top">$</span>
                                            <span class="display-4 text-success font-weight-bold">
                                                <span id="pricingCount2Example2" data-hs-toggle-switch-item-options='{
                                                                               "min": 64,
                                                                               "max": 54
                                                                             }'>99</span>
                                            </span>
                                            <span class="font-size-1 text-success">{{ translate('/ year') }}</span>
                                        </span>
                                    </div>
                                    <div>
                                        <del class="text-danger">
                                            <span class="d-block mb-2">
                                                <span class="text-danger align-top">$</span>
                                                <span class="font-size-4 text-danger font-weight-bold">
                                                    <span id="pricingCount2Example2" data-hs-toggle-switch-item-options='{
                                                                                   "min": 64,
                                                                                   "max": 54
                                                                                 }'>199</span>
                                                </span>
                                                <span class="font-size-1">{{ translate('/ year') }}</span>
                                            </span>
                                        </del>
                                    </div>
                                </div>
                            </div>
                            <!-- End Header -->

                            <div class="border-top opacity-xs"></div>

                            <!-- Body -->
                            <div class="card-body">
                                <div class="media font-size-1 text-white mb-3">
                                    <i class="fas fa-check-circle text-success mt-1 mr-2"></i>
                                    <div class="media-body">
                                        <i class="las la-check text-success mr-2"></i>

                                        {{ translate('Digital Pasport') }}
                                    </div>
                                </div>
                                <div class="media font-size-1 text-white mb-3">
                                    <i class="fas fa-check-circle text-success mt-1 mr-2"></i>
                                    <div class="media-body">
                                        <i class="las la-check text-success mr-2"></i>

                                        {{ translate('Verification') }}

                                    </div>
                                </div>
                                <div class="media font-size-1 text-white mb-3">
                                    <i class="fas fa-check-circle text-success mt-1 mr-2"></i>
                                    <div class="media-body">
                                        <i class="las la-check text-success mr-2"></i>


                                        {{ translate('Press releases') }}

                                    </div>
                                </div>
                                <div class="media font-size-1 text-body mb-3">
                                    <i class="fas fa-check-circle text-success mt-1 mr-2"></i>
                                    <div class="media-body">
                                        <i class="las la-times text-danger mr-2"></i>

                                        {{ translate('Trade options') }}
                                    </div>
                                </div>

                                <div class="media font-size-1 text-body mb-3">
                                    <i class="fas fa-check-circle text-success mt-1 mr-2"></i>
                                    <div class="media-body">
                                        <i class="las la-times text-danger mr-2"></i>

                                        {{ translate('Content Management') }}
                                    </div>
                                </div>

                                <div class="media font-size-1 text-body">
                                    <i class="fas fa-check-circle text-success mt-1 mr-2"></i>
                                    <div class="media-body">
                                        <i class="las la-angle-up text-success mr-2"></i>
                                        {{ translate('Visibility') }}
                                    </div>
                                </div>
                            </div>
                            <!-- End Body -->

                            <div class="card-footer border-0 bg-primary text-white">
                                <a href="{{ route('shops.create') }}" type="button"
                                    class="btn btn-success text-white btn-block transition-3d-hover">
                                    {{ translate('Join The Club') }}
                                </a>
                            </div>
                        </div>
                        <!-- End Pricing -->
                    </div>

                    <div class="col-sm-6 col-md-4 px-2 mb-3">
                        <!-- Pricing -->
                        <div class="card h-100">
                            <!-- Header -->
                            <div class="card-header text-center">
                                <span class="d-block h3">{{ translate('Prime Membership') }}</span>
                                <span class="d-block mb-2">

                                    {{-- Pricing numbers --}}
                                    <div>
                                        <span class="text-primary align-top">$</span>
                                        <span class="display-4 text-primary font-weight-bold">
                                            <span id="pricingCount3Example2" data-hs-toggle-switch-item-options='{
                                                                                   "min": 89,
                                                                                   "max": 79
                                                                                 }'>249</span>
                                        </span>
                                        <span class="font-size-1">{{ translate('/ year') }}</span>
                                </span>
                            </div>

                            <div>
                                <del class="text-danger">
                                    <span class="text-danger align-top">$</span>
                                    <span class="font-size-4 text-danger font-weight-bold">
                                        <span id="pricingCount3Example2" data-hs-toggle-switch-item-options='{
                                                                                   "min": 89,
                                                                                   "max": 79
                                                                                 }'>499</span>
                                    </span>
                                    <span class="font-size-1">{{ translate('/ year') }}</span>
                                    </span>
                                </del>
                            </div>
                        </div>
                        <!-- End Header -->

                        <!-- Body -->
                        <div class="card-body">
                            <div class="media font-size-1 text-body mb-3">
                                <i class="fas fa-check-circle text-success mt-1 mr-2"></i>
                                <div class="media-body">
                                    <i class="las la-check text-success mr-2"></i>

                                    {{ translate('Digital Pasport') }}
                                </div>
                            </div>
                            <div class="media font-size-1 text-body mb-3">
                                <i class="fas fa-check-circle text-success mt-1 mr-2"></i>
                                <div class="media-body">
                                    <i class="las la-check text-success mr-2"></i>

                                    {{ translate('Verification') }}

                                </div>
                            </div>
                            <div class="media font-size-1 text-body mb-3">
                                <i class="fas fa-check-circle text-success mt-1 mr-2"></i>
                                <div class="media-body">
                                    <i class="las la-check text-success mr-2"></i>


                                    {{ translate('Press releases') }}

                                </div>
                            </div>
                            <div class="media font-size-1 text-body mb-3">
                                <i class="fas fa-check-circle text-success mt-1 mr-2"></i>
                                <div class="media-body">
                                    <i class="las la-check text-success mr-2"></i>


                                    {{ translate('Trade options') }}
                                </div>
                            </div>

                            <div class="media font-size-1 text-body mb-3">
                                <i class="fas fa-check-circle text-body mt-1 mr-2"></i>
                                <div class="media-body">
                                    <i class="las la-check text-success mr-2"></i>


                                    {{ translate('Content Management') }}
                                </div>
                            </div>

                            <div class="media font-size-1 text-body">
                                <i class="fas fa-check-circle text-body mt-1 mr-2"></i>
                                <div class="media-body">
                                    <i class="las la-angle-double-up text-primary"></i>
                                    {{ translate('Visibility') }}
                                </div>
                            </div>
                        </div>
                        <!-- End Body -->

                        <div class="card-footer border-0 bg-white text-white">
                            <a href="{{ route('shops.create') }}" type="button"
                                class="btn btn-soft-secondary btn-block transition-3d-hover">
                                {{ translate('Join The Club') }}
                            </a>
                        </div>
                    </div>
                    {{-- Pricing numbers End --}}
                    <!-- End Pricing -->
                </div>
            </div>

            <!-- Info -->
            <div class="position-relative z-index-2 text-center d-none">
                <div class="d-inline-block font-size-1 border bg-white text-center rounded-pill py-3 px-4">
                    Prefer to start with the Trial version? <a class="d-block d-sm-inline-block font-weight-bold ml-sm-3"
                        href="#">Go here <span class="fas fa-angle-right ml-1"></span></a>
                </div>
            </div>
            <!-- End Info -->

            <!-- SVG Elements -->
            <figure class="max-w-11rem w-100 position-absolute top-0 right-0">
                <div class="mt-n11 mr-n11">
                </div>
            </figure>
            <figure class="max-w-13rem w-100 position-absolute bottom-0 left-0">
                <div class="mb-3 ml-n9">
                </div>
            </figure>
            <!-- End SVG Elements -->
        </div>
    </div>
    <!-- End Pricing Section -->
    </div>


    @php
    $button_text = 'Try it out';
    $image_source = 'assets/img/img1.jpg';
    $heading = 'Register to B2BWood';
    $body = "Building brands people can't live without is how our clients grow.";
    @endphp
    <x-promo-banner :heading="$heading" :body="$body" :buttonText="$button_text" :imageSource="$image_source">
    </x-promo-banner>
    <!-- End Team Section -->
@endsection

@section('script')

@endsection
