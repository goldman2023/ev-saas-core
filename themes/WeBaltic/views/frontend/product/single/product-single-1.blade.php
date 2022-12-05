@extends('frontend.layouts.' . $globalLayout)

@section('meta')
<x-default.products.single.head-meta-tags :product="$product"></x-default.products.single.head-meta-tags>
@endsection

@section('content')
{{ Breadcrumbs::render('product', $product) }}
<div class="bg-gray-100">
    <main class="mx-auto max-w-7xl sm:px-6 sm:pt-16 lg:px-8">
        <div class="mx-auto max-w-2xl lg:max-w-none">
            <!-- Product -->
            <div class="lg:grid lg:grid-cols-2 lg:items-start lg:gap-x-8">
                <!-- Image gallery -->
                <div class="flex flex-col-reverse">
                    <x-product.single.support-box></x-product.single.support-box>

                    <x-products.single.product-benefits></x-products.single.product-benefits>
                    <!-- Image selector -->
                    <div class="mx-auto mt-6 hidden w-full max-w-2xl sm:block lg:max-w-none">
                        <div class="grid grid-cols-4 gap-6" aria-orientation="horizontal" role="tablist">
                            @foreach($product->gallery as $image)
                            <button id="tabs-2-tab-1"
                                class="relative flex h-24 cursor-pointer items-center justify-center rounded-md bg-white text-sm font-medium uppercase text-gray-900 hover:bg-gray-50 focus:outline-none focus:ring focus:ring-opacity-50 focus:ring-offset-4"
                                aria-controls="tabs-2-panel-1" role="tab" type="button">
                                <span class="sr-only"> Angled view </span>
                                <span class="absolute inset-0 overflow-hidden rounded-md">
                                    <img loading="lazy" :src="window.WE.IMG.url('{{$image->file_name}}')" alt=""
                                        class="w-full object-contain object-center">
                                </span>
                                <!-- Selected: "ring-indigo-500", Not Selected: "ring-transparent" -->
                                <span
                                    class="ring-transparent pointer-events-none absolute inset-0 rounded-md ring-2 ring-offset-2"
                                    aria-hidden="true"></span>
                            </button>
                            @endforeach

                            <!-- More images... -->
                        </div>
                    </div>

                    <div class="w-full">
                        <!-- Tab panel, show/hide based on tab state. -->
                        <div id="tabs-2-panel-1" aria-labelledby="tabs-2-tab-1" role="tabpanel" tabindex="0">
                            <img src="{{ $product->getThumbnail(['w' => 1200]) }}"
                                alt="Angled front view with bag zipped and handles upright."
                                class="w-full object-contain object-center sm:rounded-lg">
                        </div>

                        <!-- More images... -->
                    </div>
                </div>

                <!-- Product info -->
                <div class="mt-10 px-4 sm:mt-16 sm:px-0 lg:mt-0">
                    <h1 class="text-4xl font-bold tracking-tight text-gray-900">
                        {{ $product->name }}
                    </h1>

                    <div class="mt-3">
                        <h2 class="sr-only">Product information</h2>
                        <p class="text-3xl tracking-tight text-gray-900">{{ FX::formatPrice($product->getBasePrice()) }}
                        </p>
                    </div>



                    <div class="mt-6">
                        <h3 class="sr-only">Description</h3>

                        <div class="space-y-6 text-base text-gray-700">
                            <p>
                                {!! $product->description !!}
                            </p>
                        </div>
                    </div>
                    <x-default.products.single.product-checkout-card :product="$product">
                    </x-default.products.single.product-checkout-card>

                     <!-- Reviews -->
                     <div class="mt-3">
                        <h3 class="sr-only">{{ translate('Stock details') }}</h3>
                        <div class="flex items-center">
                            <div class="flex items-center">
                                <div class="mt-6 flex items-center">
                                    <svg class="h-6 w-6 flex-shrink-0 text-green-500"
                                        x-description="Heroicon name: mini/check" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <p class="ml-2 text-sm text-gray-500">
                                        {{ translate('Available in warehouse') }}
                                    </p>
                                </div>


                            </div>

                            <div class="flex items-center">
                                <a class="ml-6 mt-6 flex items-center text-underline">


                                    @svg('heroicon-o-document-text', ['class' => 'h-6 w-6 flex-shrink-0 text-primary-600'])

                                    <div class="ml-2 text-sm text-gray-500">
                                        {{ translate('Download User Guide') }} (.pdf)
                                    </div>
                                </a>


                            </div>
                        </div>
                    </div>

                    <form class="hidden mt-6">
                        <div class="mt-10 flex">
                            <button type="submit"
                                class="flex max-w-xs flex-1 items-center justify-center rounded border border-transparent bg-indigo-600 py-3 px-8 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50 sm:w-full">
                                {{ translate('Add to order') }}
                            </button>

                            <button type="button"
                                class="ml-4 flex items-center justify-center rounded-md py-3 px-3 text-gray-400 hover:bg-gray-100 hover:text-gray-500">
                                <!-- Heroicon name: outline/heart -->
                                <svg class="h-6 w-6 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                </svg>
                                <span class="sr-only">Add to favorites</span>
                            </button>
                        </div>
                    </form>

                    <section aria-labelledby="details-heading" class="mt-8">
                        <h2 id="details-heading" class="sr-only">Additional details</h2>

                        <div class="divide-y divide-gray-200">
                            <div>
                                <h3>
                                    <!-- Expand/collapse question button -->
                                    <button type="button"
                                        class="group relative flex w-full items-center justify-between py-6 text-left"
                                        aria-controls="disclosure-1" aria-expanded="false">
                                        <!-- Open: "text-indigo-600", Closed: "text-gray-900" -->
                                        <span class="text-gray-900 text-lg font-medium">
                                            {{ translate('Product specification') }}
                                        </span>
                                        <span class="ml-6 flex items-center">
                                            <!--
                                                Heroicon name: outline/plus

                                                Open: "hidden", Closed: "block"
                                                -->
                                            <svg class="block h-6 w-6 text-gray-400 group-hover:text-gray-500"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 4.5v15m7.5-7.5h-15" />
                                            </svg>
                                            <!--
                                                Heroicon name: outline/minus

                                                Open: "block", Closed: "hidden"
                                                -->
                                            <svg class="hidden h-6 w-6 text-indigo-400 group-hover:text-indigo-500"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15" />
                                            </svg>
                                        </span>
                                    </button>
                                </h3>
                                <div class="prose prose-sm pb-6" id="disclosure-1">

                                    <x-default.products.single.product-specification-table :product="$product">
                                    </x-default.products.single.product-specification-table>
                                </div>
                            </div>

                            <!-- More sections... -->
                        </div>
                    </section>


                </div>
            </div>
        </div>

        <x-products.single.technical-specification-section :product="$product">
        </x-products.single.technical-specification-section>


        <x-products.single.related-products :products="$product->relatedProducts()">
        </x-products.single.related-products>
    </main>
</div>
@endsection
