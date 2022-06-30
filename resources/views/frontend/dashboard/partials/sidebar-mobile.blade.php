{{-- Dashboard Sidebar Menu Mobile  --}}
<x-panels.flyout-panel id="dashboard-sidebar-panel">
    <div class="flex flex-col mb-1 grow">
        <div class="mt-3 flex flex-col">
            <div class="w-full flex items-center flex-shrink-0 px-6 mb-6">
                <a href="{{ route('home') }} ">
                    <x-tenant.system.image alt="{{ get_site_name() }} logo" class="lazyload min-h-8 w-[60%] lg:w-full mx-auto sm:min-h-10"
                        :image="get_site_logo()">
                    </x-tenant.system.image>
                </a>
            </div>

            <div class="w-full">
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

            @include('frontend.dashboard.navigation.sidebar-menu')
        </div>
    </div>
</x-panels.flyout-panel>
{{-- END Dashboard Sidebar Menu Mobile --}}
