@extends('frontend.layouts.app')

@section('content')

    <x-tenant.product-list></x-tenant.product-list>

    <x-tenant.category.previews.with-scrolling-cards></x-tenant.category.previews.with-scrolling-cards>

    <x-tenant.services.two-column-with-vertical-images></x-tenant.services.two-column-with-vertical-images>

@endsection
