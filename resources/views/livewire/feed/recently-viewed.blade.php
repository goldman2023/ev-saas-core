<ul role="list" class="-my-4 divide-y divide-gray-200">
    @if($products->count() > 0)
    @foreach($products as $product)
    @if(isset($product->subject->name))
    <li class="flex py-4 space-x-3">
        <div class="flex-shrink-0 min-w-[80px]">
            <a href="{{ $product->subject->getPermalink() }}">
                <x-tenant.system.image class="w-full rounded-xl max-w-[80px]"
                    :image="$product->subject->getThumbnail(['w'=>80]) ?? ''">
                </x-tenant.system.image>
            </a>
        </div>
        <div class="min-w-0 flex-1">
            <p class="text-md text-gray-800 font-bold">
                <a href="{{ $product->subject->getPermalink() }}">

                    {{ $product->subject->name }}
                </a>
            </p>
            <div class="mt-2 flex">
                <span class="inline-flex items-center text-sm">
                    <button type="button" class="hidden inline-flex space-x-2 text-gray-400 hover:text-gray-500">
                        <!-- Heroicon name: solid/chat-alt -->
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium text-gray-900">291</span>
                    </button>
                </span>
            </div>
        </div>
    </li>
    @endif
    @endforeach
    @else
    {{-- Empty state:
    https://tailwindui.com/components/application-ui/feedback/empty-states#component-42930c785190e14c24b53ba822f4a92c
    --}}
    <div class="text-center">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
            aria-hidden="true">
            <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path>
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">
            {{ translate('You have no viewed items') }}
        </h3>
        <p class="mt-1 text-sm text-gray-500">
            {{ translate('Get started by exploring ') }} {{ get_site_name() }} {{ translate(' Members and Products') }}
        </p>
        <div class="mt-6">
            <a href="{{ route('feed.shops') }} " type="button"
                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="-ml-1 mr-2 h-5 w-5" x-description="Heroicon name: solid/plus"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd"
                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                        clip-rule="evenodd"></path>
                </svg>
                {{ translate('Explore members') }}
            </a>
        </div>
    </div>
    @endif

    <!-- More posts... -->
</ul>
