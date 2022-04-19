<div class="col-span-1 flex flex-col text-center bg-white rounded-lg shadow divide-y divide-gray-200 relative">


    <div class="flex-1 flex flex-col p-3">
        <a href="{{  $product->getPermalink() }}">
            <img class="w-32 h-32 flex-shrink-0 mx-auto rounded object-contain" src="{{ $product->getThumbnail() }}"
                alt="">
        </a>
        <h3 class="mt-6 text-gray-900 text-md font-semibold">
            <a href="{{  $product->getPermalink() }}">
                {{ $product->name }}
            </a>
        </h3>
        <dl class="mt-1 flex-grow flex flex-col justify-between">
            <dt class="sr-only">Title</dt>
            <dd class="text-gray-500 text-sm"></dd>
            <dt class="sr-only">Role</dt>
            <dd class="mt-3">
                <span class="px-2 py-1 text-green-800 text-sm font-medium bg-green-100 rounded-full">
                    {{ translate('Price') }} {{ $product->getTotalPrice(true) }}
                </span>
                {{-- Out of stock badge --}}
                @if(!$product->isInStock())
                <span
                    class="absolute top-[10px] right-[10px] px-2 py-1 text-gray-100 text-xs font-medium bg-danger rounded-full">
                    {{ translate('Out of stock') }} 📦
                </span>
                @endif

                <div class="we-badges-left absolute top-[-10px] left-[-10px]">
                    {{-- New Badge --}}
                    {{-- TODO: Add new item threshold --}}
                    @if($product->created_at->diffInDays() < 3)
                    <div class="mb-2 px-2 py-2 text-gray-100 text-sm font-semibold bg-indigo-700 rounded-full">
                        {{ translate('New!') }} 🔖
                    </div>
                @endif

                {{-- Popular bade --}}
                @if($product->public_view_count() > 20)
                <div class="px-2 py-2 text-gray-100 text-sm font-semibold bg-green-700 rounded-full">
                    {{ translate('Tending!') }} 🔥
                </div>
                @endif
    </div>
    </dd>
    </dl>
</div>
<div>
    <div class="-mt-px flex divide-x divide-gray-200">
        <div class="w-0 flex-1 flex">
            <a href="{{  $product->getPermalink() }}"
                class="relative -mr-px w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-bl-lg hover:text-gray-500">
                <!-- Heroicon name: solid/mail -->
                {{ svg('heroicon-s-eye', ['class'=> 'max-w-[20px] text-gray-900']) }}

                <span class="ml-3">
                    {{ translate('View') }}
                </span>
            </a>
        </div>
        <div class="-ml-px w-0 flex-1 flex">
            <div
                class="relative -mr-px w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-bl-lg hover:text-gray-500">
                <span class="ml-3">
                    <livewire:actions.wishlist-button wire:key="product_{{ $product->id }}" :object="$product">
                    </livewire:actions.wishlist-button>
                </span>
            </div>

        </div>
    </div>
</div>
</div>