<div class="{{ $class }} flyout-wishlist" x-data="{}">
    <x-ev.loaders.spinner class="absolute-center z-10 hidden"
                          wire:loading.class.remove="hidden"></x-ev.loaders.spinner>

    <div class="w-full " wire:loading.class="opacity-30">
        @if($wishlists?->isNotEmpty() ?? null)
            @foreach($wishlists as $key => $item)
                @php
                    $item = $item->subject;
                    if(empty($item)) {
                        continue;
                    }
                @endphp
                <a href="{{ $item->getPermalink() }}" class="flyout-wishlist__item border rounded-lg shadow-lg p-3 flex flex-row items-start mb-3" x-data="{
                    processing: false,
                    qty: 1,
                    model_id: {{ $item->id }},
                    model_type: '{!! addslashes($item::class) !!}',
                }"
                @if($key+1 === $wishlists->count()) x-intersect.once="$wire.loadMore()" @endif
                @cart-processing-ending.window="
                    $nextTick(() => { // Wait for qty to be changed and then stop processing
                        processing = false; // Turn off the Cart processing now. Reason is that if we change qty after turning processing off, we would run qty watcher again and initiate addToCart again!
                    });
                ">
                    <div class="w-full flex">

                        <div class="flyout-wishlist__item-left">
                            <img src="{{ $item->getThumbnail(['w'=>100,'h'=>100]) }}" style="width:100px; height: 100px;" class="border rounded-lg object-cover" />
                        </div>

                        <div class="flyout-wishlist__item-right">
                            <div class="mb-1 ml-2">
                                <span class="inline-block text-gray-500 text-12" href="#">
                                    {{ $item->primary_category?->getTranslation('name') ?? ($item->primary_category?->name ?? translate('Unknown')) }}
                                </span>
                                <span class="block text-14">
                                    {{ $item->getTranslation('name') }}
                                </span>
                                <div class="w-full inline">
                                    <strong class="text-gray-800 mr-1 mb-0">{{ $item->getTotalPrice(true) }}</strong>

                                    <span class="mb-0 text-gray-800 {{ $item->base_price !== $item->total_price ? '':'hidden' }}">
                                        <del>{{ $item->getBasePrice(true) }}</del>
                                    </span>

                                    {{--                                    <span x-data="{}"--}}
                                    {{--                                          class="badge badge-soft-success rounded text-success align-items-center px-2 py-2 ml-2 text-12--}}
                                    {{--                                            {{ $item->base_price !== $item->total_price ? 'd-inline-flex':'hidden' }}">--}}
                                    {{--                                        @svg('heroicon-s-tag', ['class' => 'square-16 mr-1'])--}}
                                    {{--                                        <span>--}}
                                    {{--                                            {{ translate('Discount').' '.(100-(100*$item->total_price/$item->base_price)) }}!--}}
                                    {{--                                        </span>--}}
                                    {{--                                    </span>--}}
                                </div>

                            </div>

                            @if($item->isInStock())
                                <span class="badge bg-green-500 text-white badge-pill ml-1">{{ translate('In stock') }}</span>
                            @else
                                <span class="badge bg-red-600  text-white badge-pill ml-1">{{ translate('Sold out') }}</span>
                            @endif

                            {{--                            <x-panels.add-to-cart-button :model="$item" class="d-inline-flex" btnType="primary" btnSize="xs"></x-panels.add-to-cart-button>--}}

                        </div>
                    </div>
                </a>
            @endforeach

        @else
            <!-- Empty Wishlist Section -->
            <div class="w-full py-[4rem] px-[15px]">
                <div class="text-center mx-auto">
                    <figure class="max-w-[10rem] md:max-w-[15rem] mx-auto mb-3 flex justify-center">
                        @svg('heroicon-o-heart', ['class' => 'text-slate-900', 'style' => 'width: 72px;'])
                    </figure>
                    <div class="mb-5">
                        <h3 class="text-22 mb-3">{{ translate('Your wishlist is currently empty') }}</h3>
                        <p class="text-16 text-gray-600 px-4">{{ translate('Visit the shop and add some items to your wishlist you like') }}</p>
                    </div>
                    <a class="btn btn-pill bg-sky-500 text-white text-16 !px-6 !py-2" href="{{ route('feed.products') }}">
                        {{ translate('Explore Products') }}
                    </a>
                </div>
            </div>
            <!-- End Empty Cart Section -->
        @endif


    </div>

</div>
