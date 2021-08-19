@extends('frontend.layouts.app')

@section('content')
    <x-tenant.hero.split-with-image></x-tenant.hero.split-with-image>

    <x-tenant.brand.simple></x-tenant.brand.simple>
    <x-tenant.product-list></x-tenant.product-list>
    <x-tenant.category.previews.with-background-image-and-detail-overlay>

    </x-tenant.category.previews.with-background-image-and-detail-overlay>

    <x-tenant.incentives.four-column-with-ilustrations></x-tenant.incentives.four-column-with-ilustrations>

    <x-tenant.category.previews.with-scrolling-cards></x-tenant.category.previews.with-scrolling-cards>
@endsection
