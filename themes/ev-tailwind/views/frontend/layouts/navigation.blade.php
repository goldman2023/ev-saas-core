<nav class="bg-white border-b border-gray-100"
     x-data="{ open_mobile: false }"
     @main-navigation-dropdown-hide.window="open_mobile = false">
    <!-- Primary Navigation Menu -->
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 text-gray-500 hover:text-gray-700 text-sm font-medium leading-5">
            <div class="flex w-full">
                <!-- Logo -->
                <div class="flex items-center flex-shrink-0">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="block w-auto h-10 text-gray-600 fill-current"/>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    @if (get_setting('header_menu_labels') != null)
                        @foreach (json_decode(get_setting('header_menu_labels'), true) as $key => $value)
                            @php
                                $target = "_self";
                            @endphp
                            <a href="{{ json_decode(get_setting('header_menu_links'), true)[$key] }}"
                               class="inline-flex items-center px-1 pt-1  focus:outline-none"
                               target="{{$target}}">
                                {{ translate($value) }}
                            </a>
                        @endforeach
                    @endif
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-join-button></x-join-button>
                </div>

                <div class="flex items-center ml-auto">
                    <div class="inline-flex items-center px-1 pt-1 h-full focus:outline-none lg:relative lg:ml-8">
                        <button type="button" class="group -m-2 p-2 flex items-center" aria-expanded="false"
                                @click="$dispatch('toggle-mini-cart')">
                            <!-- Heroicon name: outline/shopping-bag -->
                            <svg class="flex-shink-0 h-6 w-6 text-gray-400 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <span class="ml-2 text-sm font-medium text-gray-700 group-hover:text-gray-800"
                                  x-data="{count:{{ Session::has('cart') ? count(Session::get('cart')) : 0 }}}"
                                  x-text="count"
                                  @update-cart-items-count.window="count = $event.detail;">

                            </span>
                            <span class="sr-only">items in cart, view bag</span>
                        </button>


                        @if($cart_mini_template = get_setting('cart_mini_template'))
                            @php $name = 'mini.'.$cart_mini_template; @endphp
                            <livewire:cart :template="$name" />
                        @endif
                    </div>

                    <div class="md:hidden inline-flex items-center px-1 pt-1 -mr-2 focus:outline-none">
                        <button type="button" class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none " aria-expanded="false"
                                :class="{ 'text-gray-900': open_mobile, 'text-gray-500': !open_mobile }" @click="open_mobile = !open_mobile">
                            <span class="sr-only">Open menu</span>
                            <!-- Heroicon name: outline/menu -->
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>

            </div>

            <!--
              Mobile menu, show/hide based on mobile menu state.
            -->
            <div class="absolute top-0 inset-x-0 p-2 transition transform origin-top-right md:hidden z-50"
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
                            <a href="{{ route('home') }}" class="block">
                                <x-application-logo class="block w-auto h-10 text-gray-600 fill-current"/>
                            </a>
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
                                            <!--<div class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-md bg-indigo-500 text-white">
                                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                                </svg>
                                            </div>-->
                                            <div class="text-base font-medium text-gray-900">
                                                {{ translate($value) }}
                                            </div>
                                        </a>
                                    @endforeach
                                @endif
                            </nav>
                        </div>
                    </div>
                    <div class="py-6 px-5">
                        <!--<div class="grid grid-cols-2 gap-4">
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
                        </div>-->
                        <div class="mt-2">
                            <x-join-button class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700"></x-join-button>

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
        </div>
    </div>
</nav>
