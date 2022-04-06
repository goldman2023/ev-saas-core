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
                                class="rounded-tl-lg rounded-tr-lg sm:rounded-tr-none relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-cyan-500">
                                <div>
                                    <span class="rounded-lg inline-flex p-3 bg-teal-50 text-teal-700 ring-4 ring-white">
                                        <!-- Heroicon name: outline/clock -->
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="mt-8">
                                    <h3 class="text-lg font-medium">

                                        <a href="#" class="focus:outline-none">
                                            <!-- Extend touch target to entire panel -->
                                            <span class="absolute inset-0" aria-hidden="true"></span>
                                            Request time off
                                        </a>
                                    </h3>
                                    <p class="mt-2 text-sm text-gray-500">Doloribus dolores nostrum quia qui natus
                                        officia quod et dolorem. Sit repellendus qui ut at blanditiis et quo et
                                        molestiae.</p>
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
                                    href="{{ route('product.edit.stocks', $product->slug) }}">
                                    @svg('heroicon-o-archive', ['style' => 'height: 16px;', 'class' => 'mr-2'])
                                    {{ translate('Stock Management') }}
                                </a>

                                @if($product->useVariations())
                                <a class="btn btn-soft-info btn-circle btn-xs d-inline-flex align-items-center"
                                    href="{{ route('product.edit.variations', $product->slug) }}">
                                    @svg('heroicon-o-variable', ['style' => 'height: 16px;', 'class' => 'mr-2'])
                                    {{ translate('Variations') }}
                                </a>
                                @endif

                                <a class="btn btn-soft-info btn-circle btn-xs d-inline-flex align-items-center"
                                    href="{{ route('product.edit', $product->slug) }}">
                                    {{ translate('Edit') }} @svg('heroicon-o-pencil-alt', ['style' => 'height: 16px;',
                                    'class' => 'ml-2'])
                                </a>

                                <a class="btn btn-soft-info btn-circle btn-xs d-inline-flex align-items-center"
                                    href="{{ route('product.activity', $product->slug) }}">
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
                                            <div class="relative focus-within:ring-2 focus-within:ring-cyan-500">
                                                <h3 class="text-sm font-semibold text-gray-800">
                                                    <a href="#" class="hover:underline focus:outline-none">
                                                        {{-- Stripe icon --}}
                                                        {{-- TODO: Create global components for icons like this custom
                                                        brand images mostly --}}
                                                        <svg class="w-10" viewBox="0 0 452 188"
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
                                                        <!-- Extend touch target to entire panel -->
                                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                                        @if(!$product->isStripeProduct())
                                                        <span
                                                            class="mt-3 inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                                                            <svg class="-ml-1 mr-1.5 h-2 w-2 text-indigo-400"
                                                                fill="currentColor" viewBox="0 0 8 8">
                                                                <circle cx="4" cy="4" r="3" />
                                                            </svg>
                                                            {{ translate('Status live') }}
                                                        </span>
                                                        @endif
                                                        <div class="hidden">
                                                            Stripe
                                                        </div>
                                                    </a>
                                                </h3>
                                                <p class="mt-1 text-sm text-gray-600 line-clamp-2 mb-2">
                                                    {{ translate('Use stripe checkout for all your product invoicing and
                                                    checkout needs. Create QR codes and payment links') }}
                                                </p>

                                                <!-- This example requires Tailwind CSS v2.0+ -->
                                                <a type="button"
                                                target="_blank"
                                                href="{{ \StripeService::createCheckoutLink($product) }}"
                                                    class="inline-flex items-center px-3 py-2 border border-transparent shadow-sm text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    {{ translate('Peview checkout') }}
                                                    <!-- Heroicon name: solid/mail -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
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

<svg xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:cc="http://creativecommons.org/ns#" width="948" height="191">
<defs>
<linearGradient id="Grad_Logo1" x1="61" y1="117" x2="259" y2="127" gradientUnits="userSpaceOnUse">
<stop style="stop-color:#0064e1" offset="0"/>
<stop style="stop-color:#0064e1" offset="0.4"/>
<stop style="stop-color:#0073ee" offset="0.83"/>
<stop style="stop-color:#0082fb" offset="1"/>
</linearGradient>
<linearGradient id="Grad_Logo2" x1="45" y1="139" x2="45" y2="66" gradientUnits="userSpaceOnUse">
<stop style="stop-color:#0082fb" offset="0"/>
<stop style="stop-color:#0064e0" offset="1"/>
</linearGradient>
</defs>
<path id="Logo0" style="fill:#0081fb" d="m31.06,125.96c0,10.98 2.41,19.41 5.56,24.51 4.13,6.68 10.29,9.51 16.57,9.51 8.1,0 15.51-2.01 29.79-21.76 11.44-15.83 24.92-38.05 33.99-51.98l15.36-23.6c10.67-16.39 23.02-34.61 37.18-46.96 11.56-10.08 24.03-15.68 36.58-15.68 21.07,0 41.14,12.21 56.5,35.11 16.81,25.08 24.97,56.67 24.97,89.27 0,19.38-3.82,33.62-10.32,44.87-6.28,10.88-18.52,21.75-39.11,21.75l0-31.02c17.63,0 22.03-16.2 22.03-34.74 0-26.42-6.16-55.74-19.73-76.69-9.63-14.86-22.11-23.94-35.84-23.94-14.85,0-26.8,11.2-40.23,31.17-7.14,10.61-14.47,23.54-22.7,38.13l-9.06,16.05c-18.2,32.27-22.81,39.62-31.91,51.75-15.95,21.24-29.57,29.29-47.5,29.29-21.27,0-34.72-9.21-43.05-23.09-6.8-11.31-10.14-26.15-10.14-43.06z"/>
<path id="Logo1" style="fill:url(#Grad_Logo1)" d="m24.49,37.3c14.24-21.95 34.79-37.3 58.36-37.3 13.65,0 27.22,4.04 41.39,15.61 15.5,12.65 32.02,33.48 52.63,67.81l7.39,12.32c17.84,29.72 27.99,45.01 33.93,52.22 7.64,9.26 12.99,12.02 19.94,12.02 17.63,0 22.03-16.2 22.03-34.74l27.4-.86c0,19.38-3.82,33.62-10.32,44.87-6.28,10.88-18.52,21.75-39.11,21.75-12.8,0-24.14-2.78-36.68-14.61-9.64-9.08-20.91-25.21-29.58-39.71l-25.79-43.08c-12.94-21.62-24.81-37.74-31.68-45.04-7.39-7.85-16.89-17.33-32.05-17.33-12.27,0-22.69,8.61-31.41,21.78z"/>
<path id="Logo2" style="fill:url(#Grad_Logo2)" d="m82.35,31.23c-12.27,0-22.69,8.61-31.41,21.78-12.33,18.61-19.88,46.33-19.88,72.95 0,10.98 2.41,19.41 5.56,24.51l-26.48,17.44c-6.8-11.31-10.14-26.15-10.14-43.06 0-30.75 8.44-62.8 24.49-87.55 14.24-21.95 34.79-37.3 58.36-37.3z"/>
<path id="Text" style="fill:#192830" d="m347.94,6.04h35.93l61.09,110.52 61.1-110.52h35.15v181.6h-29.31v-139.18l-53.58,96.38h-27.5l-53.57-96.38v139.18h-29.31z
m285.11,67.71c-21.02,0-33.68,15.82-36.71,35.41h71.34c-1.47-20.18-13.11-35.41-34.63-35.41z
m-65.77,46.57c0-41.22 26.64-71.22 66.28-71.22 38.99,0 62.27,29.62 62.27,73.42v8.05h-99.49c3.53,21.31 17.67,35.67 40.47,35.67 18.19,0 29.56-5.55 40.34-15.7l15.57,19.07c-14.67,13.49-33.33,21.27-56.95,21.27-42.91,0-68.49-31.29-68.49-70.56z
m164.09-43.97h-26.98v-24h26.98v-39.69h28.28v39.69h40.99v24h-40.99v60.83c0,20.77 6.64,28.15 22.96,28.15 7.45,0 11.72-.64 18.03-1.69v23.74c-7.86,2.22-15.36,3.24-23.48,3.24-30.53,0-45.79-16.68-45.79-50.07z
m188.35,23.34c-5.68-14.34-18.35-24.9-36.97-24.9-24.2,0-39.69,17.17-39.69,45.14 0,27.27 14.26,45.27 38.53,45.27 19.08,0 32.7-11.1 38.13-24.91z
m28.28,87.95h-27.76v-18.94c-7.76,11.15-21.88,22.18-44.75,22.18-36.78,0-61.36-30.79-61.36-70.95 0-40.54 25.17-70.83 62.92-70.83 18.66,0 33.3,7.46 43.19,20.63v-17.38h27.76z"/>
</svg>


                                                        Facebook Business Manager
                                                    </a>
                                                </h3>
                                                <p class="mt-1 text-sm text-gray-600 line-clamp-2">Cum qui rem deleniti.
                                                    Suscipit in dolor veritatis sequi aut. Vero ut earum quis deleniti.
                                                    Ut a sunt eum cum ut repudiandae possimus. Nihil ex tempora neque
                                                    cum consectetur dolores.</p>
                                            </div>
                                        </li>



                                        <li class="py-5">
                                            <div class="relative focus-within:ring-2 focus-within:ring-cyan-500">
                                                <h3 class="text-sm font-semibold text-gray-800">
                                                    <a href="#" class="hover:underline focus:outline-none">
                                                        <!-- Extend touch target to entire panel -->
                                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                                        Instagram Shop
                                                    </a>
                                                </h3>
                                                <p class="mt-1 text-sm text-gray-600 line-clamp-2">Tenetur libero
                                                    voluptatem rerum occaecati qui est molestiae exercitationem.
                                                    Voluptate quisquam iure assumenda consequatur ex et recusandae.
                                                    Alias consectetur voluptatibus. Accusamus a ab dicta et. Consequatur
                                                    quis dignissimos voluptatem nisi.</p>
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
        {{-- TODO: Create product preview for tailwind --}}
        <x-default.products.cards.product-card :product="$product">
        </x-default.products.cards.product-card>
    </div>

    <div>
        <div class="card">
            <h3>{{ translate('Product Activity') }} </h3>
            <livewire:product-activity :product="$product" />
        </div>

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
                            <a href="{{ route('product.edit', $product->slug) }}" target="_blank">
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
