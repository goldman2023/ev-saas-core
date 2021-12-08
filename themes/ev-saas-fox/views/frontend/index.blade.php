@extends('frontend.layouts.app')

@section('content')



    <section class="overflow-hidden">
        <x-default.hero.hero-with-search></x-default.hero.hero-with-search>
    </section>

    <section class="overflow-hidden">
        <x-default.companies.companies-list></x-default.companies.companies-list>
    </section>

    <section class="space-1">
        <x-default.products.product-list :slider="false">
        </x-default.products.product-list>
    </section>

    <section>
        <x-default.categories.category-list :categories="$categories" slider="true"> </x-default.categories.category-list>
    </section>

    {{-- TODO: Refactor this to blade components --}}
    @include('frontend.components.benefits')
@endsection

@section('script')

@endsection
