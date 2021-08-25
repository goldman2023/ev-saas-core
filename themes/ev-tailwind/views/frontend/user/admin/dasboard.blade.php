@extends('frontend.layouts.app')

@section('content')
    <!--
                                              This example requires Tailwind CSS v2.0+

                                              This example requires some changes to your config:

                                              ```
                                              // tailwind.config.js
                                              const colors = require('tailwindcss/colors')

                                              module.exports = {
                                                // ...
                                                theme: {
                                                  extend: {
                                                    colors: {
                                                      sky: colors.sky,
                                                      teal: colors.teal,
                                                      cyan: colors.cyan,
                                                      rose: colors.rose,
                                                    },
                                                  },
                                                },
                                                plugins: [
                                                  // ...
                                                  require('@tailwindcss/forms'),
                                                  require('@tailwindcss/line-clamp'),
                                                ],
                                              }
                                              ```
                                            -->
    <div class="relative min-h-screen bg-gray-100">
        <main class="pt-10 pb-8">
            <div class="max-w-xl"></div>
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:max-w-7xl lg:px-8">
                <h1 class="sr-only">Profile</h1>
                <!-- Main 3 column grid -->
                <div class="grid grid-cols-1 gap-4 items-start lg:grid-cols-4 lg:gap-8">
                    <div class="grid grid-cols-1 gap-1">
                        <x-tenant.dashboard.user-menu></x-tenant.dashboard.user-menu>
                    </div>

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
                                                <img class="mx-auto h-20 w-20 rounded-full"
                                                    src="https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                                    alt="">
                                            </div>
                                            <div class="mt-4 text-center sm:mt-0 sm:pt-1 sm:text-left">
                                                <p class="text-sm font-medium text-gray-600">
                                                    {{ translate('Welcome to your Business, ') }}</p>
                                                <p class="text-xl font-bold text-gray-900 sm:text-2xl">
                                                    {{ get_site_name() }}</p>
                                                <p class="text-sm font-medium text-gray-600">EV SaaS Premium</p>
                                            </div>
                                        </div>
                                        <div class="mt-5 flex justify-center sm:mt-0">
                                            <a href="#"
                                                class="flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                                {{ translate('View Notifications') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="border-t border-gray-200 bg-gray-50 grid grid-cols-1 divide-y divide-gray-200 sm:grid-cols-3 sm:divide-y-0 sm:divide-x">
                                    <div class="px-6 py-5 text-sm font-medium text-center">
                                        <a href="{{ route('ev-products.index') }}">
                                            <span class="text-gray-900"> {{ App\Models\Product::count() }}</span>
                                            <span class="text-gray-600">{{ translate('Products') }}</span>
                                        </a>
                                    </div>

                                    <div class="px-6 py-5 text-sm font-medium text-center">
                                        <span class="text-gray-900">{{ App\Models\Brand::count() }}</span>
                                        <span class="text-gray-600">{{ translate('Brands') }}</span>
                                    </div>

                                    <div class="px-6 py-5 text-sm font-medium text-center">
                                        <span class="text-gray-900">{{ App\Models\Category::count() }}</span>
                                        <span class="text-gray-600">{{ translate('Category') }}</span>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- Actions panel -->
                        <section aria-labelledby="quick-links-title">
                            <div
                                class="rounded-lg bg-gray-200 overflow-hidden shadow divide-y divide-gray-200 sm:divide-y-0 sm:grid sm:grid-cols-2 sm:gap-px">
                                <h2 class="sr-only" id="quick-links-title">{{ translate('Quick links') }}</h2>


                                <x-tenant.dashboard.dashboard-card
                                    class="sm:rounded-tr-l rounded-tl-lg sm:rounded-tr-none relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-cyan-500">
                                    <x-slot name="title">
                                        <a href="{{ route('admin.dashboard') }}">
                                            <span class="absolute inset-0" aria-hidden="true"></span>

                                            {{ translate('Manage Your Website') }}
                                        </a>
                                    </x-slot>

                                    <x-slot name="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                        </svg>
                                    </x-slot>
                                    <a href="{{ route('admin.dashboard') }}">
                                        {{ translate('Go To Admin Panel') }}
                                    </a>

                                </x-tenant.dashboard.dashboard-card>

                                <x-tenant.dashboard.dashboard-card
                                    class="rounded-tl-lg rounded-tr-lg sm:rounded-tr-none relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-cyan-500">
                                    <x-slot name="title">
                                        <a href="{{ route('ev-products.index') }}">
                                            {{ translate('Add Product') }}
                                        </a>
                                    </x-slot>

                                    <x-slot name="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                    </x-slot>
                                    {{ translate('Update your Products and Catalog') }}
                                    <a href="{{ route('ev-products.index') }}">
                                        {{ translate('Go To Admin Panel') }}
                                    </a>
                                </x-tenant.dashboard.dashboard-card>

                                <x-tenant.dashboard.dashboard-card
                                    class="sm:rounded-tr-l rounded-tl-lg sm:rounded-tr-none relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-cyan-500">
                                    <x-slot name="title">
                                        <a href="{{ get_setting('website_analytics_url') }}">
                                            <span class="absolute inset-0" aria-hidden="true"></span>

                                            {{ translate('Website Visitors') }}
                                        </a>
                                    </x-slot>

                                    <x-slot name="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                        </svg>
                                    </x-slot>


                                    <a href="{{ get_setting('website_analytics_url') }}">
                                        {{ translate('Go To Google Analytics Panel') }}
                                    </a>

                                </x-tenant.dashboard.dashboard-card>


                                <x-tenant.dashboard.dashboard-card
                                    class="sm:rounded-tr-l rounded-tl-lg sm:rounded-tr-none relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-cyan-500">
                                    <x-slot name="title">
                                        <a href="{{ get_setting('website_email_url') }}">
                                            <span class="absolute inset-0" aria-hidden="true"></span>

                                            {{ translate('Email Access') }}
                                        </a>
                                    </x-slot>

                                    <x-slot name="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76" />
                                        </svg>
                                    </x-slot>
                                    <a href="{{ get_setting('website_email_url') }}">
                                        {{ translate('Go To Website Email Login') }}
                                    </a>

                                </x-tenant.dashboard.dashboard-card>




                            </div>
                        </section>
                    </div>

                    <!-- Right column -->
                    <div class="grid grid-cols-1 gap-4">
                        <!-- Announcements -->
                        <section aria-labelledby="announcements-title">
                            <div class="rounded-lg bg-white overflow-hidden shadow">
                                <div class="p-6">
                                    <h2 class="text-base font-medium text-gray-900" id="announcements-title">Announcements
                                    </h2>
                                    <div class="flow-root mt-6">
                                        <ul role="list" class="-my-5 divide-y divide-gray-200">
                                            <li class="py-5">
                                                <div class="relative focus-within:ring-2 focus-within:ring-cyan-500">
                                                    <h3 class="text-sm font-semibold text-gray-800">
                                                        <a href="#" class="hover:underline focus:outline-none">
                                                            <!-- Extend touch target to entire panel -->
                                                            <span class="absolute inset-0" aria-hidden="true"></span>
                                                            Office closed on July 2nd
                                                        </a>
                                                    </h3>
                                                    <p class="mt-1 text-sm text-gray-600 line-clamp-2">
                                                        Cum qui rem deleniti. Suscipit in dolor veritatis sequi aut. Vero ut
                                                        earum quis deleniti. Ut a sunt eum cum ut repudiandae possimus.
                                                        Nihil ex tempora neque cum consectetur dolores.
                                                    </p>
                                                </div>
                                            </li>

                                            <li class="py-5">
                                                <div class="relative focus-within:ring-2 focus-within:ring-cyan-500">
                                                    <h3 class="text-sm font-semibold text-gray-800">
                                                        <a href="#" class="hover:underline focus:outline-none">
                                                            <!-- Extend touch target to entire panel -->
                                                            <span class="absolute inset-0" aria-hidden="true"></span>
                                                            New password policy
                                                        </a>
                                                    </h3>
                                                    <p class="mt-1 text-sm text-gray-600 line-clamp-2">
                                                        Alias inventore ut autem optio voluptas et repellendus. Facere totam
                                                        quaerat quam quo laudantium cumque eaque excepturi vel. Accusamus
                                                        maxime ipsam reprehenderit rerum id repellendus rerum. Culpa cum vel
                                                        natus. Est sit autem mollitia.
                                                    </p>
                                                </div>
                                            </li>

                                            <li class="py-5">
                                                <div class="relative focus-within:ring-2 focus-within:ring-cyan-500">
                                                    <h3 class="text-sm font-semibold text-gray-800">
                                                        <a href="#" class="hover:underline focus:outline-none">
                                                            <!-- Extend touch target to entire panel -->
                                                            <span class="absolute inset-0" aria-hidden="true"></span>
                                                            Office closed on July 2nd
                                                        </a>
                                                    </h3>
                                                    <p class="mt-1 text-sm text-gray-600 line-clamp-2">
                                                        Tenetur libero voluptatem rerum occaecati qui est molestiae
                                                        exercitationem. Voluptate quisquam iure assumenda consequatur ex et
                                                        recusandae. Alias consectetur voluptatibus. Accusamus a ab dicta et.
                                                        Consequatur quis dignissimos voluptatem nisi.
                                                    </p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="mt-6">
                                        <a href="#"
                                            class="w-full flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                            View all
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- Recent Hires -->
                        <section aria-labelledby="recent-hires-title">
                            <div class="rounded-lg bg-white overflow-hidden shadow">
                                <div class="p-6">
                                    <h2 class="text-base font-medium text-gray-900" id="recent-hires-title">
                                        {{ translate('Recent Customers') }}
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
                                                        <p class="text-sm font-medium text-gray-900 truncate">
                                                            Leonard Krasner
                                                        </p>
                                                        <p class="text-sm text-gray-500 truncate">
                                                            @leonardkrasner
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <a href="#"
                                                            class="inline-flex items-center shadow-sm px-2.5 py-0.5 border border-gray-300 text-sm leading-5 font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50">
                                                            View
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>

                                            <li class="py-4">
                                                <div class="flex items-center space-x-4">
                                                    <div class="flex-shrink-0">
                                                        <img class="h-8 w-8 rounded-full"
                                                            src="https://images.unsplash.com/photo-1463453091185-61582044d556?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                                            alt="">
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-sm font-medium text-gray-900 truncate">
                                                            Floyd Miles
                                                        </p>
                                                        <p class="text-sm text-gray-500 truncate">
                                                            @floydmiles
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <a href="#"
                                                            class="inline-flex items-center shadow-sm px-2.5 py-0.5 border border-gray-300 text-sm leading-5 font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50">
                                                            View
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>

                                            <li class="py-4">
                                                <div class="flex items-center space-x-4">
                                                    <div class="flex-shrink-0">
                                                        <img class="h-8 w-8 rounded-full"
                                                            src="https://images.unsplash.com/photo-1502685104226-ee32379fefbe?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                                            alt="">
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-sm font-medium text-gray-900 truncate">
                                                            Emily Selman
                                                        </p>
                                                        <p class="text-sm text-gray-500 truncate">
                                                            @emilyselman
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <a href="#"
                                                            class="inline-flex items-center shadow-sm px-2.5 py-0.5 border border-gray-300 text-sm leading-5 font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50">
                                                            View
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>

                                            <li class="py-4">
                                                <div class="flex items-center space-x-4">
                                                    <div class="flex-shrink-0">
                                                        <img class="h-8 w-8 rounded-full"
                                                            src="https://images.unsplash.com/photo-1500917293891-ef795e70e1f6?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                                            alt="">
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-sm font-medium text-gray-900 truncate">
                                                            Kristin Watson
                                                        </p>
                                                        <p class="text-sm text-gray-500 truncate">
                                                            @kristinwatson
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <a href="#"
                                                            class="inline-flex items-center shadow-sm px-2.5 py-0.5 border border-gray-300 text-sm leading-5 font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50">
                                                            View
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="mt-6">
                                        <a href="#"
                                            class="w-full flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                            View all
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection
