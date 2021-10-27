@extends('frontend.layouts.app')

@section('content')
    @php
        $prices = $product->getTotalPrice(false, true); // raw and display price
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
                quantity: 1,
                colors: null,
                thumb: '{{  $product['images']['thumbnail']['url'] ?? '' }}',
                link: '{{ route('product', $product['slug']) }}'
            }">
            <x-tenant.system.breadcrumbs></x-tenant.system.breadcrumbs>
            <div class="mt-8 max-w-2xl mx-auto px-4 sm:px-6 lg:max-w-7xl lg:px-4">
                <div class="lg:grid lg:grid-cols-12 lg:auto-rows-min lg:gap-x-8">
                    {{-- TODO:
                        add <x-tenant.product.brand>
                        check how it's added in resources/views/product/show.blade.php --}}

                    <x-tenant.product.product-details :product="$product"></x-tenant.product.product-details>

                    <!-- Image gallery -->
                    <x-tenant.product.product-gallery :product="$product"></x-tenant.product.product-gallery>
                </div>
            </div>
            <x-tenant.product-list></x-tenant.product-list>

            @livewire('tenant.product.review', ['product_id'=>$product->id])

        </div>
    </div>
@endsection
