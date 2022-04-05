<div class="col-span-1 flex flex-col text-center bg-white hover:bg-gray-100 rounded-lg shadow divide-y divide-gray-200">
    <div class="flex-1 flex flex-col p-8">
        <a href="{{ $shop->getPermalink() }}">
            <img class="w-32 h-32 flex-shrink-0 mx-auto rounded-full object-contain" src="{{ $shop->getThumbnail() }}"
                alt="">
        </a>
        <h3 class="mt-6 text-gray-900 text-sm font-medium mb-3">
            <a href="{{ $shop->getPermalink() }}">
                {{ $shop->name }}
            </a>
        </h3>
        <div>
            @livewire('actions.wishlist-button', [
            'object' => $shop,
            'action' => 'Follow',
            ])
        </div>
        <dl class="mt-1 flex-grow flex flex-col justify-between">
            <dd class="mt-2">
                <div class="mb-3 px-2 py-1 text-green-800 text-xs font-medium bg-green-100 rounded-full">
                    {{ $shop->products()->count() }}
                    {{ translate('products') }}
                </div>

                <div class="px-2 py-1 text-green-800 text-xs font-medium bg-green-100 rounded-full">
                    {{ $shop->followers()->count() }}
                    {{ translate('followers') }}
                </div>


            </dd>
        </dl>
    </div>
    <div>
        <div class="-mt-px flex divide-x divide-gray-200">

            <div class="-ml-px w-0 flex-1 flex">
                <button
                    x-on:click="CometChatWidget.openOrCloseChat(true); CometChatWidget.chatWithUser('web_{{ $shop->users()->first()->id }}'); "
                    class="relative w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-br-lg hover:text-gray-500">
                    <!-- Heroicon name: solid/phone -->
                    <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor" aria-hidden="true">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                    </svg>
                    <span class="ml-3">
                        {{ translate('Message') }}
                    </span>
                </button>
            </div>
            <div class="w-0 flex-1 flex">
                <a href="{{ $shop->getPermalink() }}"
                    class="relative w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-br-lg hover:text-gray-500">
                    {{ translate('Visit shop') }}
                    <svg class="ml-2 w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>

                </a>
            </div>
        </div>
    </div>
</div>
