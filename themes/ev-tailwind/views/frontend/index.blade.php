@extends('frontend.layouts.app')

@section('content')
    <x-tenant.search.hero-search></x-tenant.search.hero-search>

    <x-tenant.hero.simple-centered></x-tenant.hero.simple-centered>

    <x-tenant.product-list></x-tenant.product-list>

    <x-tenant.category.previews.with-scrolling-cards></x-tenant.category.previews.with-scrolling-cards>
@endsection
