@extends('frontend.layouts.app')

@section('content')
    <x-tenant.hero.split-with-image></x-tenant.hero.split-with-image>

    <x-e-v-search 
        header="Just shipped version 0.1.0"
        title="Server management for growing teams"
        description="Anim aute id magna aliqua ad ad non deserunt sunt. Qui irure qui lorem cupidatat commodo."
        footer="Rated 5 stars by over 500 beta users"
        image="https://media.winefolly.com/blue-apron-wine-club-review-winefolly.jpg"
    ></x-e-v-search>

    <x-tenant.brand.simple></x-tenant.brand.simple>
    <x-tenant.product-list></x-tenant.product-list>
    <x-tenant.category.previews.with-background-image-and-detail-overlay>

    </x-tenant.category.previews.with-background-image-and-detail-overlay>
    <x-tenant.incentives.four-column-with-ilustrations></x-tenant.incentives.four-column-with-ilustrations>
    <x-tenant.category.previews.with-scrolling-cards></x-tenant.category.previews.with-scrolling-cards>
@endsection
