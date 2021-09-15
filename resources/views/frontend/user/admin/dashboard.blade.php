@extends('frontend.layouts.user_panel')

@section('panel_content')

    <div class="bg-white">
        <x-free-member-notification> </x-free-member-notification>
    </div>

    <x-default.dashboard.dashboard-summary.admin>
    </x-default.dashboard.dashboard-summary.admin>

    <div class="row">
        <div class="col-md-6">
            <div class="card bg-white p-4 text-center">
                {{-- TODO : make this company name dynamic --}}
                <div class="h5 fw-600">{{ translate('Products') }} </div>
                <p>{{ translate('Manage & organize your inventory and products') }}</p>
                <a href="{{ route('ev-products.index') }}" class="btn btn-soft-primary">{{ translate('Manage Products') }}</a>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card bg-white p-4 text-center">
                {{-- TODO : make this company name dynamic --}}
                <div class="h5 fw-600">{{ translate('Your Website Admin Panel') }} </div>
                <p>{{ translate('Manage & organize your website settings') }}</p>
                <a href="/admin" class="btn btn-soft-primary">{{ translate('Manage your website') }}</a>
            </div>
        </div>

        <div class="col-md-6">
            {{-- <x-company.company-onboarding-wizard></x-company.company-onboarding-wizard> --}}
        </div>

        <div class="col-sm-6">

            <!-- Body -->
            <!-- End Body -->
        </div>
    </div>



@endsection
