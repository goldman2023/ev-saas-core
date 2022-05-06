<nav aria-label="Sidebar" class="sticky top-4 divide-y divide-gray-300">
    <div class="pb-8 space-y-1">
        <!-- Current: "bg-gray-200 text-gray-900", Default: "text-gray-600 hover:bg-gray-50" -->
        <a href="{{ route('feed.index') }}"
            class="bg-gray-200 text-gray-900 group flex items-center px-3 py-2 text-sm font-medium rounded-md"
            aria-current="page">
            <!-- Heroicon name: outline/home -->
            <svg class="text-gray-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span class="truncate"> {{ translate('Latest') }} </span>
        </a>

        <!-- Current: "bg-gray-200 text-gray-900", Default: "text-gray-600 hover:bg-gray-50" -->
        <a href="{{ route('feed.trending') }}"
            class="bg-gray-200 text-gray-900 group flex items-center px-3 py-2 text-sm font-medium rounded-md"
            aria-current="page">
            <!-- Heroicon name: outline/home -->
            @svg('heroicon-o-fire', ['class' => 'text-gray-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6'])

            <span class="truncate"> {{ translate('Trending') }} </span>
        </a>

        <!-- Current: "bg-gray-200 text-gray-900", Default: "text-gray-600 hover:bg-gray-50" -->
        <a href="{{ route('feed.discussions') }}"
            class="bg-gray-200 text-gray-900 group flex items-center px-3 py-2 text-sm font-medium rounded-md"
            aria-current="page">
            <!-- Heroicon name: outline/home -->

            @svg('heroicon-o-annotation', ['class' => 'text-gray-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6'])



            <span class="truncate"> {{ translate('Best Discussions') }} </span>
        </a>

        <!-- This example requires Tailwind CSS v2.0+ -->
        <div class="relative py-3">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center">
            </div>
        </div>


        <!-- Current: "bg-gray-200 text-gray-900", Default: "text-gray-600 hover:bg-gray-50" -->
        <a href="{{ route('feed.tags') }}"
            class="bg-gray-200 text-gray-900 group flex items-center px-3 py-2 text-sm font-medium rounded-md"
            aria-current="page">
            <!-- Heroicon name: fire -->
            @svg('heroicon-o-hashtag', ['class' => 'text-gray-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6'])

            <span class="truncate"> {{ translate('Tags and Topics') }} </span>
        </a>

        <a href="{{  route('feed.shops') }}"
            class="text-gray-600 hover:bg-gray-50 group flex items-center px-3 py-2 text-sm font-medium rounded-md">
            <!-- Heroicon name: outline/fire -->
            @svg('heroicon-o-shopping-bag', ['class' => 'text-gray-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6'])

            <span class="truncate"> {{ translate('Shops') }} </span>
        </a>
        <a href="{{ route('feed.products') }}"
            class="text-gray-600 hover:bg-gray-50 group flex items-center px-3 py-2 text-sm font-medium rounded-md">
            <!-- Heroicon name: outline/user-group -->
            <svg class="text-gray-400 group-hover:text-gray-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <span class="truncate"> {{ translate('Products') }} </span>
        </a>

         <!-- This example requires Tailwind CSS v2.0+ -->
         <div class="relative py-3">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center">
            </div>
        </div>


        <a href="{{ route('feed.bookmarks') }}"
            class="text-gray-600 hover:bg-gray-50 group flex items-center px-3 py-2 text-sm font-medium rounded-md">
            <!-- Heroicon name: outline/user-group -->
            @svg('heroicon-o-bookmark', ['class' => 'text-gray-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6'])

            <span class="truncate"> {{ translate('Saved') }} </span>
        </a>

        <a href="{{ route('feed.bookmarks') }}"
        class="text-gray-600 hover:bg-gray-50 group flex items-center px-3 py-2 text-sm font-medium rounded-md">
        <!-- Heroicon name: outline/user-group -->
        @svg('heroicon-o-user-circle', ['class' => 'text-gray-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6'])

        <span class="truncate"> {{ translate('My Profile') }} </span>
    </a>


        {{-- <a href="#"
            class="text-gray-600 hover:bg-gray-50 group flex items-center px-3 py-2 text-sm font-medium rounded-md">
            <!-- Heroicon name: outline/user-group -->
            <svg class="text-gray-400 group-hover:text-gray-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <span class="truncate"> {{ translate('Notifications') }} </span>
        </a> --}}

        {{-- <a href="#"
            class="text-gray-600 hover:bg-gray-50 group flex items-center px-3 py-2 text-sm font-medium rounded-md">
            <!-- Heroicon name: outline/trending-up -->
            <svg class="text-gray-400 group-hover:text-gray-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
            </svg>
            <span class="truncate"> Trending </span>
        </a> --}}
    </div>
    <div class="hidden pt-10">
        <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider" id="communities-headline">
            {{ translate('My Pages') }}



        </p>
        <div class="mt-3 space-y-2" aria-labelledby="communities-headline">

        </div>
    </div>

    {{-- <x-dashboard.elements.support-card class="mt-3"></x-dashboard.elements.support-card> --}}
    <div class="pt-6">
        @auth
        <x-feed.elements.user-onboarding-flow>
        </x-feed.elements.user-onboarding-flow>
        @endauth
    </div>
</nav>
