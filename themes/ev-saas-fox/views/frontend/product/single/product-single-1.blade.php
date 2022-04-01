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
                <x-galleries.main-gallery template="product-gallery" :model="$product" class=""></x-galleries.main-gallery>
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
                            @for($i = 0; $i < 4; $i++) 
                                @svg('heroicon-s-star', ['class' => 'text-warning h-5 w-5 flex-shrink-0'])
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

                    {{-- Card Sold By --}}
                    {{-- <div class="col-span-1 bg-white border border-gray-200 rounded-lg shadow divide-y divide-gray-200">
                        <div class="w-full flex items-center justify-between p-6 space-x-6">
                          <div class="flex-1 truncate">
                            <div class="flex items-center space-x-3">
                              <h3 class="text-gray-900 text-sm font-medium truncate">{{ $product->shop->name }}</h3>
                              <span class="flex-shrink-0 inline-block px-2 py-0.5 text-green-800 text-xs font-medium bg-green-100 rounded-full">Admin</span>
                            </div>
                            <p class="mt-1 text-gray-500 text-sm truncate">{{ $product->shop->email }}</p>
                          </div>
                          <img class="w-10 h-10 bg-gray-300 rounded-full flex-shrink-0" src="{{ $product->shop->getThumbnail(['w' => '100']) }}" alt="">
                        </div>
                        <div>
                          <div class="-mt-px flex divide-x divide-gray-200">
                            <div class="w-0 flex-1 flex">
                              <a href="mailto:janecooper@example.com" class="relative -mr-px w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-bl-lg hover:text-gray-500">
                                <!-- Heroicon name: solid/mail -->
                                <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                  <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                  <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                                <span class="ml-3">Email</span>
                              </a>
                            </div>
                            <div class="-ml-px w-0 flex-1 flex">
                              <a href="tel:+1-202-555-0170" class="relative w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-br-lg hover:text-gray-500">
                                <!-- Heroicon name: solid/phone -->
                                @svg('heroicon-s-phone', ['class' => 'w-5 h-5 text-gray-400'])
                                <span class="ml-3">
                                    {{ translate('Message seller') }}
                                </span>
                              </a>
                            </div>
                          </div>
                        </div>
                    </div> --}}

                    <div class="flex items-center">
                        <div class="grow flex items-center">
                            <span class="mr-2 text-gray-900 font-semibold">{{ translate('Sold by') }}:</span>
                            <span class="mr-1">
                                <img src="{{ $product->shop->getThumbnail(['w' => '100']) }}" class="w-7 h-7 rounded" />
                            </span>
                            <span class="text-gray-800">{{ $product->shop->name }}</span>
                        </div>
                        <div class="shrink-0">
                            <button type="button" class="btn-primary">
                                @svg('heroicon-o-chat-alt-2', ['class' => 'w-4 h-4 mr-2'])
                                {{ translate('Message seller') }}
                            </button>
                        </div>
                    </div>
        
                    <div class="flex items-center mt-4">
                        <div class="grow flex items-center">
                            <span class="mr-2 text-gray-900 font-semibold">{{ translate('Share') }}:</span>
                            
                            {{-- Social share --}}
                            <div class="mr-2">
                                <a href="#"
                                    class="flex items-center justify-center w-6 h-6 text-gray-400 hover:text-gray-500">
                                    <span class="sr-only">Share on Facebook</span>
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M20 10c0-5.523-4.477-10-10-10S0 4.477 0 10c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V10h2.54V7.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V10h2.773l-.443 2.89h-2.33v6.988C16.343 19.128 20 14.991 20 10z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </div>
                            <div class="mr-2">
                                <a href="#"
                                    class="flex items-center justify-center w-6 h-6 text-gray-400 hover:text-gray-500">
                                    <span class="sr-only">Share on Instagram</span>
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </div>
                            <div>
                                <a href="#"
                                    class="flex items-center justify-center w-6 h-6 text-gray-400 hover:text-gray-500">
                                    <span class="sr-only">Share on Twitter</span>
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                        <path
                                            d="M6.29 18.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0020 3.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.073 4.073 0 01.8 7.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 010 16.407a11.616 11.616 0 006.29 1.84" />
                                    </svg>
                                </a>
                            </div>
                            {{-- END Social share --}}

        
                        </div>
                    </div>
                </div>    
            </div>

            <div class="w-full mt-16 lg:max-w-none lg:mt-0 lg:col-span-8 mb-10">
                <div x-data="{
                        current: 'description'
                    }">
                    <div class="sm:hidden">
                        <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
                        <select id="tabs" name="tabs" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option>My Account</option>
                            <option>Company</option>
                            <option>Team Members</option>
                            <option>Billing</option>
                        </select>
                    </div>
                    <div class="hidden sm:block">
                        <div class="border-b border-gray-200">
                            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                                <div @click="current = 'description';" :class="{'text-primary border-primary ': current == 'description'}" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-18 cursor-pointer"> {{ translate('Description') }} </div>
                                <div @click="current = 'specification';" :class="{'text-primary border-primary ': current == 'specification'}" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-18 cursor-pointer"> {{ translate('Specification') }} </div>
                                <div @click="current = 'shipping';" :class="{'text-primary border-primary ': current == 'shipping'}" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-18 cursor-pointer" aria-current="page"> {{ translate('Shipping') }} </div>
                                <div @click="current = 'returns';" :class="{'text-primary border-primary ': current == 'returns'}" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-18 cursor-pointer"> {{ translate('Returns and buyers protections') }} </div>
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
