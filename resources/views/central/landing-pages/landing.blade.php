@extends('central.layouts.central')

@section('main')

    <x-central.hero></x-central.hero>
    <div class="container mx-auto">
    <div class="">
        <x-central.features.with-screenshot-and-testimonial></x-central.features.with-screenshot-and-testimonial>
    </div>
    </div>
    <div class="bg-gray-100">
        <div class="container mx-auto">

        <x-central.pricing.single-price-with-details></x-central.pricing.single-price-with-details>
        </div>
    </div>
    <div class="container mx-auto">
        <x-tenant.stats.split-with-image></x-tenant.stats.split-with-image>
    </div>
    <div class="container mx-auto">
        <x-tenant.cta.brand-panel-with-app-screenshot></x-tenant.cta.brand-panel-with-app-screenshot>
    </div>



    <div>
        <x-tenant.footer.simple-centered></x-tenant.footer.simple-centered>
    </div>



{{--    <x-tenant.banners.floating-at-bottom></x-tenant.banners.floating-at-bottom>--}}
@endsection
