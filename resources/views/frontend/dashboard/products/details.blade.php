@extends('frontend.layouts.user_panel')

@section('page_title', translate('All Products'))

@section('panel_content')

<div class="min-h-full">

    <main class="pb-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:max-w-7xl lg:px-0">
            <h1 class="sr-only">Profile</h1>
            <!-- Main 3 column grid -->
            <div class="grid grid-cols-1 gap-4 items-start lg:grid-cols-3 lg:gap-8">
                <!-- Left column -->
                <div class="grid grid-cols-1 gap-4 lg:col-span-2">
                    <!-- Welcome panel -->
                    <section aria-labelledby="profile-overview-title">
                        <div class="rounded-lg bg-white overflow-hidden shadow">
                            <h2 class="sr-only" id="profile-overview-title">Profile Overview</h2>
                            <div class="bg-white p-6">
                                <div class="sm:flex sm:items-center sm:justify-between">
                                    <div class="sm:flex sm:space-x-5">
                                        <div class="flex-shrink-0">
                                            <img class="object-contain bg-white mx-auto h-20 w-20 rounded-full"
                                                src="{{ $product->getThumbnail() }}" alt="{{ $product->name }} image">
                                        </div>
                                        <div class="mt-4 text-center sm:mt-0 sm:pt-1 sm:text-left">
                                            <p class="text-xl font-bold text-gray-900 sm:text-2xl mb-3">
                                                {{ $product->name }}
                                            </p>
                                            <div class="text-sm font-medium text-gray-600">
                                                {{-- TODO: Add expandable view all +some categories total --}}
                                                <div class="text-clip overflow-hidden max-h-[30px]">
                                                    @foreach($product->categories()->get() as $category)
                                                    <a target="_blank" href="{{ $category->getPermalink() }}"
                                                        class="inline-flex items-center px-3 mb-2 py-0.5 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                                        {{ $category->name }}
                                                    </a>
                                                    @endforeach
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-5 flex justify-center sm:mt-0">
                                        <div class="text-center">
                                            <a href="{{ $product->getPermalink() }}" target="_blank"
                                                class="min-w-[200px] flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-200 bg-indigo-600 hover:bg-gray-50">

                                                {{ translate('View') }} {{ translate('product') }}
                                                <svg class="gray-600 flex-shrink-0 h-6 w-6 ml-2"
                                                    xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>

                                            <div>
                                                <span
                                                    class="mt-3 mx-auto text-center inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                                                    <svg class="-ml-1 mr-1.5 h-2 w-2 text-indigo-400"
                                                        fill="currentColor" viewBox="0 0 8 8">
                                                        <circle cx="4" cy="4" r="3" />
                                                    </svg>
                                                    {{ $product->status }}
                                                </span>
                                            </div>
                                        </div>



                                    </div>
                                </div>
                            </div>
                            <div
                                class="border-t border-gray-200 bg-gray-50 grid grid-cols-1 divide-y divide-gray-200 sm:grid-cols-3 sm:divide-y-0 sm:divide-x">
                                <div class="px-6 py-5 text-sm font-medium text-center">
                                    <span class="text-gray-900">
                                        {{ $product->public_view_count() }}
                                    </span>
                                    <span class="text-gray-600">
                                        {{ translate('Total views') }}
                                    </span>
                                </div>

                                <div class="px-6 py-5 text-sm font-medium text-center">
                                    <span class="text-gray-900">
                                        {{ $product->getBasePrice(true) }}
                                    </span>
                                    <span class="text-gray-600">{{ translate('Price') }}</span>
                                </div>

                                <div class="px-6 py-5 text-sm font-medium text-center">
                                    <span class="text-gray-900">{{ $product->getCurrentStockAttribute() }}</span>
                                    <span class="text-gray-600">{{ translate('Current Stock') }}</span>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Actions panel -->
                    <section aria-labelledby="quick-links-title">
                        <div
                            class="rounded-lg bg-gray-200 overflow-hidden shadow divide-y divide-gray-200 sm:divide-y-0 sm:grid sm:grid-cols-2 sm:gap-px">
                            <h2 class="sr-only" id="quick-links-title">Quick links</h2>

                            <div
                                class="relative min-h-[200px] rounded-tl-lg rounded-tr-lg sm:rounded-tr-none relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-cyan-500">
                                <div>
                                    <span class="rounded-lg inline-flex p-3 bg-teal-50 text-teal-700 ring-4 ring-white">
                                        <!-- Heroicon name: outline/clock -->

                                        @svg('heroicon-o-eye', ['class' => 'h-6 w-6'])
                                    </span>
                                </div>
                                <div class="mt-8 ">
                                    <h3 class="text-lg font-medium">

                                        <a href="{{ route('product.single', $product->slug) }}" target="_blank" class="focus:outline-none">
                                            <!-- Extend touch target to entire panel -->
                                            <span class="absolute inset-0" aria-hidden="true"></span>
                                            {{ translate('Product Preview') }}
                                        </a>
                                    </h3>
                                      {{-- TODO: Create product preview for tailwind --}}
                                      {{-- <div class="absolute top-0 left-0 w-full h-full">
                                        <div class="p-6 px-20">
                                            <x-default.products.cards.product-card :product="$product">
                                            </x-default.products.cards.product-card>
                                        </div>

                                      </div> --}}

                                    <p class="mt-2 text-sm text-gray-500">
                                        {{ translate('View your product as a customer and share it with the world!') }}
                                    </p>
                                </div>
                                <span
                                    class="pointer-events-none absolute top-6 right-6 text-gray-300 group-hover:text-gray-400"
                                    aria-hidden="true">
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z" />
                                    </svg>
                                </span>
                            </div>
                            <div
                                class="rounded-tl-lg rounded-tr-lg sm:rounded-tr-none relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-cyan-500">
                                <a class="btn btn-soft-info btn-circle btn-xs d-inline-flex align-items-center"
                                    href="{{ route('product.single', $product->slug) }}" target="_blank">
                                    @svg('heroicon-o-eye', ['style' => 'height: 16px;', 'class' => 'mr-2'])
                                    {{ translate('Preview') }}
                                </a>

                                <a class="btn btn-soft-info btn-circle btn-xs d-inline-flex align-items-center"
                                    href="{{ route('product.edit.stocks', $product->id) }}">
                                    @svg('heroicon-o-archive', ['style' => 'height: 16px;', 'class' => 'mr-2'])
                                    {{ translate('Stock Management') }}
                                </a>

                                <a class="btn btn-soft-info btn-circle btn-xs d-inline-flex align-items-center"
                                href="{{ route('product.edit.course', $product->id) }}">
                                @svg('heroicon-o-archive', ['style' => 'height: 16px;', 'class' => 'mr-2'])
                                {{ translate('Course Material') }}
                                </a>

                                @if($product->useVariations())
                                <a class="btn btn-soft-info btn-circle btn-xs d-inline-flex align-items-center"
                                    href="{{ route('product.edit.variations', $product->id) }}">
                                    @svg('heroicon-o-variable', ['style' => 'height: 16px;', 'class' => 'mr-2'])
                                    {{ translate('Variations') }}
                                </a>
                                @endif

                                <a class="btn btn-soft-info btn-circle btn-xs d-inline-flex align-items-center"
                                    href="{{ route('product.edit', $product->id) }}">
                                    {{ translate('Edit') }} @svg('heroicon-o-pencil-alt', ['style' => 'height: 16px;',
                                    'class' => 'ml-2'])
                                </a>

                                <a class="btn btn-soft-info btn-circle btn-xs d-inline-flex align-items-center"
                                    href="{{ route('product.activity', $product->id) }}">
                                    {{ translate('Activity') }} @svg('heroicon-o-pencil-alt', ['style' => 'height:
                                    16px;', 'class' => 'ml-2'])
                                </a>

                                <a class="btn btn-soft-danger btn-circle btn-xs d-inline-flex align-items-center confirm-delete "
                                    href="javascript:void(0)">
                                    {{ translate('Delete') }} @svg('heroicon-o-trash', ['style' => 'height: 16px;',
                                    'class' => 'ml-2'])
                                </a>
                            </div>



                        </div>
                        <div class="mt-6">
                            <div class="rounded-lg bg-white overflow-hidden shadow">
                                <div class="p-6 relative">
                                    <h3 class="text-base font-medium text-gray-900 relative">
                                        {{ translate('Product Activity') }}


                                    </h3>
                                    {{-- Live data badge --}}
                                    <div class="absolute right-6 top-6">

                                        <span
                                            class="relative inline-flex font-bold items-center px-3 py-0.5 rounded-full text-sm font-medium bg-red-100 text-red-500">
                                            <span
                                                class="animate-ping inline-flex h-1.5 w-1.5 mr-3 rounded-full bg-red-900 opacity-100"></span>

                                            {{ translate('Live') }}
                                        </span>
                                    </div>
                                    {{-- Live data badge end --}}

                                    <livewire:product-activity :product="$product" />
                                </div>
                            </div>
                        </div>

                    </section>
                </div>

                <!-- Right column -->
                <div class="grid grid-cols-1 gap-4">
                    <!-- Announcements -->
                    <section aria-labelledby="announcements-title">
                        <div class="rounded-lg bg-white overflow-hidden shadow">
                            <div class="p-6">
                                <h2 class="text-base font-medium text-gray-900" id="announcements-title">
                                    {{ translate('Social eCommerce Channels') }}
                                </h2>
                                <div class="flow-root mt-6">
                                    <ul role="list" class="-my-5 divide-y divide-gray-200">
                                        <li class="py-5">
                                            <div class="relatives">
                                                <h3 class="text-sm font-semibold text-gray-800">
                                                    <div class="flex flex-col">
                                                        {{-- Stripe icon --}}
                                                        {{-- TODO: Create global components for icons like this custom
                                                        brand images mostly --}}
                                                        <svg class="w-16" viewBox="0 0 452 188"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink">
                                                            <title>Logo</title>
                                                            <defs>
                                                                <path id="a" d="M.06.667h451.623V188H.06V.667z" />
                                                            </defs>
                                                            <g fill="none" fill-rule="evenodd">
                                                                <mask id="b" fill="#fff">
                                                                    <use xlink:href="#a" />
                                                                </mask>
                                                                <path
                                                                    d="M47.2 84.934c-9.733-3.6-15.067-6.4-15.067-10.8 0-3.734 3.067-5.867 8.534-5.867 10 0 20.266 3.867 27.333 7.333l4-24.666c-5.6-2.667-17.067-7.067-32.933-7.067-11.2 0-20.534 2.933-27.2 8.4-6.934 5.733-10.534 14-10.534 24 0 18.133 11.067 25.867 29.067 32.4 11.6 4.133 15.467 7.067 15.467 11.6 0 4.4-3.734 6.933-10.534 6.933-8.4 0-22.266-4.133-31.333-9.466l-4 24.933c7.733 4.4 22.133 8.933 37.067 8.933 11.866 0 21.733-2.8 28.4-8.133C72.933 137.6 76.8 128.934 76.8 117.734c0-18.534-11.333-26.267-29.6-32.8zM141.917 70.4l4-24.533H124.8V16.085l-28.392 4.672-4.1 25.11-9.986 1.62L78.584 70.4h13.683v48.134c0 12.533 3.2 21.2 9.733 26.533 5.467 4.4 13.333 6.533 24.4 6.533 8.533 0 13.733-1.466 17.333-2.4v-26c-2 .534-6.533 1.467-9.6 1.467-6.533 0-9.333-3.333-9.333-10.933V70.4h17.117zm63.416-25.966c-9.333 0-16.8 4.9-19.733 13.7l-2-12.267h-28.933V149.6h33.066V82.267c4.134-5.067 10-6.899 18-6.899 1.734 0 3.6 0 5.867.4V45.234c-2.267-.533-4.267-.8-6.267-.8zm30.934-8.834c9.6 0 17.333-7.866 17.333-17.466C253.6 8.4 245.867.667 236.267.667 226.533.667 218.8 8.4 218.8 18.134c0 9.6 7.733 17.466 17.467 17.466zM219.6 45.867h33.2V149.6h-33.2V45.867zM346.883 55.2c-5.867-7.6-14-11.333-24.4-11.333-9.6 0-18 4-25.867 12.4l-1.733-10.4h-29.067V188l33.067-5.466V149.2c5.066 1.6 10.266 2.4 14.933 2.4 8.267 0 20.267-2.133 29.6-12.266 8.933-9.734 13.467-24.8 13.467-44.667 0-17.6-3.334-30.933-10-39.467zm-27.467 64c-2.667 5.067-6.8 7.734-11.6 7.734-3.333 0-6.267-.667-8.933-2V75.6c5.6-5.866 10.666-6.533 12.533-6.533 8.4 0 12.533 9.067 12.533 26.8 0 10.133-1.466 18-4.533 23.333zm132.267-22.4c0-16.533-3.6-29.6-10.667-38.8-7.2-9.333-18-14.133-31.733-14.133-28.134 0-45.6 20.8-45.6 54.133 0 18.667 4.666 32.667 13.866 41.6 8.267 8 20.134 12 35.467 12 14.133 0 27.2-3.333 35.467-8.8l-3.6-22.666c-8.134 4.4-17.6 6.8-28.267 6.8-6.4 0-10.8-1.334-14-4.134-3.467-2.933-5.467-7.733-6.133-14.533h54.8c.133-1.6.4-9.067.4-11.467zM396.216 88c.933-14.8 4.933-21.733 12.533-21.733 7.467 0 11.334 7.067 11.867 21.733h-24.4z"
                                                                    fill="#1A1918" mask="url(#b)" />
                                                            </g>
                                                        </svg>
                                                        @if($product->isStripeProduct())
                                                            <span
                                                                class="mt-3 mr-auto mb-3 inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                                                <svg class="-ml-1 mr-1.5 h-2 w-2 text-green-400"
                                                                    fill="currentColor" viewBox="0 0 8 8">
                                                                    <circle cx="4" cy="4" r="3" />
                                                                </svg>
                                                                {{ translate('Status live') }}
                                                            </span>

                                                            @if(!empty($stripe_product_id = $product->getStripeProductID()))
                                                                <div class="flex mb-1">
                                                                    <span class="font-medium mr-1">{{ translate('Product ID') }}:</span>
                                                                    <a href="{{ '#' }}" target="_blank" class="text-info">{{ $stripe_product_id }}</a>
                                                                </div>
                                                            @endif

                                                            @if(!empty($stripe_price_id = $product->getStripePriceID()))
                                                                <div class="flex">
                                                                    <span class="font-medium mr-1">{{ translate('Price ID') }}:</span>
                                                                    <a href="{{ '#' }}" target="_blank" class="text-info">{{ $stripe_price_id }}</a>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </h3>
                                                <p class="mt-1 text-sm text-gray-600 line-clamp-2 mb-2">
                                                    {{ translate('Use stripe checkout for all your product invoicing and
                                                    checkout needs. Create QR codes and payment links') }}
                                                </p>

                                                <a target="_blank"
                                                    href="{{ $product->getStripeCheckoutPermalink(qty: 1, preview: true) }}"
                                                    class="inline-flex items-center px-3 py-2 border border-transparent shadow-sm text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    {{ translate('Peview checkout') }}
                                                    @svg('heroicon-s-mail', ['class' => 'w-6 h-6 ml-2'])
                                                </a>

                                                <a target="_blank"
                                                    href="{{ route('product.thank_you_preview', ['id' => $product->id]) }}"
                                                    class="inline-flex items-center px-3 py-2 border border-transparent shadow-sm text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    {{ translate('Peview order') }}
                                                    @svg('heroicon-s-document', ['class' => 'w-6 h-6 ml-2'])
                                                </a>
                                            </div>
                                        </li>



                                        <li class="py-5">
                                            <div class="relative focus-within:ring-2 focus-within:ring-cyan-500">
                                                <h3 class="text-sm font-semibold text-gray-800">
                                                    <a href="#" class="hover:underline focus:outline-none">
                                                        <img class="h-8 mb-3"
                                                            src="https://upload.wikimedia.org/wikipedia/commons/2/2a/WooCommerce_logo.svg" />
                                                        <!-- Extend touch target to entire panel -->
                                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                                        WooCommerce
                                                    </a>

                                                    <span
                                                        class="mt-3 inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                                                        <svg class="-ml-1 mr-1.5 h-2 w-2 text-indigo-400"
                                                            fill="currentColor" viewBox="0 0 8 8">
                                                            <circle cx="4" cy="4" r="3" />
                                                        </svg>
                                                        {{ translate('Step: 1/3 Setup WooCommerce Keys') }}
                                                    </span>
                                                </h3>
                                                <p class="mt-1 text-sm text-gray-600 line-clamp-2 mb-2">
                                                    {{ translate('Sync your stock and product information with
                                                    WooCommerce via REST API')}}
                                                </p>

                                                <a type="button" target="_blank" href="{{ route('settings.app_settings') }}"
                                                    class="inline-flex items-center px-2 py-1 border border-transparent shadow-sm text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    {{ translate('Setup API keys') }}
                                                    <!-- Heroicon name: solid/mail -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 ml-2" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </li>


                                        <li class="py-5">
                                            <div class="relative focus-within:ring-2 focus-within:ring-cyan-500">
                                                <h3 class="text-sm font-semibold text-gray-800">
                                                    <a href="#" class="hover:underline focus:outline-none">
                                                        <!-- Extend touch target to entire panel -->
                                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                                        <img class="h-5 mb-3"
                                                            src="https://upload.wikimedia.org/wikipedia/commons/7/7b/Meta_Platforms_Inc._logo.svg" />
                                                        Facebook Business Manager
                                                    </a>
                                                </h3>
                                                <span
                                                    class="mt-3 inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                                                    <svg class="-ml-1 mr-1.5 h-2 w-2 text-indigo-400"
                                                        fill="currentColor" viewBox="0 0 8 8">
                                                        <circle cx="4" cy="4" r="3" />
                                                    </svg>
                                                    {{ translate('Coming soon!') }}
                                                </span>
                                                <p class="mt-1 text-sm text-gray-600 line-clamp-2">Cum qui rem deleniti.
                                                    Suscipit in dolor veritatis sequi aut. Vero ut earum quis deleniti.
                                                    Ut a sunt eum cum ut repudiandae possimus. Nihil ex tempora neque
                                                    cum consectetur dolores.</p>
                                            </div>
                                        </li>

                                    </ul>
                                </div>
                                <div class="mt-6">
                                    <a href="#"
                                        class="w-full flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                        View all </a>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Recent Hires -->
                    <section aria-labelledby="recent-hires-title">
                        <div class="rounded-lg bg-white overflow-hidden shadow">
                            <div class="p-6">
                                <h2 class="text-base font-medium text-gray-900" id="recent-hires-title">
                                    {{ translate('Recent orders') }}
                                </h2>
                                <div class="flow-root mt-6">
                                    <ul role="list" class="-my-5 divide-y divide-gray-200">
                                        <li class="py-4">
                                            <div class="flex items-center space-x-4">
                                                <div class="flex-shrink-0">
                                                    <img class="h-8 w-8 rounded-full"
                                                        src="https://images.unsplash.com/photo-1519345182560-3f2917c472ef?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                                        alt="">
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-gray-900 truncate">Leonard
                                                        Krasner</p>
                                                    <p class="text-sm text-gray-500 truncate">via Stripe</p>
                                                </div>
                                                <div>
                                                    <a href="#"
                                                        class="inline-flex items-center shadow-sm px-2.5 py-0.5 border border-gray-300 text-sm leading-5 font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50">
                                                        View </a>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="mt-6">
                                    <a href="#"
                                        class="w-full flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                        View all </a>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </main>

</div>


<div class="grid grid-cols-3 gap-5">
    <div>

    </div>

    <div>


    </div>

    <div>
        <!--Categories Card -->
        <div class="card h-100">
            <div class="card-body">
                <h6 class="font-weight-normal mb-1">{{ translate('Product Categories') }}:</h6>
                <h4 class="card-title">
                    @foreach($product->categories()->get() as $category)
                    <span class="badge badge-soft-primary p-2 mb-2">
                        {{ $category->name }}
                    </span>
                    @endforeach
                    {{-- Assign Categories button --}}
                    <div class="mt-3">
                        <small>
                            <a href="{{ route('product.edit', $product->id) }}" target="_blank">
                                {{ translate('+ Assign Categories') }} </a>
                        </small>
                    </div>
                </h4>
            </div>
        </div>
        <!-- End Card -->
    </div>
</div>



@endsection

@push('footer_scripts')

@endpush
