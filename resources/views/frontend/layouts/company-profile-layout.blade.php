{{-- This is child layout only for company profile pages, this should extend the main layout, app.blade.php --}}

@extends('frontend.layouts.app')


@section('content')
    <div class="b2b-company-profile">
        <div class="bg-img-hero b2b-company-profile__cover"
            style="background: url('{{ $seller->user->shop->get_company_cover() }}'); background-size: 100%;">
            <div class="container space-3 space-lg-3">
                <div class="w-lg-65 text-center mx-lg-auto">


                </div>
            </div>
        </div>
        <div class="container space-2 space-lg-0 ">
            <div class="row flex-lg-row flex-sm-column-reverse">
                <div id="stickyBlockStartPoint" class="b2b-company-details-card col-lg-3 mb-7 mb-lg-0"
                    style="margin-top: -150px;">
                    <!-- Sidebar Content -->
                    <div class="js-sticky-block card bg-white">
                        <div class="card-header text-center py-5 d-block">
                            <div class="max-w-27rem w-100 mx-auto">
                                <img class="img-fluid" src="{{ $seller->user->shop->get_company_logo() }}"
                                    alt="{{ $seller->user->shop->name }}">
                            </div>
                            <div class="d-block b2b-verified-icon mt-3 w-100">


                                <h1 class="d-md-none" style="font-size: 16px;">
                                    {{ $seller->user->shop->name }}
                                </h1>
                                <x-verified-company-badge :company="$seller"></x-verified-company-badge>

                            </div>
                        </div>

                        <div class="card-body">
                            <dl class="row font-size-1">
                                <dt class="col-sm-12 text-dark">{{ translate('Website') }}</dt>
                                {{-- TODO: make this info dynamic from company attributes --}}
                                <dd class="col-sm-12 text-body b2b-company-website-link">
                                    <x-company-website-link :company="$seller->user->shop"> </x-company-website-link>

                                </dd>
                            </dl>
                            <div class="border-bottom pb-2 mb-4">
                                <dl class="row font-size-1">
                                    <dt class="col-sm-12 text-dark">{{ translate('Industries') }}</dt>
                                    {{-- TODO: make this info dynamic from company attributes --}}
                                    <dd class="col-sm-12 text-body">
                                        <x-company-industries :company="$seller->user->shop">
                                        </x-company-industries>
                                    </dd>
                                </dl>
                                <dl class="row font-size-1">
                                    <dt class="col-sm-12 text-dark">{{ translate('Headquarters') }}</dt>
                                    <dd class="col-sm-12 text-body">
                                        {{-- TODO: make this info dynamic from company attributes --}}
                                        @php
                                            $company_country = $seller->get_attribute_value_by_id(12);
                                        @endphp
                                        {{ $seller->user->shop->address }}, {{ $company_country }}
                                        <img src="{{ static_asset('assets/img/flags/png/' . strtolower($company_country) . '.png') }}"
                                            height="16">
                                    </dd>
                                </dl>

                                {{-- You can find an example of printing all attributes for the company in all-company-attributes-table.blade.php --}}
                            </div>


                            <div class="border-bottom pb-2 mb-4">
                                <dl class="row font-size-1">
                                    <dt class="col-sm-12 text-dark">{{ translate('VAT Code') }}</dt>

                                    <dd class="col-sm-12 text-body">{{ $seller->get_attribute_value_by_id(42) }}</dd>
                                </dl>

                                <dl class="row font-size-1">
                                    <dt class="col-sm-12 text-dark">{{ translate('Company Code') }}</dt>
                                    <dd class="col-sm-12 text-body">{{ $seller->get_attribute_value_by_id(43) }}</dd>
                                </dl>


                                <dl class="row font-size-1">
                                    <dt class="col-sm-12 text-dark">{{ translate('Founded') }}</dt>
                                    <dd class="col-sm-12 text-body">{{ $seller->get_attribute_value_by_id(10) }}</dd>
                                </dl>

                                <dl class="row font-size-1">
                                    <dt class="col-sm-12 text-dark">{{ translate('B2BWood Member') }}</dt>
                                    <dd class="col-sm-12 text-body">{{ translate('Since') }}
                                        {{ $seller->created_at->diffForHumans() }}</dd>
                                </dl>
                            </div>


                            <div class="mb-3 d-none">
                                <h4>
                                    {{ translate('Certificates') }}
                                </h4>
                            </div>

                            <dl class="row font-size-1 d-none">
                                {{-- TODO: Make this actual document from company documents --}}

                                {{-- <dt class="col-sm-4 mb-3">
                                    <figure class="max-w-8rem w-100">
                                        <img class="img-fluid"
                                            src="https://ca.fsc.org/inc/clients/clnt.ca.fsc.org/md/gd/GD_750x435-70_cropped_auto_1348582347_image.jpg">
                                    </figure>
                                </dt> --}}
                                <dd class="col-sm-12 text-body">
                                    <h4 class="font-size-1 mb-0">FSC Sertificate Holder</h4>
                                    <p class="font-size-1 mb-0">
                                        {{-- <a href="#" target="_blank">{{ translate('Validate certificate >') }} </a> --}}
                                    </p>
                                </dd>
                            </dl>
                            <dl class="row font-size-1 mb-0 d-none">
                                {{-- <dt class="col-sm-4 mb-2 mb-sm-0">
                                    <figure class="max-w-8rem w-100">
                                        <img class="img-fluid"
                                            src="https://www.antalis.lt/_media/files/images/Who%20we%20are/Antalis%20%26%20environment/PEFC.jpg"
                                            alt="SVG">
                                    </figure>
                                </dt> --}}
                                <dd class="col-sm-12 text-body">
                                    <h4 class="font-size-1 mb-0">PEFC Sertificate Holder</h4>
                                    <p class="font-size-1 mb-0">
                                        {{-- <a href="#" target="_blank">
                                            {{ translate('Validate certificate >') }}
                                        </a> --}}
                                    </p>
                                </dd>
                            </dl>
                        </div>
                        <div class="display-4 text-center fw-400 mb-3">

                            <x-company-social-links :company="$seller->user->shop"> </x-company-social-links>
                        </div>
                    </div>
                    {{-- <x-company-onboarding-wizard></x-company-onboarding-wizard> --}}

                    <!-- Credit Report Box -->
                     <x-credit-report-box :company="$seller"></x-credit-report-box>
                    <!-- End Credit Report Box -->
                </div>


                <!-- End Sidebar Content -->

                <div class="col-lg-9 space-lg-1 mb-0">
                    @yield('company_profile')
                </div>
            </div>
        </div>
    @endsection
