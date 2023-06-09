@extends('frontend.layouts.' . $globalLayout)

@section('meta_title'){{ $product->meta_title }}@stop

@section('meta_description'){{ $product->meta_description }}@stop

@section('meta_keywords'){{ $product->tags }}@stop

@section('meta')
    <x-default.products.single.head-meta-tags :product="$product"></x-default.products.single.head-meta-tags>
@endsection

@section('content')
<div class="position-relative mb-5">
    <x-default.products.single.product-slider :product="$product"></x-default.products.single.product-slider>

    <div class="container">
        <div class="row">
            <div class="col-lg-8 bg-white rounded card">
                <x-default.products.single.product-details-tabs :product="$product">
                </x-default.products.single.product-details-tabs>
            </div>
        </div>
    </div>

    <div id="stickyBlockEndPoint2"></div>

    {{-- @include('frontend.components.benefits') --}}
    <section class="space-top-1">
        @php
          $relatedProducts = null;
        @endphp

        <x-default.products.product-list :products="$relatedProducts" class="products-slider" slider="true">
        </x-default.products.product-list>
    </section>

    @endsection

    @section('modal')

    <x-default.modals.product-message-modal :product="$product"></x-default.modals.product-message-modal>
    <!-- Modal -->
    <x-default.modals.login-modal></x-default.modals.login-modal>
    @endsection

    @section('script')
    
    @endsection
