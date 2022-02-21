@extends('frontend.layouts.app')

@section('content')


<section>
    <x-default.hero.ecommerce-hero></x-default.hero.ecommerce-hero>
</section>

@php
$categories = App\Models\Category::where('level', 0)
->whereHas('products')
->orderBy('order_level', 'desc')
->get();
@endphp


<section>
    <div class="container">
        <x-default.products.recently-viewed-products></x-default.products.recently-viewed-products>
    </div>
</section>

<section class="space-1">
    <x-default.products.product-list slider="true">
    </x-default.products.product-list>
</section>



<section class="space-2">

    <x-default.products.product-list.with-category-icons :categories="$categories">
    </x-default.products.product-list.with-category-icons>
</section>



{{-- TODO: Refactor this to blade components --}}
@include('frontend.components.benefits')


<section>
    <x-default.promo.reviews></x-default.promo.reviews>
</section>

@endsection

@section('script')

@endsection
