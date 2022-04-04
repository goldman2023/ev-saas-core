<div class="flex space-x-3">
    <div class="flex-shrink-0">
        <div class="has-tooltip inline-block relative">
            <span class='tooltip min-w-[200px] rounded shadow-lg p-1 bg-gray-100 text-red-500 -mt-8'>

            {{-- TODO: Implement quick view for person and for product click --}}
            <a href="{{ $user->getPermalink() }}">

                   {{ $user->followers()->count()}} {{ translate('followers') }}

                </span>

                <x-tenant.system.image alt="{{ get_site_name() }} logo"
                    class="h-10 w-10 rounded-full border-3 ring-2 ring-indigo-400" fit="contain"
                    :image="$user->getAvatar()">
                </x-tenant.system.image>
            </a>
            <span class="absolute bottom-0 right-0 block h-4 w-4 rounded-full ring-2 ring-white bg-green-400"></span>
        </div>

    </div>
    <div class="min-w-0 flex-1">
        <p class="text-sm font-medium text-gray-900">
            @isset( $user->name)
            <a href="{{ $user->getPermalink() }}" class="hover:underline">
                {{ $user->name }}
            </a>
            @endisset
        </p>
        <p class="text-sm text-gray-500">
            <a href="#" class="hover:underline">
                <time datetime="2020-12-09T11:43:00">
                    {{ $item->created_at->diffForHumans() }}
                </time>
            </a>
        </p>
    </div>
    <div class="flex-shrink-0 self-center flex">
        <div class="relative inline-block text-left">
            <div>
                <!-- Heroicon name: solid/dots-vertical -->
            </div>

        </div>
    </div>
</div>
