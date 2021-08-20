@extends('frontend.layouts.app')

@section('content')
    @php
        $prices = home_discounted_base_price($product['id'], false, true); // raw and display price
    @endphp
    <div class="bg-white">
        <div class="pt-6 pb-16 sm:pb-4"
            x-data="{
                id: {{ $product['id'] }},
                title: '{{ $product['name'] }}',
                price: {
                    raw: {{ $prices['raw'] }},
                    display: '{{ $prices['display'] }}'
                },
                thumb: '{{  $product['images']['thumbnail']['url'] ?? '' }}',
                link: '{{ route('product', $product['slug']) }}'
            }">
            <x-tenant.system.breadcrumbs></x-tenant.system.breadcrumbs>
            <div class="mt-8 max-w-2xl mx-auto px-4 sm:px-6 lg:max-w-7xl lg:px-4">
                <div class="lg:grid lg:grid-cols-12 lg:auto-rows-min lg:gap-x-8">
                    <x-tenant.product.product-details :product="$product"></x-tenant.product.product-details>

                    <!-- Image gallery -->
                    <x-tenant.product.product-gallery :product="$product"></x-tenant.product.product-gallery>
                </div>
            </div>
            <x-tenant.product.reviews.with-summary-chart></x-tenant.product.reviews.with-summary-chart>
            <x-tenant.product-list></x-tenant.product-list>
        </div>
    </div>
@endsection
