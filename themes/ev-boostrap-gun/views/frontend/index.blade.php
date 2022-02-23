@extends('frontend.layouts.app')

@section('content')

<section style="max-width: 100%; overflow: scroll;">
    {{-- <x-default.brands.brands-list>
    </x-default.brands.brands-list> --}}
</section>



<section class="overflow-hidden">
    {{-- <x-default.hero.product-hero></x-default.hero.product-hero> --}}
    {{-- <x-default.promo.countdown></x-default.promo.countdown> --}}
</section>

<section>
    <div class="container">
        {{-- <x-default.products.recently-viewed-products></x-default.products.recently-viewed-products> --}}
    </div>
</section>

<section class="space-1">
    {{-- <x-default.products.product-list slider="true">
    </x-default.products.product-list> --}}
</section>


<section>
    {{-- <x-default.companies.companies-list></x-default.companies.companies-list> --}}
</section>

<section id="archive-hero">
    {{-- <x-companies-archive-hero></x-companies-archive-hero> --}}
</section>

<section>
    {{-- <x-default.promo.reviews></x-default.promo.reviews> --}}
</section>

@endsection
