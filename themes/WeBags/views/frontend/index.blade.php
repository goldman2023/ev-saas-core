@extends('frontend.layouts.app')

@section('content')
<!--
  This example requires Tailwind CSS v2.0+

  This example requires some changes to your config:

  ```
  // tailwind.config.js
  module.exports = {
    // ...
    plugins: [
      // ...
      require('@tailwindcss/forms'),
      require('@tailwindcss/aspect-ratio'),
    ],
  }
  ```
-->
<div class="bg-white">
    <!--
      Mobile menu

      Off-canvas menu for mobile, show/hide based on off-canvas menu state.
    -->
    <div class="fixed inset-0 flex z-40 lg:hidden" role="dialog" aria-modal="true">
      <!--
        Off-canvas menu overlay, show/hide based on off-canvas menu state.

        Entering: "transition-opacity ease-linear duration-300"
          From: "opacity-0"
          To: "opacity-100"
        Leaving: "transition-opacity ease-linear duration-300"
          From: "opacity-100"
          To: "opacity-0"
      -->
      <div class="fixed inset-0 bg-black bg-opacity-25" aria-hidden="true"></div>

      <!--
        Off-canvas menu, show/hide based on off-canvas menu state.

        Entering: "transition ease-in-out duration-300 transform"
          From: "-translate-x-full"
          To: "translate-x-0"
        Leaving: "transition ease-in-out duration-300 transform"
          From: "translate-x-0"
          To: "-translate-x-full"
      -->
      <div class="relative max-w-xs w-full bg-white shadow-xl pb-12 flex flex-col overflow-y-auto">
        <div class="px-4 pt-5 pb-2 flex">
          <button type="button" class="-m-2 p-2 rounded-md inline-flex items-center justify-center text-gray-400">
            <span class="sr-only">Close menu</span>
            <!-- Heroicon name: outline/x -->
            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>

        <!-- Links -->
        <div class="mt-2">
          <div class="border-b border-gray-200">
            <div class="-mb-px flex px-4 space-x-8" aria-orientation="horizontal" role="tablist">
              <!-- Selected: "text-indigo-600 border-indigo-600", Not Selected: "text-gray-900 border-transparent" -->
              <button id="tabs-1-tab-1" class="text-gray-900 border-transparent flex-1 whitespace-nowrap py-4 px-1 border-b-2 text-base font-medium" aria-controls="tabs-1-panel-1" role="tab" type="button">Women</button>

              <!-- Selected: "text-indigo-600 border-indigo-600", Not Selected: "text-gray-900 border-transparent" -->
              <button id="tabs-1-tab-2" class="text-gray-900 border-transparent flex-1 whitespace-nowrap py-4 px-1 border-b-2 text-base font-medium" aria-controls="tabs-1-panel-2" role="tab" type="button">Men</button>
            </div>
          </div>

          <!-- 'Women' tab panel, show/hide based on tab state. -->
          <div id="tabs-1-panel-1" class="px-4 pt-10 pb-6 space-y-12" aria-labelledby="tabs-1-tab-1" role="tabpanel" tabindex="0">
            <div class="grid grid-cols-1 items-start gap-y-10 gap-x-6">
              <div class="grid grid-cols-1 gap-y-10 gap-x-6">
                <div>
                  <p id="mobile-featured-heading-0" class="font-medium text-gray-900">Featured</p>
                  <ul role="list" aria-labelledby="mobile-featured-heading-0" class="mt-6 space-y-6">
                    <li class="flex">
                      <a href="#" class="text-gray-500"> Sleep </a>
                    </li>

                    <li class="flex">
                      <a href="#" class="text-gray-500"> Swimwear </a>
                    </li>

                    <li class="flex">
                      <a href="#" class="text-gray-500"> Underwear </a>
                    </li>
                  </ul>
                </div>
                <div>
                  <p id="mobile-categories-heading" class="font-medium text-gray-900">Categories</p>
                  <ul role="list" aria-labelledby="mobile-categories-heading" class="mt-6 space-y-6">
                    <li class="flex">
                      <a href="#" class="text-gray-500"> Basic Tees </a>
                    </li>

                    <li class="flex">
                      <a href="#" class="text-gray-500"> Artwork Tees </a>
                    </li>

                    <li class="flex">
                      <a href="#" class="text-gray-500"> Bottoms </a>
                    </li>

                    <li class="flex">
                      <a href="#" class="text-gray-500"> Underwear </a>
                    </li>

                    <li class="flex">
                      <a href="#" class="text-gray-500"> Accessories </a>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="grid grid-cols-1 gap-y-10 gap-x-6">
                <div>
                  <p id="mobile-collection-heading" class="font-medium text-gray-900">Collection</p>
                  <ul role="list" aria-labelledby="mobile-collection-heading" class="mt-6 space-y-6">
                    <li class="flex">
                      <a href="#" class="text-gray-500"> Everything </a>
                    </li>

                    <li class="flex">
                      <a href="#" class="text-gray-500"> Core </a>
                    </li>

                    <li class="flex">
                      <a href="#" class="text-gray-500"> New Arrivals </a>
                    </li>

                    <li class="flex">
                      <a href="#" class="text-gray-500"> Sale </a>
                    </li>
                  </ul>
                </div>

                <div>
                  <p id="mobile-brand-heading" class="font-medium text-gray-900">Brands</p>
                  <ul role="list" aria-labelledby="mobile-brand-heading" class="mt-6 space-y-6">
                    <li class="flex">
                      <a href="#" class="text-gray-500"> Full Nelson </a>
                    </li>

                    <li class="flex">
                      <a href="#" class="text-gray-500"> My Way </a>
                    </li>

                    <li class="flex">
                      <a href="#" class="text-gray-500"> Re-Arranged </a>
                    </li>

                    <li class="flex">
                      <a href="#" class="text-gray-500"> Counterfeit </a>
                    </li>

                    <li class="flex">
                      <a href="#" class="text-gray-500"> Significant Other </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>

          <!-- 'Men' tab panel, show/hide based on tab state. -->
          <div id="tabs-1-panel-2" class="px-4 pt-10 pb-6 space-y-12" aria-labelledby="tabs-1-tab-2" role="tabpanel" tabindex="0">
            <div class="grid grid-cols-1 items-start gap-y-10 gap-x-6">
              <div class="grid grid-cols-1 gap-y-10 gap-x-6">
                <div>
                  <p id="mobile-featured-heading-1" class="font-medium text-gray-900">Featured</p>
                  <ul role="list" aria-labelledby="mobile-featured-heading-1" class="mt-6 space-y-6">
                    <li class="flex">
                      <a href="#" class="text-gray-500"> Casual </a>
                    </li>

                    <li class="flex">
                      <a href="#" class="text-gray-500"> Boxers </a>
                    </li>

                    <li class="flex">
                      <a href="#" class="text-gray-500"> Outdoor </a>
                    </li>
                  </ul>
                </div>
                <div>
                  <p id="mobile-categories-heading" class="font-medium text-gray-900">Categories</p>
                  <ul role="list" aria-labelledby="mobile-categories-heading" class="mt-6 space-y-6">
                    <li class="flex">
                      <a href="#" class="text-gray-500"> Artwork Tees </a>
                    </li>

                    <li class="flex">
                      <a href="#" class="text-gray-500"> Pants </a>
                    </li>

                    <li class="flex">
                      <a href="#" class="text-gray-500"> Accessories </a>
                    </li>

                    <li class="flex">
                      <a href="#" class="text-gray-500"> Boxers </a>
                    </li>

                    <li class="flex">
                      <a href="#" class="text-gray-500"> Basic Tees </a>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="grid grid-cols-1 gap-y-10 gap-x-6">
                <div>
                  <p id="mobile-collection-heading" class="font-medium text-gray-900">Collection</p>
                  <ul role="list" aria-labelledby="mobile-collection-heading" class="mt-6 space-y-6">
                    <li class="flex">
                      <a href="#" class="text-gray-500"> Everything </a>
                    </li>

                    <li class="flex">
                      <a href="#" class="text-gray-500"> Core </a>
                    </li>

                    <li class="flex">
                      <a href="#" class="text-gray-500"> New Arrivals </a>
                    </li>

                    <li class="flex">
                      <a href="#" class="text-gray-500"> Sale </a>
                    </li>
                  </ul>
                </div>

                <div>
                  <p id="mobile-brand-heading" class="font-medium text-gray-900">Brands</p>
                  <ul role="list" aria-labelledby="mobile-brand-heading" class="mt-6 space-y-6">
                    <li class="flex">
                      <a href="#" class="text-gray-500"> Significant Other </a>
                    </li>

                    <li class="flex">
                      <a href="#" class="text-gray-500"> My Way </a>
                    </li>

                    <li class="flex">
                      <a href="#" class="text-gray-500"> Counterfeit </a>
                    </li>

                    <li class="flex">
                      <a href="#" class="text-gray-500"> Re-Arranged </a>
                    </li>

                    <li class="flex">
                      <a href="#" class="text-gray-500"> Full Nelson </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="border-t border-gray-200 py-6 px-4 space-y-6">
          <div class="flow-root">
            <a href="#" class="-m-2 p-2 block font-medium text-gray-900">Company</a>
          </div>

          <div class="flow-root">
            <a href="#" class="-m-2 p-2 block font-medium text-gray-900">Stores</a>
          </div>
        </div>

        <div class="border-t border-gray-200 py-6 px-4 space-y-6">
          <div class="flow-root">
            <a href="#" class="-m-2 p-2 block font-medium text-gray-900">Create an account</a>
          </div>
          <div class="flow-root">
            <a href="#" class="-m-2 p-2 block font-medium text-gray-900">Sign in</a>
          </div>
        </div>

        <div class="border-t border-gray-200 py-6 px-4 space-y-6">
          <!-- Currency selector -->
          <form>
            <div class="inline-block">
              <label for="mobile-currency" class="sr-only">Currency</label>
              <div class="-ml-2 group relative border-transparent rounded-md focus-within:ring-2 focus-within:ring-white">
                <select id="mobile-currency" name="currency" class="bg-none border-transparent rounded-md py-0.5 pl-2 pr-5 flex items-center text-sm font-medium text-gray-700 group-hover:text-gray-800 focus:outline-none focus:ring-0 focus:border-transparent">
                  <option>CAD</option>

                  <option>USD</option>

                  <option>AUD</option>

                  <option>EUR</option>

                  <option>GBP</option>
                </select>
                <div class="absolute right-0 inset-y-0 flex items-center pointer-events-none">
                  <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20" class="w-5 h-5 text-gray-500">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 8l4 4 4-4" />
                  </svg>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <header class="relative z-10">
      <nav aria-label="Top">
        <!-- Top navigation -->
        <div class="bg-gray-900">
          <div class="max-w-7xl mx-auto h-10 px-4 flex items-center justify-between sm:px-6 lg:px-8">
            <!-- Currency selector -->
            <form class="hidden lg:block lg:flex-1">
              <div class="flex">
                <label for="desktop-currency" class="sr-only">Currency</label>
                <div class="-ml-2 group relative bg-gray-900 border-transparent rounded-md focus-within:ring-2 focus-within:ring-white">
                  <select id="desktop-currency" name="currency" class="bg-none bg-gray-900 border-transparent rounded-md py-0.5 pl-2 pr-5 flex items-center text-sm font-medium text-white group-hover:text-gray-100 focus:outline-none focus:ring-0 focus:border-transparent">
                    <option>CAD</option>

                    <option>USD</option>

                    <option>AUD</option>

                    <option>EUR</option>

                    <option>GBP</option>
                  </select>
                  <div class="absolute right-0 inset-y-0 flex items-center pointer-events-none">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20" class="w-5 h-5 text-gray-300">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 8l4 4 4-4" />
                    </svg>
                  </div>
                </div>
              </div>
            </form>

            <p class="flex-1 text-center text-sm font-medium text-white lg:flex-none">Get free delivery on orders over $100</p>

            <div class="hidden lg:flex lg:flex-1 lg:items-center lg:justify-end lg:space-x-6">
              <a href="#" class="text-sm font-medium text-white hover:text-gray-100">Create an account</a>
              <span class="h-6 w-px bg-gray-600" aria-hidden="true"></span>
              <a href="#" class="text-sm font-medium text-white hover:text-gray-100">Sign in</a>
            </div>
          </div>
        </div>

        <!-- Secondary navigation -->
        <div class="bg-white">
          <div class="border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
              <div class="h-16 flex items-center justify-between">
                <!-- Logo (lg+) -->
                <div class="hidden lg:flex lg:items-center">
                  <a href="#">
                    <span class="sr-only">Workflow</span>
                    <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-mark.svg?color=indigo&shade=600" alt="">
                  </a>
                </div>

                <div class="hidden h-full lg:flex">
                  <!-- Mega menus -->
                  <div class="ml-8">
                    <div class="h-full flex justify-center space-x-8">
                      <div class="flex">
                        <div class="relative flex">
                          <!-- Item active: "border-indigo-600 text-indigo-600", Item inactive: "border-transparent text-gray-700 hover:text-gray-800" -->
                          <button type="button" class="border-transparent text-gray-700 hover:text-gray-800 relative z-10 flex items-center transition-colors ease-out duration-200 text-sm font-medium border-b-2 -mb-px pt-px" aria-expanded="false">Women</button>
                        </div>

                        <!--
                          'Women' mega menu, show/hide based on flyout menu state.

                          Entering: "transition ease-out duration-200"
                            From: "opacity-0"
                            To: "opacity-100"
                          Leaving: "transition ease-in duration-150"
                            From: "opacity-100"
                            To: "opacity-0"
                        -->
                        <div class="absolute top-full inset-x-0 text-gray-500 sm:text-sm">
                          <!-- Presentational element used to render the bottom shadow, if we put the shadow on the actual panel it pokes out the top, so we use this shorter element to hide the top of the shadow -->
                          <div class="absolute inset-0 top-1/2 bg-white shadow" aria-hidden="true"></div>

                          <div class="relative bg-white">
                            <div class="max-w-7xl mx-auto px-8">
                              <div class="grid grid-cols-2 items-start gap-y-10 gap-x-8 pt-10 pb-12">
                                <div class="grid grid-cols-2 gap-y-10 gap-x-8">
                                  <div>
                                    <p id="desktop-featured-heading-0" class="font-medium text-gray-900">Featured</p>
                                    <ul role="list" aria-labelledby="desktop-featured-heading-0" class="mt-6 space-y-6 sm:mt-4 sm:space-y-4">
                                      <li class="flex">
                                        <a href="#" class="hover:text-gray-800"> Sleep </a>
                                      </li>

                                      <li class="flex">
                                        <a href="#" class="hover:text-gray-800"> Swimwear </a>
                                      </li>

                                      <li class="flex">
                                        <a href="#" class="hover:text-gray-800"> Underwear </a>
                                      </li>
                                    </ul>
                                  </div>
                                  <div>
                                    <p id="desktop-categories-heading" class="font-medium text-gray-900">Categories</p>
                                    <ul role="list" aria-labelledby="desktop-categories-heading" class="mt-6 space-y-6 sm:mt-4 sm:space-y-4">
                                      <li class="flex">
                                        <a href="#" class="hover:text-gray-800"> Basic Tees </a>
                                      </li>

                                      <li class="flex">
                                        <a href="#" class="hover:text-gray-800"> Artwork Tees </a>
                                      </li>

                                      <li class="flex">
                                        <a href="#" class="hover:text-gray-800"> Bottoms </a>
                                      </li>

                                      <li class="flex">
                                        <a href="#" class="hover:text-gray-800"> Underwear </a>
                                      </li>

                                      <li class="flex">
                                        <a href="#" class="hover:text-gray-800"> Accessories </a>
                                      </li>
                                    </ul>
                                  </div>
                                </div>
                                <div class="grid grid-cols-2 gap-y-10 gap-x-8">
                                  <div>
                                    <p id="desktop-collection-heading" class="font-medium text-gray-900">Collection</p>
                                    <ul role="list" aria-labelledby="desktop-collection-heading" class="mt-6 space-y-6 sm:mt-4 sm:space-y-4">
                                      <li class="flex">
                                        <a href="#" class="hover:text-gray-800"> Everything </a>
                                      </li>

                                      <li class="flex">
                                        <a href="#" class="hover:text-gray-800"> Core </a>
                                      </li>

                                      <li class="flex">
                                        <a href="#" class="hover:text-gray-800"> New Arrivals </a>
                                      </li>

                                      <li class="flex">
                                        <a href="#" class="hover:text-gray-800"> Sale </a>
                                      </li>
                                    </ul>
                                  </div>

                                  <div>
                                    <p id="desktop-brand-heading" class="font-medium text-gray-900">Brands</p>
                                    <ul role="list" aria-labelledby="desktop-brand-heading" class="mt-6 space-y-6 sm:mt-4 sm:space-y-4">
                                      <li class="flex">
                                        <a href="#" class="hover:text-gray-800"> Full Nelson </a>
                                      </li>

                                      <li class="flex">
                                        <a href="#" class="hover:text-gray-800"> My Way </a>
                                      </li>

                                      <li class="flex">
                                        <a href="#" class="hover:text-gray-800"> Re-Arranged </a>
                                      </li>

                                      <li class="flex">
                                        <a href="#" class="hover:text-gray-800"> Counterfeit </a>
                                      </li>

                                      <li class="flex">
                                        <a href="#" class="hover:text-gray-800"> Significant Other </a>
                                      </li>
                                    </ul>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="flex">
                        <div class="relative flex">
                          <!-- Item active: "border-indigo-600 text-indigo-600", Item inactive: "border-transparent text-gray-700 hover:text-gray-800" -->
                          <button type="button" class="border-transparent text-gray-700 hover:text-gray-800 relative z-10 flex items-center transition-colors ease-out duration-200 text-sm font-medium border-b-2 -mb-px pt-px" aria-expanded="false">Men</button>
                        </div>

                        <!--
                          'Men' mega menu, show/hide based on flyout menu state.

                          Entering: "transition ease-out duration-200"
                            From: "opacity-0"
                            To: "opacity-100"
                          Leaving: "transition ease-in duration-150"
                            From: "opacity-100"
                            To: "opacity-0"
                        -->
                        <div class="absolute top-full inset-x-0 text-gray-500 sm:text-sm">
                          <!-- Presentational element used to render the bottom shadow, if we put the shadow on the actual panel it pokes out the top, so we use this shorter element to hide the top of the shadow -->
                          <div class="absolute inset-0 top-1/2 bg-white shadow" aria-hidden="true"></div>

                          <div class="relative bg-white">
                            <div class="max-w-7xl mx-auto px-8">
                              <div class="grid grid-cols-2 items-start gap-y-10 gap-x-8 pt-10 pb-12">
                                <div class="grid grid-cols-2 gap-y-10 gap-x-8">
                                  <div>
                                    <p id="desktop-featured-heading-1" class="font-medium text-gray-900">Featured</p>
                                    <ul role="list" aria-labelledby="desktop-featured-heading-1" class="mt-6 space-y-6 sm:mt-4 sm:space-y-4">
                                      <li class="flex">
                                        <a href="#" class="hover:text-gray-800"> Casual </a>
                                      </li>

                                      <li class="flex">
                                        <a href="#" class="hover:text-gray-800"> Boxers </a>
                                      </li>

                                      <li class="flex">
                                        <a href="#" class="hover:text-gray-800"> Outdoor </a>
                                      </li>
                                    </ul>
                                  </div>
                                  <div>
                                    <p id="desktop-categories-heading" class="font-medium text-gray-900">Categories</p>
                                    <ul role="list" aria-labelledby="desktop-categories-heading" class="mt-6 space-y-6 sm:mt-4 sm:space-y-4">
                                      <li class="flex">
                                        <a href="#" class="hover:text-gray-800"> Artwork Tees </a>
                                      </li>

                                      <li class="flex">
                                        <a href="#" class="hover:text-gray-800"> Pants </a>
                                      </li>

                                      <li class="flex">
                                        <a href="#" class="hover:text-gray-800"> Accessories </a>
                                      </li>

                                      <li class="flex">
                                        <a href="#" class="hover:text-gray-800"> Boxers </a>
                                      </li>

                                      <li class="flex">
                                        <a href="#" class="hover:text-gray-800"> Basic Tees </a>
                                      </li>
                                    </ul>
                                  </div>
                                </div>
                                <div class="grid grid-cols-2 gap-y-10 gap-x-8">
                                  <div>
                                    <p id="desktop-collection-heading" class="font-medium text-gray-900">Collection</p>
                                    <ul role="list" aria-labelledby="desktop-collection-heading" class="mt-6 space-y-6 sm:mt-4 sm:space-y-4">
                                      <li class="flex">
                                        <a href="#" class="hover:text-gray-800"> Everything </a>
                                      </li>

                                      <li class="flex">
                                        <a href="#" class="hover:text-gray-800"> Core </a>
                                      </li>

                                      <li class="flex">
                                        <a href="#" class="hover:text-gray-800"> New Arrivals </a>
                                      </li>

                                      <li class="flex">
                                        <a href="#" class="hover:text-gray-800"> Sale </a>
                                      </li>
                                    </ul>
                                  </div>

                                  <div>
                                    <p id="desktop-brand-heading" class="font-medium text-gray-900">Brands</p>
                                    <ul role="list" aria-labelledby="desktop-brand-heading" class="mt-6 space-y-6 sm:mt-4 sm:space-y-4">
                                      <li class="flex">
                                        <a href="#" class="hover:text-gray-800"> Significant Other </a>
                                      </li>

                                      <li class="flex">
                                        <a href="#" class="hover:text-gray-800"> My Way </a>
                                      </li>

                                      <li class="flex">
                                        <a href="#" class="hover:text-gray-800"> Counterfeit </a>
                                      </li>

                                      <li class="flex">
                                        <a href="#" class="hover:text-gray-800"> Re-Arranged </a>
                                      </li>

                                      <li class="flex">
                                        <a href="#" class="hover:text-gray-800"> Full Nelson </a>
                                      </li>
                                    </ul>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <a href="#" class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">Company</a>

                      <a href="#" class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">Stores</a>
                    </div>
                  </div>
                </div>

                <!-- Mobile menu and search (lg-) -->
                <div class="flex-1 flex items-center lg:hidden">
                  <!-- Mobile menu toggle, controls the 'mobileMenuOpen' state. -->
                  <button type="button" class="-ml-2 bg-white p-2 rounded-md text-gray-400">
                    <span class="sr-only">Open menu</span>
                    <!-- Heroicon name: outline/menu -->
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                  </button>

                  <!-- Search -->
                  <a href="#" class="ml-2 p-2 text-gray-400 hover:text-gray-500">
                    <span class="sr-only">Search</span>
                    <!-- Heroicon name: outline/search -->
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                  </a>
                </div>

                <!-- Logo (lg-) -->
                <a href="#" class="lg:hidden">
                  <span class="sr-only">Workflow</span>
                  <img src="https://tailwindui.com/img/logos/workflow-mark.svg?color=indigo&shade=600" alt="" class="h-8 w-auto">
                </a>

                <div class="flex-1 flex items-center justify-end">
                  <div class="flex items-center lg:ml-8">
                    <div class="flex space-x-8">
                      <div class="hidden lg:flex">
                        <a href="#" class="-m-2 p-2 text-gray-400 hover:text-gray-500">
                          <span class="sr-only">Search</span>
                          <!-- Heroicon name: outline/search -->
                          <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                          </svg>
                        </a>
                      </div>

                      <div class="flex">
                        <a href="#" class="-m-2 p-2 text-gray-400 hover:text-gray-500">
                          <span class="sr-only">Account</span>
                          <!-- Heroicon name: outline/user -->
                          <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                          </svg>
                        </a>
                      </div>
                    </div>

                    <span class="mx-4 h-6 w-px bg-gray-200 lg:mx-6" aria-hidden="true"></span>

                    <div class="flow-root">
                      <a href="#" class="group -m-2 p-2 flex items-center">
                        <!-- Heroicon name: outline/shopping-cart -->
                        <svg class="flex-shrink-0 h-6 w-6 text-gray-400 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span class="ml-2 text-sm font-medium text-gray-700 group-hover:text-gray-800">0</span>
                        <span class="sr-only">items in cart, view bag</span>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </nav>
    </header>

    <main>
      <!-- Hero -->
      <div class="flex flex-col border-b border-gray-200 lg:border-0">
        <nav aria-label="Offers" class="order-last lg:order-first">
          <div class="max-w-7xl mx-auto lg:px-8">
            <ul role="list" class="grid grid-cols-1 divide-y divide-gray-200 lg:grid-cols-3 lg:divide-y-0 lg:divide-x">
              <li class="flex flex-col">
                <a href="#" class="relative flex-1 flex flex-col justify-center bg-white py-6 px-4 text-center focus:z-10">
                  <p class="text-sm text-gray-500">Download the app</p>
                  <p class="font-semibold text-gray-900">Get an exclusive $5 off code</p>
                </a>
              </li>

              <li class="flex flex-col">
                <a href="#" class="relative flex-1 flex flex-col justify-center bg-white py-6 px-4 text-center focus:z-10">
                  <p class="text-sm text-gray-500">Return when you&#039;re ready</p>
                  <p class="font-semibold text-gray-900">60 days of free returns</p>
                </a>
              </li>

              <li class="flex flex-col">
                <a href="#" class="relative flex-1 flex flex-col justify-center bg-white py-6 px-4 text-center focus:z-10">
                  <p class="text-sm text-gray-500">Sign up for our newsletter</p>
                  <p class="font-semibold text-gray-900">15% off your first order</p>
                </a>
              </li>
            </ul>
          </div>
        </nav>

        <div class="relative">
          <div aria-hidden="true" class="hidden absolute w-1/2 h-full bg-gray-100 lg:block"></div>
          <div class="relative bg-gray-100 lg:bg-transparent">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 lg:grid lg:grid-cols-2">
              <div class="max-w-2xl mx-auto py-24 lg:py-64 lg:max-w-none">
                <div class="lg:pr-16">
                  <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl xl:text-6xl">Focus on what matters</h1>
                  <p class="mt-4 text-xl text-gray-600">All the charts, datepickers, and notifications in the world can't beat checking off some items on a paper card.</p>
                  <div class="mt-6">
                    <a href="#" class="inline-block bg-indigo-600 border border-transparent py-3 px-8 rounded-md font-medium text-white hover:bg-indigo-700">Shop Productivity</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="w-full h-48 sm:h-64 lg:absolute lg:top-0 lg:right-0 lg:w-1/2 lg:h-full">
            <img src="https://tailwindui.com/img/ecommerce-images/home-page-02-hero-half-width.jpg" alt="" class="w-full h-full object-center object-cover">
          </div>
        </div>
      </div>

      <!-- Trending products -->
      <section aria-labelledby="trending-heading" class="bg-white">
        <div class="py-16 sm:py-24 lg:max-w-7xl lg:mx-auto lg:py-32 lg:px-8">
          <div class="px-4 flex items-center justify-between sm:px-6 lg:px-0">
            <h2 id="trending-heading" class="text-2xl font-extrabold tracking-tight text-gray-900">Trending products</h2>
            <a href="#" class="hidden sm:block text-sm font-semibold text-indigo-600 hover:text-indigo-500">See everything<span aria-hidden="true"> &rarr;</span></a>
          </div>

          <div class="mt-8 relative">
            <div class="relative w-full overflow-x-auto">
              <ul role="list" class="mx-4 inline-flex space-x-8 sm:mx-6 lg:mx-0 lg:space-x-0 lg:grid lg:grid-cols-4 lg:gap-x-8">
                <li class="w-64 inline-flex flex-col text-center lg:w-auto">
                  <div class="group relative">
                    <div class="w-full bg-gray-200 rounded-md overflow-hidden aspect-w-1 aspect-h-1">
                      <img src="https://tailwindui.com/img/ecommerce-images/home-page-02-product-01.jpg" alt="Black machined steel pen with hexagonal grip and small white logo at top." class="w-full h-full object-center object-cover group-hover:opacity-75">
                    </div>
                    <div class="mt-6">
                      <p class="text-sm text-gray-500">Black</p>
                      <h3 class="mt-1 font-semibold text-gray-900">
                        <a href="#">
                          <span class="absolute inset-0"></span>
                          Machined Pen
                        </a>
                      </h3>
                      <p class="mt-1 text-gray-900">$35</p>
                    </div>
                  </div>

                  <h4 class="sr-only">Available colors</h4>
                  <ul role="list" class="mt-auto pt-6 flex items-center justify-center space-x-3">
                    <li class="w-4 h-4 rounded-full border border-black border-opacity-10" style="background-color: #111827">
                      <span class="sr-only"> Black </span>
                    </li>

                    <li class="w-4 h-4 rounded-full border border-black border-opacity-10" style="background-color: #fde68a">
                      <span class="sr-only"> Brass </span>
                    </li>

                    <li class="w-4 h-4 rounded-full border border-black border-opacity-10" style="background-color: #e5e7eb">
                      <span class="sr-only"> Chrome </span>
                    </li>
                  </ul>
                </li>

                <!-- More products... -->
              </ul>
            </div>
          </div>

          <div class="mt-12 px-4 sm:hidden">
            <a href="#" class="text-sm font-semibold text-indigo-600 hover:text-indigo-500">See everything<span aria-hidden="true"> &rarr;</span></a>
          </div>
        </div>
      </section>

      <!-- Collections -->
      <section aria-labelledby="collections-heading" class="bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="max-w-2xl mx-auto py-16 sm:py-24 lg:py-32 lg:max-w-none">
            <h2 id="collections-heading" class="text-2xl font-extrabold text-gray-900">Collections</h2>

            <div class="mt-6 space-y-12 lg:space-y-0 lg:grid lg:grid-cols-3 lg:gap-x-6">
              <div class="group relative">
                <div class="relative w-full h-80 bg-white rounded-lg overflow-hidden group-hover:opacity-75 sm:aspect-w-2 sm:aspect-h-1 sm:h-64 lg:aspect-w-1 lg:aspect-h-1">
                  <img src="https://tailwindui.com/img/ecommerce-images/home-page-02-edition-01.jpg" alt="Desk with leather desk pad, walnut desk organizer, wireless keyboard and mouse, and porcelain mug." class="w-full h-full object-center object-cover">
                </div>
                <h3 class="mt-6 text-sm text-gray-500">
                  <a href="#">
                    <span class="absolute inset-0"></span>
                    Desk and Office
                  </a>
                </h3>
                <p class="text-base font-semibold text-gray-900">Work from home accessories</p>
              </div>

              <div class="group relative">
                <div class="relative w-full h-80 bg-white rounded-lg overflow-hidden group-hover:opacity-75 sm:aspect-w-2 sm:aspect-h-1 sm:h-64 lg:aspect-w-1 lg:aspect-h-1">
                  <img src="https://tailwindui.com/img/ecommerce-images/home-page-02-edition-02.jpg" alt="Wood table with porcelain mug, leather journal, brass pen, leather key ring, and a houseplant." class="w-full h-full object-center object-cover">
                </div>
                <h3 class="mt-6 text-sm text-gray-500">
                  <a href="#">
                    <span class="absolute inset-0"></span>
                    Self-Improvement
                  </a>
                </h3>
                <p class="text-base font-semibold text-gray-900">Journals and note-taking</p>
              </div>

              <div class="group relative">
                <div class="relative w-full h-80 bg-white rounded-lg overflow-hidden group-hover:opacity-75 sm:aspect-w-2 sm:aspect-h-1 sm:h-64 lg:aspect-w-1 lg:aspect-h-1">
                  <img src="https://tailwindui.com/img/ecommerce-images/home-page-02-edition-03.jpg" alt="Collection of four insulated travel bottles on wooden shelf." class="w-full h-full object-center object-cover">
                </div>
                <h3 class="mt-6 text-sm text-gray-500">
                  <a href="#">
                    <span class="absolute inset-0"></span>
                    Travel
                  </a>
                </h3>
                <p class="text-base font-semibold text-gray-900">Daily commute essentials</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Sale and testimonials -->
      <div class="relative overflow-hidden">
        <!-- Decorative background image and gradient -->
        <div aria-hidden="true" class="absolute inset-0">
          <div class="absolute inset-0 max-w-7xl mx-auto overflow-hidden xl:px-8">
            <img src="https://tailwindui.com/img/ecommerce-images/home-page-02-sale-full-width.jpg" alt="" class="w-full h-full object-center object-cover">
          </div>
          <div class="absolute inset-0 bg-white bg-opacity-75"></div>
          <div class="absolute inset-0 bg-gradient-to-t from-white via-white"></div>
        </div>

        <!-- Sale -->
        <section aria-labelledby="sale-heading" class="relative max-w-7xl mx-auto pt-32 px-4 flex flex-col items-center text-center sm:px-6 lg:px-8">
          <div class="max-w-2xl mx-auto lg:max-w-none">
            <h2 id="sale-heading" class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl lg:text-6xl">Get 25% off during our one-time sale</h2>
            <p class="mt-4 max-w-xl mx-auto text-xl text-gray-600">Most of our products are limited releases that won't come back. Get your favorite items while they're in stock.</p>
            <a href="#" class="mt-6 inline-block w-full bg-gray-900 border border-transparent rounded-md py-3 px-8 font-medium text-white hover:bg-gray-800 sm:w-auto">Get access to our one-time sale</a>
          </div>
        </section>

        <!-- Testimonials -->
        <section aria-labelledby="testimonial-heading" class="relative py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:py-32 lg:px-8">
          <div class="max-w-2xl mx-auto lg:max-w-none">
            <h2 id="testimonial-heading" class="text-2xl font-extrabold tracking-tight text-gray-900">What are people saying?</h2>

            <div class="mt-16 space-y-16 lg:space-y-0 lg:grid lg:grid-cols-3 lg:gap-x-8">
              <blockquote class="sm:flex lg:block">
                <svg width="24" height="18" viewBox="0 0 24 18" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="flex-shrink-0 text-gray-300">
                  <path d="M0 18h8.7v-5.555c-.024-3.906 1.113-6.841 2.892-9.68L6.452 0C3.188 2.644-.026 7.86 0 12.469V18zm12.408 0h8.7v-5.555C21.083 8.539 22.22 5.604 24 2.765L18.859 0c-3.263 2.644-6.476 7.86-6.451 12.469V18z" fill="currentColor" />
                </svg>
                <div class="mt-8 sm:mt-0 sm:ml-6 lg:mt-10 lg:ml-0">
                  <p class="text-lg text-gray-600">My order arrived super quickly. The product is even better than I hoped it would be. Very happy customer over here!</p>
                  <cite class="mt-4 block font-semibold not-italic text-gray-900"> Sarah Peters, New Orleans </cite>
                </div>
              </blockquote>

              <blockquote class="sm:flex lg:block">
                <svg width="24" height="18" viewBox="0 0 24 18" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="flex-shrink-0 text-gray-300">
                  <path d="M0 18h8.7v-5.555c-.024-3.906 1.113-6.841 2.892-9.68L6.452 0C3.188 2.644-.026 7.86 0 12.469V18zm12.408 0h8.7v-5.555C21.083 8.539 22.22 5.604 24 2.765L18.859 0c-3.263 2.644-6.476 7.86-6.451 12.469V18z" fill="currentColor" />
                </svg>
                <div class="mt-8 sm:mt-0 sm:ml-6 lg:mt-10 lg:ml-0">
                  <p class="text-lg text-gray-600">I had to return a purchase that didn’t fit. The whole process was so simple that I ended up ordering two new items!</p>
                  <cite class="mt-4 block font-semibold not-italic text-gray-900"> Kelly McPherson, Chicago </cite>
                </div>
              </blockquote>

              <blockquote class="sm:flex lg:block">
                <svg width="24" height="18" viewBox="0 0 24 18" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="flex-shrink-0 text-gray-300">
                  <path d="M0 18h8.7v-5.555c-.024-3.906 1.113-6.841 2.892-9.68L6.452 0C3.188 2.644-.026 7.86 0 12.469V18zm12.408 0h8.7v-5.555C21.083 8.539 22.22 5.604 24 2.765L18.859 0c-3.263 2.644-6.476 7.86-6.451 12.469V18z" fill="currentColor" />
                </svg>
                <div class="mt-8 sm:mt-0 sm:ml-6 lg:mt-10 lg:ml-0">
                  <p class="text-lg text-gray-600">Now that I’m on holiday for the summer, I’ll probably order a few more shirts. It’s just so convenient, and I know the quality will always be there.</p>
                  <cite class="mt-4 block font-semibold not-italic text-gray-900"> Chris Paul, Phoenix </cite>
                </div>
              </blockquote>
            </div>
          </div>
        </section>
      </div>
    </main>

    <footer aria-labelledby="footer-heading" class="bg-white">
      <h2 id="footer-heading" class="sr-only">Footer</h2>
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="border-t border-gray-200">
          <div class="pt-16 pb-20">
            <div class="md:flex md:justify-center">
              <img src="https://tailwindui.com/img/logos/workflow-mark.svg?color=indigo&shade=600" alt="" class="h-8 w-auto">
            </div>
            <div class="mt-16 max-w-5xl mx-auto xl:grid xl:grid-cols-2 xl:gap-8">
              <div class="grid grid-cols-2 gap-8 xl:col-span-2">
                <div class="space-y-12 md:space-y-0 md:grid md:grid-cols-2 md:gap-8">
                  <div>
                    <h3 class="text-sm font-medium text-gray-900">Products</h3>
                    <ul role="list" class="mt-6 space-y-6">
                      <li class="text-sm">
                        <a href="#" class="text-gray-500 hover:text-gray-600"> Bags </a>
                      </li>

                      <li class="text-sm">
                        <a href="#" class="text-gray-500 hover:text-gray-600"> Tees </a>
                      </li>

                      <li class="text-sm">
                        <a href="#" class="text-gray-500 hover:text-gray-600"> Objects </a>
                      </li>

                      <li class="text-sm">
                        <a href="#" class="text-gray-500 hover:text-gray-600"> Home Goods </a>
                      </li>

                      <li class="text-sm">
                        <a href="#" class="text-gray-500 hover:text-gray-600"> Accessories </a>
                      </li>
                    </ul>
                  </div>
                  <div>
                    <h3 class="text-sm font-medium text-gray-900">Customer Service</h3>
                    <ul role="list" class="mt-6 space-y-6">
                      <li class="text-sm">
                        <a href="#" class="text-gray-500 hover:text-gray-600"> Contact </a>
                      </li>

                      <li class="text-sm">
                        <a href="#" class="text-gray-500 hover:text-gray-600"> Shipping </a>
                      </li>

                      <li class="text-sm">
                        <a href="#" class="text-gray-500 hover:text-gray-600"> Returns </a>
                      </li>

                      <li class="text-sm">
                        <a href="#" class="text-gray-500 hover:text-gray-600"> Warranty </a>
                      </li>

                      <li class="text-sm">
                        <a href="#" class="text-gray-500 hover:text-gray-600"> Secure Payments </a>
                      </li>

                      <li class="text-sm">
                        <a href="#" class="text-gray-500 hover:text-gray-600"> FAQ </a>
                      </li>

                      <li class="text-sm">
                        <a href="#" class="text-gray-500 hover:text-gray-600"> Find a store </a>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="space-y-12 md:space-y-0 md:grid md:grid-cols-2 md:gap-8">
                  <div>
                    <h3 class="text-sm font-medium text-gray-900">Company</h3>
                    <ul role="list" class="mt-6 space-y-6">
                      <li class="text-sm">
                        <a href="#" class="text-gray-500 hover:text-gray-600"> Who we are </a>
                      </li>

                      <li class="text-sm">
                        <a href="#" class="text-gray-500 hover:text-gray-600"> Sustainability </a>
                      </li>

                      <li class="text-sm">
                        <a href="#" class="text-gray-500 hover:text-gray-600"> Press </a>
                      </li>

                      <li class="text-sm">
                        <a href="#" class="text-gray-500 hover:text-gray-600"> Careers </a>
                      </li>

                      <li class="text-sm">
                        <a href="#" class="text-gray-500 hover:text-gray-600"> Terms &amp; Conditions </a>
                      </li>

                      <li class="text-sm">
                        <a href="#" class="text-gray-500 hover:text-gray-600"> Privacy </a>
                      </li>
                    </ul>
                  </div>
                  <div>
                    <h3 class="text-sm font-medium text-gray-900">Legal</h3>
                    <ul role="list" class="mt-6 space-y-6">
                      <li class="text-sm">
                        <a href="#" class="text-gray-500 hover:text-gray-600"> Terms of Service </a>
                      </li>

                      <li class="text-sm">
                        <a href="#" class="text-gray-500 hover:text-gray-600"> Return Policy </a>
                      </li>

                      <li class="text-sm">
                        <a href="#" class="text-gray-500 hover:text-gray-600"> Privacy Policy </a>
                      </li>

                      <li class="text-sm">
                        <a href="#" class="text-gray-500 hover:text-gray-600"> Shipping Policy </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="lg:grid lg:grid-cols-2 lg:gap-x-6 xl:gap-x-8">
            <div class="bg-gray-100 rounded-lg p-6 flex items-center sm:p-10">
              <div class="max-w-sm mx-auto">
                <h3 class="font-semibold text-gray-900">Sign up for our newsletter</h3>
                <p class="mt-2 text-sm text-gray-500">The latest news, articles, and resources, sent to your inbox weekly.</p>
                <form class="mt-4 sm:mt-6 sm:flex">
                  <label for="email-address" class="sr-only">Email address</label>
                  <input id="email-address" type="text" autocomplete="email" required class="appearance-none min-w-0 w-full bg-white border border-gray-300 rounded-md shadow-sm py-2 px-4 text-base text-gray-900 placeholder-gray-500 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                  <div class="mt-3 sm:flex-shrink-0 sm:mt-0 sm:ml-4">
                    <button type="submit" class="w-full bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 flex items-center justify-center text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-indigo-500">Sign up</button>
                  </div>
                </form>
              </div>
            </div>

            <div class="mt-6 relative py-12 px-6 flex items-center sm:py-16 sm:px-10 lg:mt-0">
              <div class="absolute inset-0 rounded-lg overflow-hidden">
                <img src="https://tailwindui.com/img/ecommerce-images/footer-02-exclusive-sale.jpg" alt="" class="w-full h-full filter saturate-0 object-center object-cover">
                <div class="absolute inset-0 bg-indigo-600 bg-opacity-90"></div>
              </div>
              <div class="relative max-w-sm mx-auto text-center">
                <h3 class="text-2xl font-extrabold tracking-tight text-white">Get early access</h3>
                <p class="mt-2 text-gray-200">
                  Did you sign up to the newsletter? If so, use the keyword we sent you to get access. <a href="#" class="font-bold text-white whitespace-nowrap hover:text-gray-200">Go now<span aria-hidden="true"> &rarr;</span></a>
                </p>
              </div>
            </div>
          </div>
        </div>

        <div class="py-10 md:flex md:items-center md:justify-between">
          <div class="text-center md:text-left">
            <p class="text-sm text-gray-500">&copy; 2021 All Rights Reserved</p>
          </div>

          <div class="mt-4 flex items-center justify-center md:mt-0">
            <div class="flex space-x-8">
              <a href="#" class="text-sm text-gray-500 hover:text-gray-600"> Accessibility </a>

              <a href="#" class="text-sm text-gray-500 hover:text-gray-600"> Privacy </a>

              <a href="#" class="text-sm text-gray-500 hover:text-gray-600"> Terms </a>
            </div>

            <div class="ml-6 border-l border-gray-200 pl-6">
              <a href="#" class="flex items-center text-gray-500 hover:text-gray-600">
                <img src="https://tailwindui.com/img/flags/flag-canada.svg" alt="" class="w-5 h-auto flex-shrink-0">
                <span class="ml-3 text-sm"> Change </span>
                <span class="sr-only">location and currency</span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </footer>
  </div>


@endsection