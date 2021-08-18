<!-- This example requires Tailwind CSS v2.0+ -->
<div class="z-0 relative">


    <!--
      Flyout menu, show/hide based on flyout menu state.

      Entering: "transition ease-out duration-200"
        From: "opacity-0 -translate-y-1"
        To: "opacity-100 translate-y-0"
      Leaving: "transition ease-in duration-150"
        From: "opacity-100 translate-y-0"
        To: "opacity-0 -translate-y-1"
    -->
    <div class=" z-10 inset-x-0 transform shadow-lg">
        <div class="absolute inset-0 flex" aria-hidden="true">
            <div class="bg-white w-1/2"></div>
            <div class="bg-gray-50 w-1/2"></div>
        </div>
        <livewire:home-search />
        <div class="relative max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2">
            <nav class="grid gap-y-10 px-4 py-8 bg-white sm:grid-cols-2 sm:gap-x-8 sm:py-12 sm:px-6 lg:px-8 xl:pr-12" aria-labelledby="solutions-heading">
                <h2 id="solutions-heading" class="sr-only">Solutions menu</h2>
                <div>
                    <h3 class="text-sm font-medium tracking-wide text-gray-500 uppercase">
                        Company
                    </h3>
                    <ul class="mt-5 space-y-6">
                        <li class="flow-root">
                            <a href="#" class="-m-3 p-3 flex items-center rounded-md text-base font-medium text-gray-900 hover:bg-gray-50 transition ease-in-out duration-150">
                                <!-- Heroicon name: outline/information-circle -->
                                <svg class="flex-shrink-0 h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="ml-4">About</span>
                            </a>
                        </li>

                        <li class="flow-root">
                            <a href="#" class="-m-3 p-3 flex items-center rounded-md text-base font-medium text-gray-900 hover:bg-gray-50 transition ease-in-out duration-150">
                                <!-- Heroicon name: outline/office-building -->
                                <svg class="flex-shrink-0 h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                <span class="ml-4">Customers</span>
                            </a>
                        </li>

                        <li class="flow-root">
                            <a href="#" class="-m-3 p-3 flex items-center rounded-md text-base font-medium text-gray-900 hover:bg-gray-50 transition ease-in-out duration-150">
                                <!-- Heroicon name: outline/newspaper -->
                                <svg class="flex-shrink-0 h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                </svg>
                                <span class="ml-4">Press</span>
                            </a>
                        </li>

                        <li class="flow-root">
                            <a href="#" class="-m-3 p-3 flex items-center rounded-md text-base font-medium text-gray-900 hover:bg-gray-50 transition ease-in-out duration-150">
                                <!-- Heroicon name: outline/briefcase -->
                                <svg class="flex-shrink-0 h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span class="ml-4">Careers</span>
                            </a>
                        </li>

                        <li class="flow-root">
                            <a href="#" class="-m-3 p-3 flex items-center rounded-md text-base font-medium text-gray-900 hover:bg-gray-50 transition ease-in-out duration-150">
                                <!-- Heroicon name: outline/shield-check -->
                                <svg class="flex-shrink-0 h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                <span class="ml-4">Privacy</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="bg-gray-50">
                <div>
                    <img src="https://media.winefolly.com/blue-apron-wine-club-review-winefolly.jpg" />
                </div>

            </div>
        </div>
    </div>
</div>
