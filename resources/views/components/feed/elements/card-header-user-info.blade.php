<div class="flex space-x-4 mb-4">
    <div class="flex-shrink-0">
        <div class="has-tooltip inline-block relative">
            <a href="{{ $user->getPermalink() }}">
                <span class='tooltip min-w-[200px] rounded shadow-lg p-1 bg-gray-100 text-red-500 -mt-8'>
                    {{-- TODO: Implement quick view for person and for product click --}}
                    {{ $user->followers()->count()}} {{ translate('followers') }}
                </span>

                <x-tenant.system.image alt="{{ get_site_name() }} logo"
                    class="h-11 w-11 rounded-full border-3 ring-2 ring-gray-200" fit="contain"
                    :image="$user->getAvatar()">
                </x-tenant.system.image>
            </a>
            <span class="absolute bottom-0 right-0 block h-3 w-3 rounded-full ring-2 ring-white bg-green-400"></span>
        </div>

    </div>
    <div class="min-w-0 flex-1">
        @isset($user->name)
            <a href="{{ $user->getPermalink() }}" class="text-14 text-typ-2 font-medium block hover:underline">
                {{ $user->name }}
            </a>
        @endisset
        <p class="text-12 text-typ-3">
            <time datetime="{{ $item->created_at }}">
                {{ $item->created_at->diffForHumans() }}
            </time>
        </p>
    </div>
    <div class="flex-shrink-0 self-start flex">
        <div class="relative inline-block text-left cursor-pointer">
            @svg('heroicon-s-dots-horizontal', ['class' => 'text-gray-400 w-5 h-5'])
        </div>
    </div>
</div>
