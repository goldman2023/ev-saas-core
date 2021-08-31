@extends('frontend.layouts.app')

@section('content')
{{-- <section class="space-1">
    <x-default.brands.brands-list></x-default.brands.brands-list>
</section> --}}
    <section class="overflow-hidden">
        <x-default.hero.product-hero></x-default.hero.product-hero>
        {{-- <x-default.promo.countdown></x-default.promo.countdown> --}}
    </section>

    <section>
        <x-default.grid.cards-grid></x-default.grid.cards-grid>
    </section>

    <section>
        <x-default.products.product-list slider="false">
        </x-default.products.product-list>
    </section>

    {{-- TODO: Refactor this to blade components --}}
    @include('frontend.components.benefits')
    {{-- <section>
        <x-default.forms.contact-form></x-default.forms.contact-form>
    </section> --}}
    {{-- TODO: Refactor this to blade components --}}
    {{-- @include('frontend.components.news') --}}
@endsection

@section('script')

@endsection
