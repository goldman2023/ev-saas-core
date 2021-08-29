@extends('frontend.layouts.user_panel')

@section('panel_content')
    {{-- <div class="aiz-titlebar mt-2 mb-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">{{ translate('Dashboard') }}</h1>
            </div>
        </div>
    </div> --}}

    <div class="row">
        <div class="col-12">
            {{-- TODO: add custom CTA and Text and Image options --}}
            {{-- <x-free-member-notification> </x-free-member-notification> --}}
            {{-- <x-company.company-onboarding-box> </x-company.company-onboarding-box> --}}
        </div>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3> {{ translate('Website Admin Panel') }}</h3>
                    {{-- <x-company.company-card :company="auth()->user()->shop"> </x-company.company-card> --}}
                </div>
            </div>
        </div>
        {{-- <x-company.company-dashboard-stats></x-company.company-dashboard-stats> --}}
    </div>



    <div class="row">
        <div class="col-md-6">
            {{-- <x-company.company-subscription-package></x-company.company-subscription-package> --}}
        </div>

        <div class="col-md-6">
            <div class="card bg-white p-4 text-center">
                {{-- TODO : make this company name dynamic --}}
                <div class="h5 fw-600">{{ translate('Your Website Admin Panel') }} </div>
                <p>{{ translate('Manage & organize your website settings') }}</p>
                <a href="/admin"
                    class="btn btn-soft-primary">{{ translate('Manage your website') }}</a>
            </div>
        </div>

        <div class="col-md-6 d-none">
            <x-company.company-onboarding-wizard></x-company.company-onboarding-wizard>

            <div class="bg-white mt-4 p-5 text-center card">
                <div class="mb-3">
                        <img loading="lazy" src="{{ static_asset('assets/img/verified.png') }}" alt="" width="130">
                </div>
                <a href="{{ route('shop.verify') }}" class="btn btn-primary">
                    {{ translate('Admin Panel') }}
                </a>
                <span class="text-sm text-center">
                    {{ translate('Get detailed report and verification about your company') }}
                </span>
            </div>
        </div>

        <div class="col-sm-6">

            <!-- Body -->
            <!-- End Body -->
        </div>
    </div>



@endsection
