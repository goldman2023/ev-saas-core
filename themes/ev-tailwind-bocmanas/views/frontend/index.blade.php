@extends('frontend.layouts.app')

@section('content')
    <x-tenant.hero.split-with-image></x-tenant.hero.split-with-image>

    <x-tenant.product-list></x-tenant.product-list>

    <x-tenant.category.previews.with-scrolling-cards></x-tenant.category.previews.with-scrolling-cards>
@endsection
