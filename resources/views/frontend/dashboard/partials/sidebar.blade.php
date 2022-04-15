<!-- Static sidebar for desktop -->
<div class="we-dashboard-sidebar-background hidden lg:flex lg:flex-col lg:w-64 lg:fixed lg:inset-y-0 lg:border-r lg:border-gray-200 lg:pt-5 lg:pb-4 lg:bg-gray-100">
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


        @include('frontend.dashboard.navigation.sidebar-menu')
    </div>
</div>
<!-- END: Static sidebar for desktop -->