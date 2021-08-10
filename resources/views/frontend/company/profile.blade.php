@extends('frontend.layouts.company-profile-layout')

@section('company_profile')


    <x-company-tabs :seller="$seller" type="overview"></x-company-tabs>
    {{-- TODO: Show the announcement only for free users when they are viewing their profile --}}
    {{-- TODO: add advertisment banner for free company profiles when viewed by any other user/ no addvertisment for paid members --}}
    @auth
        @if ($seller->user->id === auth()->user()->id && $seller->verification_status)
            <x-free-member-notification> </x-free-member-notification>
        @endif
    @endauth

    <div class="row">
        <div class="col-sm-6 mb-3">
            <x-company-financials-card :company="$seller"></x-company-financials-card>
        </div>

        <div class="col-sm-6 mb-3">
            <x-company-operational-info-card :company="$seller"></x-company-operational-info-card>
        </div>
    </div>

    <div class="pl-lg-4">
        <h2 class="h3">{{ translate('Company Description') }}</h2>
        {{ $seller->user->shop->meta_description }}
    </div>

@endsection
