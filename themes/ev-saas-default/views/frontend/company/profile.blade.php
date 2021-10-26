@extends('frontend.layouts.'.$globalLayout)

@section('content')
<section class="bg-dark space-top-lg-3  space-top-2 c-single-vendor-hero" >
    <div class="container">
        <h3 class="text-white">{{ translate('Gun auctions') }}</h3>
    </div>

    <x-default.auctions.list.auction-slider>
    </x-default.auctions.list.auction-slider>

</section>
    <section class="space-1 bg-dark">
        <div class="container">
            <div class="row position-relative">
                <div class="col-md-3 position-static">
                    <x-ev.category-mega-menu></x-ev.category-mega-menu>
                </div>
                <div class="col-md-9">
                    <x-default.merchant.promo.image-slider></x-default.merchant.promo.image-slider>
                </div>
            </div>
        </div>

    </section>

    @include('frontend.components.benefits')

    <section class="space-1">
        <x-default.products.product-list :products="$shop->products" :slider="true">
        </x-default.products.product-list>
    </section>

    <section class="space-1">
        <div class="container">
            <h3>
                {{ translate('Product Categories') }}
            </h3>
            <x-default.categories.list.category-list-with-left-tabs>
            </x-default.categories.list.category-list-with-left-tabs>
        </div>

    </section>

    <section>
        <div class="container">
            <h3>{{ translate('Shop by Brand') }}</h3>
        </div>
        <x-default.brands.brands-list>
        </x-default.brands.brands-list>
    </section>

    @include('frontend.components.benefits')

@endsection
