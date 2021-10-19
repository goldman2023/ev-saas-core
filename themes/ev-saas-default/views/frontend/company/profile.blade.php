@extends('frontend.layouts.white-label')

@section('content')
    <section class="space-1 bg-dark space-top-3">
        <div class="container">
            <div class="row">
                <div class="col-3">
                    <img class="w-100" style="object-fit:contain; margin-bottom: 10px;"
                        src="{{ $shop->user->shop->get_company_logo() }}" alt="{{ $shop->name }}">

                    <x-ev.category-mega-menu></x-ev.category-mega-menu>
                </div>
                <div class="col-9">
                    <x-default.merchant.promo.image-slider></x-default.merchant.promo.image-slider>
                </div>
            </div>
        </div>

    </section>

    @include('frontend.components.benefits')

    <section class="space-1">
        <x-default.products.product-list :products="$shop->user->products" :slider="false">
        </x-default.products.product-list>
    </section>

    <section>
        <div class="container">
            <h3>{{ translate('Shop by Brand') }}</h3>
        </div>
        <x-default.brands.brands-list>
        </x-default.brands.brands-list>
    </section>

@endsection
