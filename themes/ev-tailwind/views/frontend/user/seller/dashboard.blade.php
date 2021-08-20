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
                                                <img class="mx-auto h-20 w-20 rounded-full" src="https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                                            </div>
                                            <div class="mt-4 text-center sm:mt-0 sm:pt-1 sm:text-left">
                                                <p class="text-sm font-medium text-gray-600">Welcome back,</p>
                                                <p class="text-xl font-bold text-gray-900 sm:text-2xl">Chelsea Hagon</p>
                                                <p class="text-sm font-medium text-gray-600">Human Resources Manager</p>
                                            </div>
                                        </div>
                                        <div class="mt-5 flex justify-center sm:mt-0">
                                            <a href="#" class="flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                                View profile
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="border-t border-gray-200 bg-gray-50 grid grid-cols-1 divide-y divide-gray-200 sm:grid-cols-3 sm:divide-y-0 sm:divide-x">
                                    <div class="px-6 py-5 text-sm font-medium text-center">
                                        <span class="text-gray-900">12</span>
                                        <span class="text-gray-600">Vacation days left</span>
                                    </div>

                                    <div class="px-6 py-5 text-sm font-medium text-center">
                                        <span class="text-gray-900">4</span>
                                        <span class="text-gray-600">Sick days left</span>
                                    </div>

                                    <div class="px-6 py-5 text-sm font-medium text-center">
                                        <span class="text-gray-900">2</span>
                                        <span class="text-gray-600">Personal days left</span>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- Actions panel -->
                        <section aria-labelledby="quick-links-title">
                            <div class="rounded-lg bg-gray-200 overflow-hidden shadow divide-y divide-gray-200 sm:divide-y-0 sm:grid sm:grid-cols-2 sm:gap-px">
                                <h2 class="sr-only" id="quick-links-title">Quick links</h2>

                                <div class="rounded-tl-lg rounded-tr-lg sm:rounded-tr-none relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-cyan-500">
                                    <div>
                  <span class="rounded-lg inline-flex p-3 bg-teal-50 text-teal-700 ring-4 ring-white">
                    <!-- Heroicon name: outline/clock -->
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
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
                                        <p class="mt-2 text-sm text-gray-500">
                                            Doloribus dolores nostrum quia qui natus officia quod et dolorem. Sit repellendus qui ut at blanditiis et quo et molestiae.
                                        </p>
                                    </div>
                                    <span class="pointer-events-none absolute top-6 right-6 text-gray-300 group-hover:text-gray-400" aria-hidden="true">
                  <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z" />
                  </svg>
                </span>
                                </div>

                                <div class="sm:rounded-tr-lg relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-cyan-500">
                                    <div>
                  <span class="rounded-lg inline-flex p-3 bg-purple-50 text-purple-700 ring-4 ring-white">
                    <!-- Heroicon name: outline/badge-check -->
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                    </svg>
                  </span>
                                    </div>
                                    <div class="mt-8">
                                        <h3 class="text-lg font-medium">
                                            <a href="#" class="focus:outline-none">
                                                <!-- Extend touch target to entire panel -->
                                                <span class="absolute inset-0" aria-hidden="true"></span>
                                                Benefits
                                            </a>
                                        </h3>
                                        <p class="mt-2 text-sm text-gray-500">
                                            Doloribus dolores nostrum quia qui natus officia quod et dolorem. Sit repellendus qui ut at blanditiis et quo et molestiae.
                                        </p>
                                    </div>
                                    <span class="pointer-events-none absolute top-6 right-6 text-gray-300 group-hover:text-gray-400" aria-hidden="true">
                  <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z" />
                  </svg>
                </span>
                                </div>

                                <div class="relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-cyan-500">
                                    <div>
                  <span class="rounded-lg inline-flex p-3 bg-sky-50 text-sky-700 ring-4 ring-white">
                    <!-- Heroicon name: outline/users -->
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                  </span>
                                    </div>
                                    <div class="mt-8">
                                        <h3 class="text-lg font-medium">
                                            <a href="#" class="focus:outline-none">
                                                <!-- Extend touch target to entire panel -->
                                                <span class="absolute inset-0" aria-hidden="true"></span>
                                                Schedule a one-on-one
                                            </a>
                                        </h3>
                                        <p class="mt-2 text-sm text-gray-500">
                                            Doloribus dolores nostrum quia qui natus officia quod et dolorem. Sit repellendus qui ut at blanditiis et quo et molestiae.
                                        </p>
                                    </div>
                                    <span class="pointer-events-none absolute top-6 right-6 text-gray-300 group-hover:text-gray-400" aria-hidden="true">
                  <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z" />
                  </svg>
                </span>
                                </div>

                                <div class="relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-cyan-500">
                                    <div>
                  <span class="rounded-lg inline-flex p-3 bg-yellow-50 text-yellow-700 ring-4 ring-white">
                    <!-- Heroicon name: outline/cash -->
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                  </span>
                                    </div>
                                    <div class="mt-8">
                                        <h3 class="text-lg font-medium">
                                            <a href="#" class="focus:outline-none">
                                                <!-- Extend touch target to entire panel -->
                                                <span class="absolute inset-0" aria-hidden="true"></span>
                                                Payroll
                                            </a>
                                        </h3>
                                        <p class="mt-2 text-sm text-gray-500">
                                            Doloribus dolores nostrum quia qui natus officia quod et dolorem. Sit repellendus qui ut at blanditiis et quo et molestiae.
                                        </p>
                                    </div>
                                    <span class="pointer-events-none absolute top-6 right-6 text-gray-300 group-hover:text-gray-400" aria-hidden="true">
                  <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z" />
                  </svg>
                </span>
                                </div>

                                <div class="sm:rounded-bl-lg relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-cyan-500">
                                    <div>
                  <span class="rounded-lg inline-flex p-3 bg-rose-50 text-rose-700 ring-4 ring-white">
                    <!-- Heroicon name: outline/receipt-refund -->
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z" />
                    </svg>
                  </span>
                                    </div>
                                    <div class="mt-8">
                                        <h3 class="text-lg font-medium">
                                            <a href="#" class="focus:outline-none">
                                                <!-- Extend touch target to entire panel -->
                                                <span class="absolute inset-0" aria-hidden="true"></span>
                                                Submit an expense
                                            </a>
                                        </h3>
                                        <p class="mt-2 text-sm text-gray-500">
                                            Doloribus dolores nostrum quia qui natus officia quod et dolorem. Sit repellendus qui ut at blanditiis et quo et molestiae.
                                        </p>
                                    </div>
                                    <span class="pointer-events-none absolute top-6 right-6 text-gray-300 group-hover:text-gray-400" aria-hidden="true">
                  <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z" />
                  </svg>
                </span>
                                </div>

                                <div class="rounded-bl-lg rounded-br-lg sm:rounded-bl-none relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-cyan-500">
                                    <div>
                  <span class="rounded-lg inline-flex p-3 bg-indigo-50 text-indigo-700 ring-4 ring-white">
                    <!-- Heroicon name: outline/academic-cap -->
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                      <path d="M12 14l9-5-9-5-9 5 9 5z" />
                      <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                    </svg>
                  </span>
                                    </div>
                                    <div class="mt-8">
                                        <h3 class="text-lg font-medium">
                                            <a href="#" class="focus:outline-none">
                                                <!-- Extend touch target to entire panel -->
                                                <span class="absolute inset-0" aria-hidden="true"></span>
                                                Training
                                            </a>
                                        </h3>
                                        <p class="mt-2 text-sm text-gray-500">
                                            Doloribus dolores nostrum quia qui natus officia quod et dolorem. Sit repellendus qui ut at blanditiis et quo et molestiae.
                                        </p>
                                    </div>
                                    <span class="pointer-events-none absolute top-6 right-6 text-gray-300 group-hover:text-gray-400" aria-hidden="true">
                  <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z" />
                  </svg>
                </span>
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
                                    <h2 class="text-base font-medium text-gray-900" id="announcements-title">Announcements</h2>
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
                                                        Cum qui rem deleniti. Suscipit in dolor veritatis sequi aut. Vero ut earum quis deleniti. Ut a sunt eum cum ut repudiandae possimus. Nihil ex tempora neque cum consectetur dolores.
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
                                                        Alias inventore ut autem optio voluptas et repellendus. Facere totam quaerat quam quo laudantium cumque eaque excepturi vel. Accusamus maxime ipsam reprehenderit rerum id repellendus rerum. Culpa cum vel natus. Est sit autem mollitia.
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
                                                        Tenetur libero voluptatem rerum occaecati qui est molestiae exercitationem. Voluptate quisquam iure assumenda consequatur ex et recusandae. Alias consectetur voluptatibus. Accusamus a ab dicta et. Consequatur quis dignissimos voluptatem nisi.
                                                    </p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="mt-6">
                                        <a href="#" class="w-full flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
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
                                    <h2 class="text-base font-medium text-gray-900" id="recent-hires-title">Recent Hires</h2>
                                    <div class="flow-root mt-6">
                                        <ul role="list" class="-my-5 divide-y divide-gray-200">
                                            <li class="py-4">
                                                <div class="flex items-center space-x-4">
                                                    <div class="flex-shrink-0">
                                                        <img class="h-8 w-8 rounded-full" src="https://images.unsplash.com/photo-1519345182560-3f2917c472ef?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
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
                                                        <a href="#" class="inline-flex items-center shadow-sm px-2.5 py-0.5 border border-gray-300 text-sm leading-5 font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50">
                                                            View
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>

                                            <li class="py-4">
                                                <div class="flex items-center space-x-4">
                                                    <div class="flex-shrink-0">
                                                        <img class="h-8 w-8 rounded-full" src="https://images.unsplash.com/photo-1463453091185-61582044d556?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
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
                                                        <a href="#" class="inline-flex items-center shadow-sm px-2.5 py-0.5 border border-gray-300 text-sm leading-5 font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50">
                                                            View
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>

                                            <li class="py-4">
                                                <div class="flex items-center space-x-4">
                                                    <div class="flex-shrink-0">
                                                        <img class="h-8 w-8 rounded-full" src="https://images.unsplash.com/photo-1502685104226-ee32379fefbe?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
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
                                                        <a href="#" class="inline-flex items-center shadow-sm px-2.5 py-0.5 border border-gray-300 text-sm leading-5 font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50">
                                                            View
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>

                                            <li class="py-4">
                                                <div class="flex items-center space-x-4">
                                                    <div class="flex-shrink-0">
                                                        <img class="h-8 w-8 rounded-full" src="https://images.unsplash.com/photo-1500917293891-ef795e70e1f6?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
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
                                                        <a href="#" class="inline-flex items-center shadow-sm px-2.5 py-0.5 border border-gray-300 text-sm leading-5 font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50">
                                                            View
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="mt-6">
                                        <a href="#" class="w-full flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
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
