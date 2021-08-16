<!-- This example requires Tailwind CSS v2.0+ -->
<nav class="relative bg-white" x-data="{ open_mobile: false }" >
    <div class="flex justify-between items-center px-4 py-6 sm:px-6 md:justify-start md:space-x-10">
        <div>
            <a href="{{ route('home') }}" class="flex">
                <x-application-logo class="block w-auto h-10 text-gray-600 fill-current"/>
            </a>
        </div>
        <div class="-mr-2 -my-2 md:hidden">
            <button type="button" class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none " aria-expanded="false"
                    :class="{ 'text-gray-900': open_mobile, 'text-gray-500': !open_mobile }" @click="open_mobile = !open_mobile">
                <span class="sr-only">Open menu</span>
                <!-- Heroicon name: outline/menu -->
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
        <div class="hidden md:flex-1 md:flex md:items-center md:justify-between">
            <nav class="flex space-x-10">
                <div class="relative" x-data="{open:false}">
                    <!-- Item active: "text-gray-900", Item inactive: "text-gray-500" -->
                    <button type="button" class="group bg-white rounded-md inline-flex items-center text-base font-medium hover:text-gray-900 focus:outline-none " aria-expanded="false"
                         :class="{ 'text-gray-900': open, 'text-gray-500': !open }" @click="open = !open">
                        <span>Solutions</span>
                        <!--
                          Heroicon name: solid/chevron-down

                          Item active: "text-gray-600", Item inactive: "text-gray-400"
                        -->
                        <svg class="text-gray-400 ml-2 h-5 w-5 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <!--
                      'Solutions' flyout menu, show/hide based on flyout menu state.

                      Entering: "transition ease-out duration-200"
                        From: "opacity-0 translate-y-1"
                        To: "opacity-100 translate-y-0"
                      Leaving: "transition ease-in duration-150"
                        From: "opacity-100 translate-y-0"
                        To: "opacity-0 translate-y-1"
                    -->
                    <div class="absolute z-10 -ml-4 mt-3 transform w-screen max-w-md lg:max-w-3xl"
                         x-show="open"
                         x-transition:enter="duration-200 ease-out"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="duration-150 ease-in"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-1"
                    >
                        <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 overflow-hidden">
                            <div class="relative grid gap-6 bg-white px-5 py-6 sm:gap-8 sm:p-8 lg:grid-cols-2">
                                @if (get_setting('header_menu_labels') != null)
                                    @foreach (json_decode(get_setting('header_menu_labels'), true) as $key => $value)
                                        @php
                                            $url = json_decode(get_setting('header_menu_links'), true)[$key];
                                            $target = "_self";
                                        @endphp
                                        <a href="{{ $url }}" class="-m-3 p-3 flex items-start rounded-lg hover:bg-gray-50" target="{{ $target }}">
                                            <div class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-md bg-indigo-500 text-white sm:h-12 sm:w-12">
                                                <!-- Heroicon name: outline/chart-bar -->
                                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-base font-medium text-gray-900">
                                                    {{ translate($value) }}
                                                </p>
                                                <p class="mt-1 text-sm text-gray-500">
                                                    {{-- TODO: Merge header_menu_labels and header_menu_links as one row in business_settings 'header_menu' and add subtitles in admin panel! Current logic sucks... --}}
                                                    Get a better understanding of where your traffic is coming from.
                                                </p>
                                            </div>
                                        </a>
                                    @endforeach
                                @endif
                            </div>
                            <div class="p-5 bg-gray-50 sm:p-8">
                                <a href="#" class="-m-3 p-3 flow-root rounded-md hover:bg-gray-100">
                                    <div class="flex items-center">
                                        <div class="text-base font-medium text-gray-900">
                                            {{ translate('Enterprise') }}
                                        </div>
                                        <span class="ml-3 inline-flex items-center px-3 py-0.5 rounded-full text-xs font-medium leading-5 bg-indigo-100 text-indigo-800">
                                          {{ translate('New') }}
                                        </span>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-500">
                                        {{ translate('Focus on business, not development!') }}
                                    </p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="#" class="text-base font-medium text-gray-500 hover:text-gray-900">
                    {{ translate('News') }}
                </a>
                <a href="#" class="text-base font-medium text-gray-500 hover:text-gray-900">
                    {{ translate('Pricing') }}
                </a>
                <a href="#" class="text-base font-medium text-gray-500 hover:text-gray-900">
                    {{ translate('Docs') }}
                </a>


                <div class="relative" x-data="{open:false}">
                    <!-- Item active: "text-gray-900", Item inactive: "text-gray-500" -->
                    <button type="button" class="text-gray-500 group bg-white rounded-md inline-flex items-center text-base font-medium hover:text-gray-900 focus:outline-none" aria-expanded="false"
                            :class="{ 'text-gray-900': open, 'text-gray-500': !open }" @click="open = !open">
                        <span>More</span>
                        <!--
                          Heroicon name: solid/chevron-down

                          Item active: "text-gray-600", Item inactive: "text-gray-400"
                        -->
                        <svg class="text-gray-400 ml-2 h-5 w-5 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <!--
                      'More' flyout menu, show/hide based on flyout menu state.

                      Entering: "transition ease-out duration-200"
                        From: "opacity-0 translate-y-1"
                        To: "opacity-100 translate-y-0"
                      Leaving: "transition ease-in duration-150"
                        From: "opacity-100 translate-y-0"
                        To: "opacity-0 translate-y-1"
                    -->
                    <div class="absolute z-10 left-1/2 transform -translate-x-1/2 mt-3 px-2 w-screen max-w-xs sm:px-0"
                         x-show="open"
                         x-transition:enter="duration-200 ease-out"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="duration-150 ease-in"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-1"
                    >
                        <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 overflow-hidden">
                            <div class="relative grid gap-6 bg-white px-5 py-6 sm:gap-8 sm:p-8">
                                <a href="#" class="-m-3 p-3 block rounded-md hover:bg-gray-50">
                                    <p class="text-base font-medium text-gray-900">
                                        {{ translate('Support Desk') }}
                                    </p>
                                    <p class="mt-1 text-sm text-gray-500">
                                        {{ translate('Get all of your questions answered in our support desk.') }}
                                    </p>
                                </a>

                                <a href="#" class="-m-3 p-3 block rounded-md hover:bg-gray-50">
                                    <p class="text-base font-medium text-gray-900">
                                        {{ translate('Guides') }}
                                    </p>
                                    <p class="mt-1 text-sm text-gray-500">
                                        {{ translate('Learn how to maximize our platform to get the most out of it.') }}
                                    </p>
                                </a>

                                <a href="#" class="-m-3 p-3 block rounded-md hover:bg-gray-50">
                                    <p class="text-base font-medium text-gray-900">
                                        {{ translate('Events') }}
                                    </p>
                                    <p class="mt-1 text-sm text-gray-500">
                                        {{ translate('See what meet-ups and other events we might be planning near you.') }}
                                    </p>
                                </a>

                                <a href="#" class="-m-3 p-3 block rounded-md hover:bg-gray-50">
                                    <p class="text-base font-medium text-gray-900">
                                        {{ translate('Security') }}
                                    </p>
                                    <p class="mt-1 text-sm text-gray-500">
                                        {{ translate('Understand how we take your privacy seriously.') }}
                                    </p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
            <div class="flex items-center md:ml-12">
                <a href="#" class="text-base font-medium text-gray-500 hover:text-gray-900">
                    {{ translate('Log in') }}
                </a>
                <a href="#" class="ml-8 inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                    {{ translate('Register') }}
                </a>
            </div>
        </div>
    </div>

    <!--
      Mobile menu, show/hide based on mobile menu state.

      Entering: "duration-200 ease-out"
        From: "opacity-0 scale-95"
        To: "opacity-100 scale-100"
      Leaving: "duration-100 ease-in"
        From: "opacity-100 scale-100"
        To: "opacity-0 scale-95"
    -->
    <div class="absolute top-0 inset-x-0 p-2 transition transform origin-top-right md:hidden"
         x-show="open_mobile"
         x-transition:enter="duration-200 ease-out"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="duration-100 ease-in"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95">
        <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 bg-white divide-y-2 divide-gray-50">
            <div class="pt-5 pb-6 px-5">
                <div class="flex items-center justify-between">
                    <div>
                        <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg" alt="Workflow">
                    </div>
                    <div class="-mr-2">
                        <button type="button" class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none"
                                @click="open_mobile = !open_mobile">
                            <span class="sr-only">Close menu</span>
                            <!-- Heroicon name: outline/x -->
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="mt-6">
                    <nav class="grid gap-6">
                        @if (get_setting('header_menu_labels') != null)
                            @foreach (json_decode(get_setting('header_menu_labels'), true) as $key => $value)
                                @php
                                    $url = json_decode(get_setting('header_menu_links'), true)[$key];
                                    $target = "_self";
                                @endphp
                                <a href="{{ $url }}" class="-m-3 p-3 flex items-center rounded-lg hover:bg-gray-50" target="{{ $target }}">
                                    <div class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-md bg-indigo-500 text-white">
                                        <!-- Heroicon name: outline/chart-bar -->
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4 text-base font-medium text-gray-900">
                                        {{ translate($value) }}
                                    </div>
                                </a>
                            @endforeach
                        @endif
                    </nav>
                </div>
            </div>
            <div class="py-6 px-5">
                <div class="grid grid-cols-2 gap-4">
                    <a href="#" class="text-base font-medium text-gray-900 hover:text-gray-700">
                        {{ translate('News') }}
                    </a>
                    <a href="#" class="text-base font-medium text-gray-900 hover:text-gray-700">
                        {{ translate('Pricing') }}
                    </a>
                    <a href="#" class="text-base font-medium text-gray-900 hover:text-gray-700">
                        {{ translate('Docs') }}
                    </a>

                    <a href="#" class="text-base font-medium text-gray-900 hover:text-gray-700">
                        {{ translate('Support Desk') }}
                    </a>

                    <a href="#" class="text-base font-medium text-gray-900 hover:text-gray-700">
                        {{ translate('Guides') }}
                    </a>

                    <a href="#" class="text-base font-medium text-gray-900 hover:text-gray-700">
                        {{ translate('Events') }}
                    </a>

                    <a href="#" class="text-base font-medium text-gray-900 hover:text-gray-700">
                        {{ translate('Security') }}
                    </a>
                </div>
                <div class="mt-6">
                    <a href="#" class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                        {{ translate('Register') }}
                    </a>
                    <p class="mt-6 text-center text-base font-medium text-gray-500">
                        {{ translate('Existing customer?') }}
                        <a href="#" class="text-indigo-600 hover:text-indigo-500">
                            {{ translate('Log in') }}
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</nav>
