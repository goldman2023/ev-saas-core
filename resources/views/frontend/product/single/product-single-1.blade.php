@extends('frontend.layouts.' . $globalLayout)

@section('meta')
<x-default.products.single.head-meta-tags :product="$product"></x-default.products.single.head-meta-tags>
@endsection

@section('content')
<div class="bg-white">
    <div class="mx-auto py-8 px-4 sm:py-18 sm:px-6 lg:max-w-7xl lg:px-4">
        <!-- Product -->
        <div class="lg:grid lg:grid-rows-1 lg:grid-cols-7 lg:gap-x-8 lg:gap-y-3 xl:gap-x-16">
            <!-- Product Gallery -->
            <div class="lg:row-end-1 lg:col-span-4">
                <x-galleries.main-gallery template="product-gallery" :model="$product" class="">
                </x-galleries.main-gallery>
            </div>

            <!-- Product details -->
            <div class="w-full mx-auto mt-14 sm:mt-16 lg:max-w-none lg:mt-0 lg:row-end-2 lg:row-span-2 lg:col-span-4">
                <div class="flex flex-col">
                    <div class="w-full flex space-x-3">
                        @foreach($product->categories as $category)
                        @if(empty($category->parent_id))
                        <div class="badge-info !text-14 !py-1">{{ $category->name }}</div>
                        @endif
                        @endforeach
                    </div>
                    <div class="w-full mt-3">
                        <h1 class="text-2xl font-extrabold tracking-tight text-gray-900 sm:text-3xl">
                            {{ $product->getTranslation('name') }}
                        </h1>

                        {{-- <h2 id="information-heading" class="sr-only">Product information</h2>
                        <p class="text-sm text-gray-500 mt-2"> {{ translate('Views: ') }} {{
                            $product->public_view_count() }} (Updated <time datetime="2021-06-05">{{
                                $product->updated_at->diffForHumans() }}</time>)</p> --}}
                    </div>

                    <div class="w-full mt-3">
                        <div class="flex items-center">
                            {{-- TODO: FIX THIS TO USE REAL RATING --}}
                            @for($i = 0; $i < 4; $i++) @svg('heroicon-s-star', ['class'=> 'text-warning h-5 w-5
                                flex-shrink-0'])
                                @endfor

                                @svg('heroicon-s-star', ['class' => 'text-gray-300 h-5 w-5 flex-shrink-0'])

                                <span class="ml-2 text-gray-500">{{ $product->rating }}</span>
                                <span class="ml-3 text-gray-500">{{ '(67 reviews)' }}</span>
                        </div>
                    </div>
                </div>

                <p class="text-gray-500 mt-4">
                    {!! $product->getTranslation('excerpt') !!}
                </p>
                <div class="w-full">
                    <x-default.products.single.product-checkout-card :product="$product">
                    </x-default.products.single.product-checkout-card>
                </div>

                <div class="w-full flex flex-col mt-4">
                    <div class="flex items-center">
                        <div class="grow flex items-center">
                            <span class="mr-2 text-gray-900 font-semibold">{{ translate('Sold by') }}:</span>
                            <span class="mr-1">
                                <a href="{{ $product->shop->getPermalink() }}">
                                    <img src="{{ $product->shop->getThumbnail(['w' => '100']) }}"
                                        class="w-7 h-7 rounded" />
                                </a>
                            </span>
                            <a href="{{ $product->shop->getPermalink() }}" class="text-gray-800">{{ $product->shop->name
                                }}</a>
                        </div>
                        <div class="shrink-0">
                            <button type="button" class="btn-primary">
                                @svg('heroicon-o-chat-alt-2', ['class' => 'w-4 h-4 mr-2'])
                                {{ translate('Message seller') }}
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center mt-2">
                        <div class="grow flex items-center" x-data="{
                            shareFB(){
                                url = 'https://www.facebook.com/sharer/sharer.php?display=popup&u=' + window.location.href;
                                options = 'toolbar=0,status=0,resizable=1,width=626,height=436';
                                window.open(url,'sharer',options);
                            },
                            tweetit() {
                                url = 'https://twitter.com/intent/tweet?text={{ urlencode($product->name. '! Check it out here: ' . $product->getPermalink()) }}',
                                window.open(url,'sharer', '');
                            }
                        }">
                            <span class="mr-2 text-gray-900 font-semibold">{{ translate('Share') }}:</span>

                            {{-- Social share --}}
                            <div class="mr-2">
                                <div @click="shareFB()"
                                    class="flex items-center justify-center w-6 h-6 text-gray-400 hover:text-gray-500 cursor-pointer">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M20 10c0-5.523-4.477-10-10-10S0 4.477 0 10c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V10h2.54V7.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V10h2.773l-.443 2.89h-2.33v6.988C16.343 19.128 20 14.991 20 10z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                            <div class="mr-2">
                                <div @click="tweetit()"
                                    class="flex items-center justify-center w-6 h-6 text-gray-400 hover:text-gray-500 cursor-pointer">
                                    <span class="sr-only">Share on Twitter</span>
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                        <path
                                            d="M6.29 18.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0020 3.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.073 4.073 0 01.8 7.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 010 16.407a11.616 11.616 0 006.29 1.84" />
                                    </svg>
                                </div>
                            </div>
                            {{-- END Social share --}}

                        </div>
                    </div>
                </div>

                {{-- <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-2">
                    <button type="button"
                        class="w-full bg-indigo-600 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-indigo-500">Pay
                        $220</button>
                    <button type="button"
                        class="w-full bg-indigo-50 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-indigo-700 hover:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-indigo-500">Preview</button>

                </div> --}}

                {{-- <div class="hidden border-t border-gray-200 mt-10 pt-10">
                    <h3 class="text-sm font-medium text-gray-900">Highlights</h3>
                    <div class="mt-4 prose prose-sm text-gray-500">
                        <ul role="list">
                            <li>200+ SVG icons in 3 unique styles</li>
                            <li>Compatible with Figma, Sketch, and Adobe XD</li>
                            <li>Drawn on 24 x 24 pixel grid</li>
                        </ul>
                    </div>
                </div> --}}

                {{-- <div class="hiddenborder-t border-gray-200 mt-10 pt-10">
                    <h3 class="text-sm font-medium text-gray-900">{{ translate('Sold by:') }}</h3>
                    <livewire:feed.elements.shop-card :shop="$product->shop"></livewire:feed.elements.shop-card>
                </div> --}}


            </div>

            <div class="w-full mt-16 lg:max-w-none lg:mt-0 lg:col-span-8 mb-10">
                {{-- <x-tailwind-ui.sections.ecommerce.incentives-sections.incentives-section08>
                </x-tailwind-ui.sections.ecommerce.incentives-sections.incentives-section08> --}}
                {{-- <div>
                    <div class="border-b border-gray-200">
                        <div class="-mb-px flex space-x-8" aria-orientation="horizontal" role="tablist">
                            <!-- Selected: "border-indigo-600 text-indigo-600", Not Selected: "border-transparent text-gray-700 hover:text-gray-800 hover:border-gray-300" -->
                            <button id="tab-reviews"
                                class="border-transparent text-gray-700 hover:text-gray-800 hover:border-gray-300 whitespace-nowrap py-6 border-b-2 font-medium text-sm"
                                aria-controls="tab-panel-reviews" role="tab" type="button">
                                {{ translate('Product Description') }} </button>

                        </div>
                    </div>

                    <!-- 'Customer Reviews' panel, show/hide based on tab state -->
                    <div id="tab-panel-reviews" class="-mb-10" aria-labelledby="tab-reviews" role="tabpanel"
                        tabindex="0">

                        {!! $product->description !!}

                        <x-default.products.single.product-specification-table :product="$product">
                        </x-default.products.single.product-specification-table>
                    </div>
                    <!-- 'FAQ' panel, show/hide based on tab state -->
                </div> --}}

                <div x-data="{
                        current: 'description'
                    }">
                    <div class="sm:hidden">
                        <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
                        <select id="tabs" name="tabs"
                            class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option>My Account</option>
                            <option>Company</option>
                            <option>Team Members</option>
                            <option>Billing</option>
                        </select>
                    </div>
                    <div class="hidden sm:block">
                        <div class="border-b border-gray-200">
                            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                                <div @click="current = 'description';"
                                    :class="{'text-primary border-primary ': current == 'description'}"
                                    class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-18 cursor-pointer">
                                    {{ translate('Description') }} </div>
                                <div @click="current = 'specification';"
                                    :class="{'text-primary border-primary ': current == 'specification'}"
                                    class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-18 cursor-pointer">
                                    {{ translate('Specification') }} </div>
                                <div @click="current = 'shipping';"
                                    :class="{'text-primary border-primary ': current == 'shipping'}"
                                    class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-18 cursor-pointer"
                                    aria-current="page"> {{ translate('Shipping') }} </div>
                                <div @click="current = 'returns';"
                                    :class="{'text-primary border-primary ': current == 'returns'}"
                                    class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-18 cursor-pointer">
                                    {{ translate('Returns and buyers protections') }} </div>
                            </nav>
                        </div>
                    </div>

                    <div class="w-full mt-5" x-cloak>
                        <div class="" x-show="current == 'description'">
                            {!! $product->description !!}
                        </div>

                        <div class="" x-show="current == 'specification'">
                            <x-default.products.single.product-specification-table :product="$product">
                            </x-default.products.single.product-specification-table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="bg-gray-100">
    <div class="container  mt-[200px]">
        <x-default.products.recently-viewed-products class="p-3"></x-default.products.recently-viewed-products>
    </div>
</div>



@endsection
