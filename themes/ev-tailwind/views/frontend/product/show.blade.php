@extends('frontend.layouts.app')

@section('content')
    <div class="bg-white">
        <div class="pt-6 pb-16 sm:pb-24">
            <x-tenant.system.breadcrumbs></x-tenant.system.breadcrumbs>
            <div class="mt-8 max-w-2xl mx-auto px-4 sm:px-6 lg:max-w-7xl lg:px-8">
                <div class="lg:grid lg:grid-cols-12 lg:auto-rows-min lg:gap-x-8">
                    <x-tenant.product.product-details :product="$product"></x-tenant.product.product-details>





                    <!-- Image gallery -->
                    <div class="mt-8 lg:mt-0 lg:col-start-1 lg:col-span-7 lg:row-start-1 lg:row-span-3">
                        <h2 class="sr-only">Images</h2>

                        <div class="grid grid-cols-1 lg:grid-cols-2 lg:grid-rows-3 lg:gap-8">
                            <img src="https://tailwindui.com/img/ecommerce-images/product-page-01-featured-product-shot.jpg" alt="Back of women&#039;s Basic Tee in black." class="lg:col-span-2 lg:row-span-2 rounded-lg">

                            <img src="https://tailwindui.com/img/ecommerce-images/product-page-01-product-shot-01.jpg" alt="Side profile of women&#039;s Basic Tee in black." class="hidden lg:block rounded-lg">

                            <img src="https://tailwindui.com/img/ecommerce-images/product-page-01-product-shot-02.jpg" alt="Front of women&#039;s Basic Tee in black." class="hidden lg:block rounded-lg">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
