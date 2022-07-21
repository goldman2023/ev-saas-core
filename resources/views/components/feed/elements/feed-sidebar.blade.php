<nav aria-label="Sidebar" class="sticky top-4 divide-y divide-gray-300">
    @auth
    {{-- TODO: Create a separate component for user card --}}
    <div class="space-y-8 sm:space-y-0 sm:flex sm:justify-center sm:items-center xl:block xl:space-y-8 mb-6">
        <!-- Profile -->
        <div class="flex items-center space-x-3 mb-3">
            <div class="flex-shrink-0 h-12 w-12">
                <img class="h-12 w-12 rounded-full object-contain bg-white" src="{{ auth()->user()->getThumbnail() }}"
                    alt="">
            </div>
            <div class="space-y-1">
                <div class="text-sm font-medium text-gray-900">
                    {{ auth()->user()->name }}
                </div>
                <a href="{{ auth()->user()->getPermalink() }}" class="group flex items-center space-x-2.5">

                    <span class="text-sm text-gray-500 group-hover:text-gray-900 font-medium">
                        @ {{auth()->user()->username }}
                    </span>
                </a>
            </div>
        </div>

    </div>
    @endauth

    <div class="py-3 space-y-1">
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
            class="hidden bg-gray-200 text-gray-900 group flex items-center px-3 py-2 text-sm font-medium rounded-md"
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

        @auth
        <a href="{{ auth()->user()->getPermalink() }}"
            class="text-gray-600 hover:bg-gray-50 group flex items-center px-3 py-2 text-sm font-medium rounded-md">
            <!-- Heroicon name: outline/user-group -->
            @svg('heroicon-o-user-circle', ['class' => 'text-gray-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6'])

            <span class="truncate"> {{ translate('My Profile') }} </span>
        </a>

        <a href="{{ route('my.purchases.index') }}"
            class="text-gray-600 hover:bg-gray-50 group flex items-center px-3 py-2 text-sm font-medium rounded-md">
            <!-- Heroicon name: outline/user-group -->
            @svg('heroicon-o-shopping-cart', ['class' => 'text-gray-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6'])

            <span class="truncate"> {{ translate('My Purchases') }} </span>
        </a>

        @if(auth()->user()->isSeller() || auth()->user()->isAdmin())
        <!-- This example requires Tailwind CSS v2.0+ -->
        <div class="relative py-3">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center">
            </div>
        </div>
        <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider" id="communities-headline">
            {{ translate('Seller Zone') }}
        </p>

        <a href="{{ route('blog.posts.index') }}"
            class="text-gray-600 hover:bg-gray-50 group flex items-center px-3 py-2 text-sm font-medium rounded-md">
            <!-- Heroicon name: outline/user-group -->
            @svg('heroicon-o-document-add', ['class' => 'text-gray-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6'])

            <span class="truncate"> {{ translate('Articles') }} </span>
        </a>

        <a href="{{ route('products.index', ['filters[type]' => 'course']) }}"
            class="text-gray-600 hover:bg-gray-50 group flex items-center px-3 py-2 text-sm font-medium rounded-md">
            <!-- Heroicon name: outline/user-group -->
            @svg('heroicon-o-academic-cap', ['class' => 'text-gray-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6'])

            <span class="truncate"> {{ translate('Courses') }} </span>
        </a>

        <a href="{{ route('dashboard.we-quiz.index') }}"
            class="text-gray-600 hover:bg-gray-50 group flex items-center px-3 py-2 text-sm font-medium rounded-md">
            <!-- Heroicon name: outline/user-group -->
            @svg('heroicon-o-question-mark-circle', ['class' => 'text-gray-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6'])

            <span class="truncate"> {{ translate('Quizes') }} </span>
        </a>

        <a href="{{ route('products.index') }}"
            class="text-gray-600 hover:bg-gray-50 group flex items-center px-3 py-2 text-sm font-medium rounded-md">
            <!-- Heroicon name: outline/user-group -->
            @svg('heroicon-o-photograph', ['class' => 'text-gray-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6'])

            <span class="truncate"> {{ translate('Products') }} </span>
        </a>
        @endif


        @endauth

    </div>
    <div class="pt-6 mb-6">
        <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider" id="communities-headline">
            {{ translate('My Shop') }}
        </p>
        <div class="mt-3 space-y-2" aria-labelledby="communities-headline">

        </div>
        <a href="{{ route('settings.shop_settings') }}" class="px-3 relative flex items-start group">
            <span class="h-9 w-9 flex items-center">
                    <!-- Heroicon name: solid/check -->

                    <img class="w-full flex-shrink-0  rounded-full object-contain mt-[50px] ring-2 ring-indigo-600 p-1" src="{{ \MyShop::getShop()->getThumbnail()}}" />

            </span>
            <span class="ml-4 min-w-0 flex flex-col">
                <span class="text-xs font-semibold tracking-wide uppercase">
                    {{ \MyShop::getShop()->name }}
                </span>
                <span class="text-sm text-gray-500">
                   {{ translate('Manage') }}
                </span>
            </span>
        </a>



    </div>

    {{-- <x-dashboard.elements.support-card class="mt-3"></x-dashboard.elements.support-card> --}}
    <div class="pt-6">
        @auth
        <x-feed.elements.user-onboarding-flow>
        </x-feed.elements.user-onboarding-flow>
        @endauth
    </div>
</nav>
