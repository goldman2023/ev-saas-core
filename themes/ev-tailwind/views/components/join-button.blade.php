<div class="flex items-center">
    @guest
        <a href="{{ route('shops.create') }}"
           class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 {{ $class }}">
            {{ translate('Register') }}
            <i class="la la-angle-right "></i>
        </a>
    @else
        @if(Auth::user()->user_type == 'seller')
            <div x-data="{ expanded: false }" @click.away="expanded = false" class="ml-3 relative z-10">
                <div>
                    <button @click="expanded = !expanded"
                            class="max-w-xs flex items-center text-sm rounded-full text-white focus:outline-none">
                        <img class="h-8 w-8 rounded-full"
                             src="https://images.unsplash.com/photo-1550525811-e5869dd03032"
                             alt="{{ auth()->user()->name }}">
                    </button>
                </div>
                <div x-show="expanded" class="absolute right-0 mt-2 w-48 rounded-md shadow-lg object-cover"
                     style="display: none;">
                    <div class="py-1 rounded-md bg-white shadow-xs">
                        <a href="{{ route('dashboard') }}"
                           class="block px-4 py-1 text-sm text-gray-700 hover:bg-gray-100">
                            {{ translate('Dashboard') }}
                        </a>
                        <a href="{{ route('tenant.settings.user') }}"
                           class="block px-4 py-1 text-sm text-gray-700 hover:bg-gray-100">My account
                        </a>
                        <a href="{{ route('tenant.settings.application') }}"
                           class="block px-4 py-1 text-sm text-gray-700 hover:bg-gray-100">Application settings
                        </a>
                        <a href="{{ route('admin.dashboard') }}"
                           class="block px-4 py-1 text-sm text-gray-700 hover:bg-gray-100">Admin panel
                        </a>
                        <a href="{{ route('logout') }}" class="block px-4 py-1 text-sm text-gray-700 hover:bg-gray-100"
                           onclick="event.preventDefault();
                                                                document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </div>
            </div>
        @else
            <a href="{{ route('dashboard') }}"
               class="ml-8 inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                {{ translate('Dashboard') }}
                <i class="la la-angle-right "></i>
            </a>

            <a href="{{ route('logout') }}"
               class="text-reset py-2 d-inline-block opacity-60">{{ translate('Logout') }}</a>
        @endif
    @endguest
</div>
