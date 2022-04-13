@extends('frontend.layouts.' . $globalLayout)

@section('content')
<!--
  This example requires updating your template:

  ```
  <html class="h-full bg-gray-100">
  <body class="h-full">
  ```
-->
<div>
    <!-- Off-canvas menu for mobile, show/hide based on off-canvas menu state. -->
    <div class="fixed inset-0 flex z-40 md:hidden" role="dialog" aria-modal="true" x-data="{
        show: false,
    }" x-cloak x-show="show" @sidebar-show.window="show = !show">
        <!--
        Off-canvas menu overlay, show/hide based on off-canvas menu state.

        Entering: "transition-opacity ease-linear duration-300"
          From: "opacity-0"
          To: "opacity-100"
        Leaving: "transition-opacity ease-linear duration-300"
          From: "opacity-100"
          To: "opacity-0"
      -->
        <div class="hidden fixed inset-0 bg-gray-600 bg-opacity-75" aria-hidden="true"
                @click="show = false"
                x-transition:enter="transform ease-in-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100 "
                x-transition:leave="transition ease-in-out duration-300"
                x-transition:leave-start="opacity-100 "
                x-transition:leave-end="opacity-0"></div>

        <!--
        Off-canvas menu, show/hide based on off-canvas menu state.

        Entering: "transition ease-in-out duration-300 transform"
          From: "-translate-x-full"
          To: "translate-x-0"
        Leaving: "transition ease-in-out duration-300 transform"
          From: "translate-x-0"
          To: "-translate-x-full"
      -->
        <div class="relative flex-1 flex flex-col max-w-xs w-full pt-2 pb-5 bg-white max-h-[100%] overflow-x-hidden overflow-y-auto"
                x-show="show"
                x-transition:enter="transform transition ease-in-out duration-300 sm:duration-300"
                x-transition:enter-start="translate-x-[-100%]"
                x-transition:enter-end="translate-x-0 "
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="translate-x-0 "
                x-transition:leave-end="translate-x-[-100%]">
            <!--
          Close button, show/hide based on off-canvas menu state.

          Entering: "ease-in-out duration-300"
            From: "opacity-0"
            To: "opacity-100"
          Leaving: "ease-in-out duration-300"
            From: "opacity-100"
            To: "opacity-0"
        -->
            <div class="absolute top-[12px] right-[12px]">
                <button type="button"
                    @click="show = false"
                    class="ml-1 flex items-center justify-center h-10 w-10 text-gray-900 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                    @svg('heroicon-o-x', ['class' => 'h-6 w-6 text-gray-600'])
                </button>
            </div>

            <div class="flex items-center flex-shrink-0 px-2">
                <a href="{{ route('home') }} ">
                    <x-tenant.system.image alt="{{ get_site_name() }} logo" class="min-h-8 w-full mx-auto sm:min-h-10 max-w-[150px]"
                        :image="get_site_logo()">
                    </x-tenant.system.image>
                </a>
            </div>

            <div class="flex-1 flex flex-col overflow-y-auto">
                @include('frontend.dashboard.navigation.sidebar')

            </div>
        </div>

        <div class="flex-shrink-0 w-14" aria-hidden="true" @click="show = false;">
            <!-- Dummy element to force sidebar to shrink to fit close icon -->
        </div>
    </div>


    <!-- Static sidebar for desktop -->
    <div
        class="we-dashboard-sidebar-background hidden lg:flex lg:flex-col lg:w-64 lg:fixed lg:inset-y-0 lg:border-r lg:border-gray-200 lg:pt-5 lg:pb-4 lg:bg-gray-100">
        <div class="flex items-center flex-shrink-0 px-6">
            <a href="{{ route('home') }} ">
                <x-tenant.system.image alt="{{ get_site_name() }} logo" class="min-h-8 w-full mx-auto sm:min-h-10"
                    :image="get_site_logo()">
                </x-tenant.system.image>
            </a>
        </div>

        <div class="mt-6 h-0 flex-1 flex flex-col overflow-y-auto">
            <!-- User account dropdown -->
            <div class="px-3 relative inline-block text-left">
                <div>
                    <button type="button"
                        class="group w-full bg-gray-100/60 rounded-md px-3.5 py-2 text-sm text-left font-medium text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-purple-500"
                        id="options-menu-button" aria-expanded="false" aria-haspopup="true">
                        <span class="flex w-full justify-between items-center">
                            <span class="flex min-w-0 items-center justify-between space-x-3">
                                <img class="w-10 h-10 bg-gray-300 rounded-full flex-shrink-0"
                                    src="{{ Auth::user()->getThumbnail() }}"
                                    alt="">
                                <span class="flex-1 flex flex-col min-w-0">
                                    <span class="text-gray-900 text-sm font-medium truncate">
                                        {{ Auth::user()->name }}</span>
                                    <span class="text-gray-700 text-sm truncate">
                                        {{ Auth::user()->email }}
                                    </span>
                                </span>
                            </span>

                        </span>
                    </button>
                </div>

                {{--
                <!--
                Dropdown menu, show/hide based on menu state.

                Entering: "transition ease-out duration-100"
                    From: "transform opacity-0 scale-95"
                    To: "transform opacity-100 scale-100"
                Leaving: "transition ease-in duration-75"
                    From: "transform opacity-100 scale-100"
                    To: "transform opacity-0 scale-95"
                -->
                <div class="z-10 mx-3 origin-top absolute right-0 left-0 mt-1 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-200 focus:outline-none"
                    role="menu" aria-orientation="vertical" aria-labelledby="options-menu-button" tabindex="-1">
                    <div class="py-1" role="none">
                        <!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->
                        <a href="#" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1"
                            id="options-menu-item-0">View profile</a>
                        <a href="#" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1"
                            id="options-menu-item-1">Settings</a>
                        <a href="#" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1"
                            id="options-menu-item-2">Notifications</a>
                    </div>
                    <div class="py-1" role="none">
                        <a href="#" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1"
                            id="options-menu-item-3">Get desktop app</a>
                        <a href="#" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1"
                            id="options-menu-item-4">Support</a>
                    </div>
                    <div class="py-1" role="none">
                        <a href="#" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1"
                            id="options-menu-item-5">Logout</a>
                    </div>
                </div> --}}
            </div>


            @include('frontend.dashboard.navigation.sidebar')
        </div>
    </div>
    <!-- END: Static sidebar for desktop -->

    <div class="lg:pl-64 flex flex-col">
        @include('frontend.dashboard.navigation.topbar')

        <main class="flex-1">
            <div class="py-6">
                {{-- <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                    <h1 class="text-2xl font-semibold text-gray-900"></h1>
                </div> --}}
                <div class="w-full px-4 sm:px-6 md:px-8">
                    @yield('panel_content')
                </div>
            </div>
        </main>

    </div>
</div>
@endsection
