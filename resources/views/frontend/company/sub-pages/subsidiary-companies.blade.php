@extends('frontend.layouts.company-profile-layout')

@section('company_profile')
    <x-company-tabs :seller="$seller" type="subsidiary-companies"></x-company-tabs>
    <div class="text-center">
        <div class="h1">
            <span class="badge badge-primary badge-pill text-uppercase w-auto h-auto">
                <i class="tio-verified"></i> B2BWood Prime
            </span>
        </div>

        <div class="mb-4">
            <h2>{{ translate('Unlock this data with prime membership') }}</h2>
        </div>

        <div class="w-lg-50 mx-lg-auto mb-5">
            <img class="img-fluid" style="width: 200px;"
                src="https://cdn.dribbble.com/users/2770239/screenshots/6617960/locked_4x.png" alt="Image Description">
        </div>

        <p>{{ translate('Get an access to this data by joining B2BWood Club') }}

            <a href="/pages/about/" target="_blank">
                {{ translate('Learn More') }} <i class="tio-chevron-right"></i>
            </a>
        </p>

        <a class="btn btn-primary px-3" href="{{ route('shops.create') }}">
            {{ translate('Join B2BWood Club') }}
        </a>
    </div>

@endsection
