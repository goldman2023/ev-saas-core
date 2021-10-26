@extends('frontend.layouts.'.$globalLayout)

@section('content')
<section class="bg-dark pt-lg-10">
    <div class="container pt-lg-10">
        <h3 class="text-white">{{ translate('Gun auctions') }}</h3>
    </div>

    <x-default.auctions.list.auction-slider>
    </x-default.auctions.list.auction-slider>

</section>
    <section class="space-1 bg-dark space-lg-top-3">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <img class="w-100" style="object-fit:contain; margin-bottom: 10px;"
                        src="{{ $shop->get_company_logo() }}" alt="{{ $shop->name }}">

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

    <section class="space-2">
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
@endsection
