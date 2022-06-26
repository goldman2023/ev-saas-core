@php
    $header_menu = nova_get_menu_by_slug('header');
    $header_menu_items = $header_menu['menuItems'] ?? null;
@endphp
<header class="" x-data="{
    show_mobile_menu: false,
}">
    {{-- Header settings should include Background among other things + Sticky behavior (yes/no) --}}
    <div class="relative bg-transparent z-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-5">
            <div class="flex justify-between items-center py-6 md:justify-start md:space-x-10">
                <div class="flex justify-start lg:w-0 lg:flex-1">
                    <a href="{{ route('home') }}">
                        <x-tenant.system.image alt="{{ get_site_name() }} logo" class="h-8 w-auto sm:h-10"
                            :image="get_site_logo()">
                        </x-tenant.system.image>
                    </a>
                </div>

                <div class="-mr-2 -my-2 md:hidden">
                    <button type="button"
                        class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
                        @click="show_mobile_menu = !show_mobile_menu">
                        @svg('heroicon-o-menu', ['class' => 'h-6 w-6'])
                    </button>
                </div>

                <nav class="hidden md:flex space-x-[32px]">
                    @if(!empty($header_menu_items) && $header_menu_items->isNotEmpty())
                        @foreach($header_menu_items as $menu_item)
                            @if($menu_item['enabled'])
                                <a href="{{ $menu_item['value'] ?? '#' }}" target="{{ $menu_item['target'] ?? '_self' }}" class="text-base font-medium text-gray-500 hover:text-gray-900">
                                    {{ $menu_item['name'] ?? '' }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                </nav>

                {{-- TODO: Create Dashboard button (similar to 'Try for free') if user is authenticated, otherwise
                display Login and Try for free --}}
                <div class="hidden md:flex items-center justify-end md:flex-1 lg:w-0 space-x-[32px]">
                    @guest
                        <div class="cursor-pointer whitespace-nowrap text-base font-medium text-gray-500 hover:text-gray-900"
                            @click="$dispatch('display-flyout-panel', {'id': 'auth-panel'})">
                            {{ translate('Login') }}
                        </div>

                        <a href="{{ route('custom-pages.show_custom_page', ['plans-pricing']) }}"
                            class="bg-white text-primary rounded-[6px] shadow-lg px-[19px] py-[9px] text-16 font-semibold">
                            {{ translate('Try for free') }}
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}"
                            class="bg-white text-primary rounded-[6px] shadow-lg px-[19px] py-[9px] text-16 font-semibold">
                            {{ translate('Dashboard') }}
                        </a>
                    @endguest
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
                        <div>
                            {{-- <x-tenant.system.image alt="{{ get_site_name() }} logo"
                                class="block lg:hidden h-8 w-auto" :image="get_setting('header_logo')">
                            </x-tenant.system.image> --}}
                            <x-tenant.system.image alt="{{ get_site_name() }} logo" class="h-8 w-auto"
                                :image="get_site_logo()">
                            </x-tenant.system.image>
                        </div>
                        <div class="-mr-2">
                            <button type="button"
                                class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
                                @click="show_mobile_menu = false">
                                @svg('heroicon-o-x', ['class' => 'h-6 w-6'])
                            </button>
                        </div>
                    </div>

                    <div class="mt-6">
                        <nav class="grid gap-y-8">
                            @if(!empty($header_menu_items) && $header_menu_items->isNotEmpty())
                                @foreach($header_menu_items as $menu_item)
                                    @if($menu_item['enabled'])
                                        <a href="{{ $menu_item['value'] ?? '#' }}" target="{{ $menu_item['target'] ?? '_self' }}" class="-m-3 p-3 flex items-center rounded-md hover:bg-gray-50">
                                            {{ $menu_item['name'] ?? '' }}
                                        </a>
                                    @endif
                                @endforeach
                            @endif
                        </nav>
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
                            <a href="#" @click="$dispatch('display-flyout-panel', {'id': 'auth-panel'})"
                                class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-primary hover:bg-primary-hover">
                                {{ translate('Login') }}
                            </a>
                            <p class="mt-6 text-center text-base font-medium text-gray-500">
                                {{ translate('Wanna try it out for free') }}?
                                <a href="{{ route('user.login') }}" class="text-primary hover:text-primary-hover"> {{ translate('Get a Trial') }}
                                </a>
                            </p>
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
