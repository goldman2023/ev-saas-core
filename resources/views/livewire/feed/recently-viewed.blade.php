<ul role="list" class="-my-4 divide-y divide-gray-200">
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
                    <button type="button" class="inline-flex space-x-2 text-gray-400 hover:text-gray-500">
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

    <!-- More posts... -->
</ul>
