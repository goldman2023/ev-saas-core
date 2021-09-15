@extends('frontend.layouts.user_panel')

@section('panel_content')
    <div class="row">
        <div class="col-12">
            {{-- TODO: add custom CTA and Text and Image options --}}
            {{-- <x-free-member-notification> </x-free-member-notification> --}}
            {{-- <x-company.company-onboarding-box> </x-company.company-onboarding-box> --}}
        </div>

        <div class="container">
            @isset(auth()->user()->shop)
            <div class="row">
                <div class="col-12">
                    <h3> {{ translate('Components') }}</h3>
                    This will be components table
                </div>
            </div>
            @endisset
        </div>
        {{-- <x-company.company-dashboard-stats></x-company.company-dashboard-stats> --}}
    </div>



    <div class="row">
        <div class="col-md-6">
            {{-- <x-company.company-subscription-package></x-company.company-subscription-package> --}}
        </div>

        <div class="col-md-6">

        </div>

    </div>



@endsection
