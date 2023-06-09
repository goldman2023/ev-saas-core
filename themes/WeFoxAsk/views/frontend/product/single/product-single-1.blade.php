@extends('frontend.layouts.feed')

@section('meta')
<x-default.products.single.head-meta-tags :product="$product"></x-default.products.single.head-meta-tags>
@endsection

@section('feed_content')
<div class="bg-white col-span-12 rounded-lg">
    <div class="mx-auto py-8 px-4 sm:py-18 sm:px-6 lg:max-w-7xl lg:px-4">
        <!-- Product -->
        <div class="lg:grid lg:grid-rows-1 lg:grid-cols-12 lg:gap-x-5 lg:gap-y-3 xl:gap-x-8">
            <!-- Product Gallery -->
            <div class="lg:row-end-1 lg:col-span-6">
                <x-galleries.main-gallery template="product-gallery" :model="$product" class="rounded-lg">
                </x-galleries.main-gallery>
            </div>

            <!-- Product details -->
            <div class="w-full mx-auto mt-14 sm:mt-16 lg:max-w-none lg:mt-0 lg:row-end-2 lg:row-span-2 lg:col-span-6">
                <div class="flex flex-col">
                    <div class="w-full flex space-x-3 overflow-x-hidden flex-wrap">
                        @foreach($product->categories as $category)
                            @if(empty($category->parent_id))
                                <div class="badge-primary !text-14 !py-1 mb-2">{{ $category->name }}</div>
                            @endif
                        @endforeach
                    </div>
                    <div class="w-full mt-1 flex flex-col">
                        <h1 class="text-2xl font-extrabold tracking-tight text-gray-900 sm:text-3xl mb-3">
                            {{ $product->name }}
                        </h1>

                        @if($product->isEvent())
                            <div class="w-full mb-3 flex">
                                <span class="badge-success">{{ translate('Event') }}</span>
                            </div>
                        @endif

                        {{-- <h2 id="information-heading" class="sr-only">Product information</h2>
                        <p class="text-sm text-gray-500 mt-2"> {{ translate('Views: ') }} {{
                            $product->public_view_count() }} (Updated <time datetime="2021-06-05">{{
                                $product->updated_at->diffForHumans() }}</time>)</p> --}}
                    </div>

                    {{-- <div class="w-full mt-3">
                        <div class="flex items-center">
                            {{-- TODO: FIX THIS TO USE REAL RATING --}}
                            {{-- @for($i = 0; $i < 4; $i++) @svg('heroicon-s-star', ['class'=> 'text-warning h-5 w-5
                                flex-shrink-0'])
                                @endfor --}}

                                {{-- @svg('heroicon-s-star', ['class' => 'text-gray-300 h-5 w-5 flex-shrink-0']) --}}

                                {{-- <span class="ml-2 text-gray-500">{{ $product->rating }}</span> --}}
                                {{-- <span class="ml-3 text-gray-500">{{ '(67 reviews)' }}</span> --}}
                        {{-- </div>
                    </div>  --}}
                </div>

                <p class="text-gray-500 mt-4">
                    {!! $product->excerpt !!}
                </p>
                <div class="w-full">

                    @if(!$product->isInStock())
                        <div class="rounded-md bg-yellow-50 p-4 mb-6 mt-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <!-- Heroicon name: solid/exclamation -->
                                    <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-yellow-800">
                                        {{ translate('Product is out of stock.') }}
                                    </h3>
                                    <div class="mt-2 text-sm text-yellow-700">
                                        <p>{{ translate('Product is currently unavailable. Get notified when this product
                                            stock is added.') }}</p>
                                        <livewire:actions.social-action-button action="notify" :object="$product">
                                        </livewire:actions.social-action-button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <h2 class="text-18 text-body font-semibold">
                            {{ translate('') }}
                        </h2> --}}
                    @endif

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
                            <span class="text-gray-800">
                                <a href="{{ $product->shop->getPermalink() }}">
                                    {{ $product->shop->name }}
                                </a>
                            </span>
                        </div>
                        <div class="shrink-0">
                            <button type="button" class="btn-primary">
                                @svg('heroicon-o-chat-bubble-left-right', ['class' => 'w-4 h-4 mr-2'])
                                {{ translate('Message seller') }}
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center mt-4">
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
            </div>


        </div>
        <div
            class="mx-auto py-8 px-4 sm:py-18 sm:px-6 lg:px-4 w-full mt-16 lg:mt-0 lg:col-span-12">
            <div class="lg:row-end-1 lg:col-span-4" x-data="{
                    current: 'description'
                }">
                <div class="sm:hidden">
                    <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
                    <select x-model="current" id="tabs" name="tabs"
                        class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="description">{{ translate('Description') }}</option>
                        <option value="specification">Specification</option>
                        <option value="seller">Seller information</option>
                        {{-- <option value="shipping">Shipping</option> --}}
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

                            <div @click="current = 'seller';"
                                :class="{'text-primary border-primary ': current == 'seller'}"
                                class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-18 cursor-pointer">
                                {{ translate('Seller information') }}
                                @if($product->shop->isVerified())

                                @endif
                            </div>
                            {{-- <div @click="current = 'shipping';"
                                :class="{'text-primary border-primary ': current == 'shipping'}"
                                class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-18 cursor-pointer"
                                aria-current="page"> {{ translate('Shipping') }} </div> --}}
                        </nav>
                    </div>
                </div>

                <div class="w-full mt-5" x-cloak>
                    <div class="" x-show="current == 'description'">
                        {!! $product->description !!}
                    </div>

                    <div class="" x-show="current == 'seller'">
                        <div class="grid grid-cols-1 sm:grid-cols-4 gap-20">
                            <div class="py-10 col-span-2">
                                <h3 class="text-xl font-extrabold tracking-tight text-gray-900 mb-6">
                                    {{ translate("This product is sold by:") }}
                                </h3>
                                <livewire:feed.elements.shop-card :shop="$product->shop">
                                </livewire:feed.elements.shop-card>

                            </div>

                            <div class='col-span-2 py-10'>
                                <h3 class="text-lg font-bold mb-3">
                                    {{ translate('Reviews') }}
                                </h3>
                                <span class="text-gray-600 text-sm">
                                    {{ translate('Only who bought this product can leave a review') }}
                                </span>
                                <livewire:actions.social-comments :reviews="true" :item="$product">
                                </livewire:actions.social-comments>
                            </div>

                        </div>
                    </div>

                    <div class="" x-show="current == 'specification'">

                        <x-default.products.single.product-specification-table :product="$product">
                        </x-default.products.single.product-specification-table>
                    </div>
                </div>
            </div>

            <div class="md:col-span-5 mt-12">
                {{-- Comments --}}
                <h3 class="text-lg font-bold mb-3">
                    {{ translate('Comments and Questions') }} ({{ $product->comments->count() }})
                </h3>
                <livewire:actions.social-comments :item="$product">
                </livewire:actions.social-comments>
            </div>

        </div>
    </div>
</div>

{{-- <div class="bg-gray-100">
    <div class="container  mt-[200px]">
        <x-default.products.recently-viewed-products class="p-3"></x-default.products.recently-viewed-products>
    </div>
</div> --}}



@endsection
