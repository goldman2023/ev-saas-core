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
                        @foreach (get_setting('header_menu_labels') as $key => $value)
                            @php
                                $target = "_self";
                            @endphp
                            <a href="{{ get_setting('header_menu_links')[$key] }}"
                               class="inline-flex items-center px-1 pt-1  focus:outline-none"
                               target="{{$target}}">
                                {{ translate($value) }}
                            </a>
                        @endforeach
                    @endif
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                </div>

                <div class="flex items-center ml-auto">


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
                                    @foreach (get_setting('header_menu_labels') as $key => $value)
                                        @php
                                            $url = get_setting('header_menu_links')[$key];
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
                        <div class="mt-2">


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
