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
                        <p class="text-lg text-gray-800 font-bold">
                            <a href="{{ $product->subject->getPermalink() }}">

                                {{ $product->subject->name }}
                            </a>

                        </p>
                        <div>
                            <span class="font-bold text-md text-indigo-600">
                                {{ $product->subject->getBasePrice(true) }}
                            </span>
                        </div>
                        <div class="mt-2 flex">
                            <span class="inline-flex items-center text-sm">
                                <button type="button" class="inline-flex space-x-2 text-gray-400 hover:text-gray-500">
                                    <!-- Heroicon name: solid/eye- -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <span class="font-medium text-gray-900">
                                        {{ $product->subject->public_view_count() }}
                                    </span>
                                </button>
                            </span>
                            <span class="ml-3">
                                <livewire:actions.social-action-button :object="$product->subject" action="reaction" type="like"></livewire:actions.social-action-button>
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
    <div class="text-center relative block w-full border-2 border-gray-300 border-dashed rounded-lg p-6 text-center hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">

        <svg  class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
          </svg>

        <h3 class="mt-1 text-sm font-medium text-gray-900">
            {{ translate('You have no viewed items') }}
        </h3>
        <p class="mt-1 text-sm text-gray-500">
            {{ translate('Get started by exploring ') }} {{ get_site_name() }} {{ translate(' Members and Products') }}
        </p>
        <div class="mt-3">
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
