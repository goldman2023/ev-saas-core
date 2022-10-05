@extends('frontend.layouts.app')

@section('content')

<div class="container px-3">
    <div class="row">
        <!-- Cover -->
        <div
            class="col-lg-6 offset-1 d-flex justify-content-center align-items-start pt-6 min-vh-lg-100 position-relative bg-light px-0 order-2">

            <div class="pl-3">
                <div class="mb-3">
                    <h1 class="h1 text-center text-lg-left">
                        {{ translate('Become a seller') }}
                    </h1>
                </div>

                <!-- List Checked -->
                <ul class="list-checked list-checked-lg list-checked-primary list-unstyled-py-4"
                    style="max-width: 70%;">
                    <li class="list-checked-item mb-3">
                        <span class="d-block  h5  font-weight-bold mb-1">
                            {{ translate('White-Label E-Commerce Store') }}
                        </span>

                        {{ translate('Run your own E-Commerce store easily') }}

                    </li>

                    <li class="list-checked-item mb-3">
                        <span class="d-block font-weight-bold h5 mb-1">{{ translate('Powerful stock management')
                            }}</span>
                        {{ translate('Move your inventory to the cloud. Import your excel files or transfer data from
                        3rd party services') }}
                    </li>

                    <li class="list-checked-item mb-3">
                        <span class="d-block  h5 font-weight-bold mb-1">
                            {{ translate('Easy billing and subcsriptions management') }}
                        </span>

                        {{ translate('Sell your products and sell your club memberships or gun range passes with 1 easy
                        solution') }}

                    </li>

                    <li class="list-checked-item mb-3">
                        <span class="d-block  h5  font-weight-bold mb-1">
                            {{ translate('International community and exclusive deals') }}
                        </span>
                        {{ translate('Join the international comminity of gun vendors, wholesalers and collectors and
                        find new oportunities') }}
                    </li>
                </ul>

                <div class="text-center mb-5">
                    {{-- TODO: make this dynamic --}}
                    <div class="row">
                        <div class="col-12 text-left">
                            <h4 class="h3 mb-3"> {{ translate('Open your shop like this next week! ') }}</h4>
                        </div>

                        <div class="col-5">
                            <img class="img-fluid" src="{{ asset('assets/img/promo/white-label-mobile-shop.png') }}"
                                alt="Company Profile" style="width:100%">

                        </div>
                        <div class="col-6">
                            <img class="img-fluid mb-5"
                                src="{{ asset('assets/img/promo/white-label-shop-company-profile.png') }}"
                                alt="Company Profile" style="width:100%">

                            <img class="img-fluid"
                                src="{{ asset('assets/img/promo/white-label-stock-management.png') }}"
                                alt="Company Profile" style="width:100%">
                        </div>




                    </div>



                    <div class="row">
                        <div class="col-12">
                            <a class="btn btn-secondary mt-5"
                            target="_blank"
                            href="{{ route('custom-pages.show_custom_page', ['features']) }}">
                                {{ translate(' Explore all features', true) }}
                            </a>
                            <div class="text-center mb-3 mt-3">
                                <span class="divider divider-text">
                                    {{ translate('Or') }}
                                </span>
                            </div>
                            <a class="btn btn-info"
                            target="_blank"
                            href="{{ route('custom-pages.show_custom_page', ['contact']) }}">
                                {{ translate('Talk to an Expert', true) }}
                                <br><small> {{ translate('45min. consultation about your business digital needs') }} </small>
                            </a>
                        </div>

                    </div>

                </div>
                <!-- End List Checked -->
            </div>
        </div>
        <!-- End Cover -->

        <div class="col-lg-5 d-flex justify-content-center align-items-center min-vh-lg-100  order-1">
            <div class="w-100 pt-3 mt-lg-7 mb-7 text-white bg-dark" style="border-radius: 10px;">
                <!-- Form -->
                <h2 class="h2 text-white pl-3"> {{ translate('Shop Registration Form') }} </h2>
                <!-- End Form -->
            </div>
        </div>
    </div>
    <!-- End Row -->
</div>

@endsection
