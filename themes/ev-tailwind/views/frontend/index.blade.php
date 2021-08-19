@extends('frontend.layouts.app')

@section('content')
    {{-- <x-tenant.search.hero-search></x-tenant.search.hero-search> --}}
    <div class="pb-3">
    <x-tenant.hero.simple-centered></x-tenant.hero.simple-centered>

    </div>



    <x-tenant.product-list></x-tenant.product-list>

    <x-tenant.brand.simple></x-tenant.brand.simple>


    <x-tenant.incentives.four-column-with-ilustrations></x-tenant.incentives.four-column-with-ilustrations>


    <x-tenant.category.previews.with-scrolling-cards></x-tenant.category.previews.with-scrolling-cards>
    <x-tenant.category.previews.horizontal-link-cards>

        <div class="container mx-auto"  >
    </x-tenant.category.previews.horizontal-link-cards>

        </div>


    {{-- <x-tenant.banners.flaoting-at-bottom> </x-tenant.tenant.banners.flaoting-at-bottom> --}}
@endsection
