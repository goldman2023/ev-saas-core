@php
    $header_menu = nova_get_menu_by_slug('header');
    $header_menu_items = $header_menu['menuItems'] ?? null;
@endphp
<header class="relative z-[9990]" x-data="{
    show_mobile_menu: false,
}">
    {{-- Header settings should include Background among other things + Sticky behavior (yes/no) --}}
    <div class="py-8 bg-transparent z-10 absolute w-full left-0 top-0">
        <div class="container mx-auto px-4 sm:px-5">
            <div class="flex h-9 items-center justify-between">
                <div class="flex">
                    <a href="{{ route('home') }}">
                        <x-tenant.system.image alt="{{ get_site_name() }} logo"
                         height="32px"
                         width="145px"
                        class="h-8 w-auto sm:h-10"
                            :image="get_site_logo()">
                        </x-tenant.system.image>
                    </a>
                </div>



                <nav class="hidden md:flex space-x-[32px]">
                  <x-system.menus.default-menu menu="header"></x-system.menus.default-menu>
                </nav>

                <div class="-mr-2 -my-2">
                    <button type="button"
                        aria-labelledby="Mobile menu button"
                        class="hidden bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
                        @click="show_mobile_menu = !show_mobile_menu">
                        @svg('heroicon-o-bars-3', ['class' => 'h-6 w-6'])
                    </button>
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
        <div class="absolute top-0 inset-x-0 p-2 transition transform origin-top-right md:hidden z-[20]"
            x-show="show_mobile_menu" x-transition:enter="ease-out duration-200"
            x-cloak
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-100" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95">
            <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 bg-white divide-y-2 divide-gray-50">
                <div class="pt-5 pb-6 px-5 border-b">
                    <div class="flex items-center justify-between">
                        <a href="{{ route('home') }}">
                            <x-tenant.system.image alt="{{ get_site_name() }} logo" class="h-8 w-auto"
                                :image="get_site_logo()">
                            </x-tenant.system.image>
                        </a>
                        <div class="-mr-2">
                            <button type="button"
                                class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
                                @click="show_mobile_menu = false">
                                @svg('heroicon-o-x-mark', ['class' => 'h-6 w-6'])
                            </button>
                        </div>
                    </div>

                    <div class="mt-6">
                        <x-system.render-menu :menu="$header_menu_items"></x-system.render-menu>
                    </div>
                </div>


                <div class="py-6 px-5 space-y-6">
                    {{-- <div class="grid grid-cols-2 gap-y-4 gap-x-8">
                        <a href="#" class="text-base font-medium text-gray-900 hover:text-gray-700"> Pricing </a>

                        <a href="#" class="text-base font-medium text-gray-900 hover:text-gray-700"> Docs </a>

                        <a href="#" class="text-base font-medium text-gray-900 hover:text-gray-700"> Help Center </a>

                        <a href="#" class="text-base font-medium text-gray-900 hover:text-gray-700"> Guides </a>

                        <a href="#" class="text-base font-medium text-gray-900 hover:text-gray-700"> Events </a>

                        <a href="#" class="text-base font-medium text-gray-900 hover:text-gray-700"> Security </a>
                    </div> --}}
                    <div>

                        @guest

                        @else
                            <a href="{{ route('dashboard') }}" class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-primary hover:bg-primary-hover">
                                {{ translate('Dashboard') }}
                            </a>
                        @endguest

                    </div>
                </div>

            </div>
        </div>
    </div>
</header>
