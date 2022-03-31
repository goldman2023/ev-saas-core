<div class="ml-4 flex items-center md:ml-6">
    <button type="button" @click="$dispatch('display-flyout-panel', {'id': 'auth-panel'})"
        class="bg-white p-1 rounded-full text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        <span class="sr-only">View Login</span>
        <!-- Heroicon name: outline/bell -->
        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
            aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
    </button>
    <button type="button" @click="$dispatch('display-flyout-panel', {'id': 'cart-panel'})"
        class="bg-white p-1 rounded-full text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        <span class="sr-only">{{ translate('View Cart') }}</span>
        <!-- Heroicon name: outline/bell -->
        @svg('heroicon-o-shopping-cart', ['class' => 'h-6 w-6'])

    </button>
    <button type="button" @click="$dispatch('display-flyout-panel', {'id': 'wishlist-panel'})"
        class="bg-white p-1 rounded-full text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        <span class="sr-only">
            {{ translate('View Wishlist') }}
        </span>
        @svg('heroicon-o-heart', ['class' => 'h-6 w-6'])

    </button>

    <!-- Profile dropdown -->
    <div class="ml-3 relative" x-data="{
        show: false,
    }">
        <div>
            <button type="button" @click="show = !show"
                class="max-w-xs bg-white flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                <img class="h-8 w-8 rounded-full" src="{{ auth()->user()->getThumbnail() }}" alt="">
            </button>
        </div>

        <!--
        Dropdown menu, show/hide based on menu state.

        Entering: "transition ease-out duration-100"
          From: "transform opacity-0 scale-95"
          To: "transform opacity-100 scale-100"
        Leaving: "transition ease-in duration-75"
          From: "transform opacity-100 scale-100"
          To: "transform opacity-0 scale-95"
      -->
        <div x-cloak x-show="show"
            class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
            role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
            <!-- Active: "bg-gray-100", Not Active: "" -->
            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700" role="menuitem"
                tabindex="-1" id="user-menu-item-0">
                {{ translate('Dashboard') }}
            </a>

            <a href="{{ route('my.account.settings') }}" class="block px-4 py-2 text-sm text-gray-700" role="menuitem"
                tabindex="-1" id="user-menu-item-1">
                {{ translate('Settings') }}

            </a>

            <a href="{{ route('user.logout') }}" class="block px-4 py-2 text-sm text-gray-700" role="menuitem"
                tabindex="-1" id="user-menu-item-2">
                {{ translate('Sign Out') }}
            </a>
        </div>
    </div>
</div>
