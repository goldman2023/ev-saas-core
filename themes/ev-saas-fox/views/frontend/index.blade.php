@extends('frontend.layouts.app')

@section('content')



    <section class="overflow-hidden bg-light">
        <x-default.hero.hero-with-search></x-default.hero.hero-with-search>
    </section>

    <section class="overflow-hidden bg-white">
        <x-default.companies.companies-list></x-default.companies.companies-list>
    </section>

    <section class="space-1" style="background: #f5f2ec">
        <x-default.products.product-list :slider="false">
        </x-default.products.product-list>
    </section>

    <section class="bg-light">
        <x-default.categories.category-list :categories="$categories" slider="true"> </x-default.categories.category-list>
    </section>

    {{-- TODO: Refactor this to blade components --}}
    <section class="bg-light">
    @include('frontend.components.benefits')
    </section>
@endsection

@section('script')

@endsection
