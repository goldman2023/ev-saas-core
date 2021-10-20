@extends('frontend.layouts.app')

@section('content')

    <section class="overflow-hidden">
        <x-default.hero.product-hero></x-default.hero.product-hero>
        {{-- <x-default.promo.countdown></x-default.promo.countdown> --}}
    </section>

   <section class="space-2">
        <x-default.products.product-list :slider="false">
        </x-default.products.product-list>
    </section>

    <section class="ev-product-contact">
        <x-default.contacts.sections.contact-form-with-map></x-default.contacts.sections.contact-form-with-map>
    </section>

    {{-- TODO: Refactor this to blade components --}}
    @include('frontend.components.benefits')


@endsection

@section('script')

@endsection
