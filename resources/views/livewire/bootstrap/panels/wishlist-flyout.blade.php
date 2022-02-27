<div class="{{ $class }} flyout-wishlist" x-data="{}">
    <x-ev.loaders.spinner class="absolute-center z-10 d-none"
                          wire:loading.class.remove="d-none"></x-ev.loaders.spinner>

    <div class="w-100 " wire:loading.class="opacity-3">
        @if($wishlists?->isNotEmpty() ?? null)
            @foreach($wishlists as $key => $item)
                @php
                    $item = $item->subject;
                @endphp
                <a href="{{ $item->getPermalink() }}" class="flyout-wishlist__item card p-3 d-flex flex-row align-items-start mb-3" x-data="{
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
                    <div class="w-100 d-flex">

                        <div class="flyout-wishlist__item-left">
                            <img src="{{ $item->getThumbnail(['w'=>100,'h'=>100]) }}" style="width:100px; height: 100px;" class="border rounded-lg fit-cover" />
                        </div>

                        <div class="flyout-wishlist__item-right">
                            <div class="mb-1 ml-2">
                                <span class="d-inline-block text-body small font-weight-bold" href="#">
                                    {{ $item->primary_category?->getTranslation('name') ?? ($item->primary_category?->name ?? translate('Unknown')) }}
                                </span>
                                <span class="d-block font-size-1 text-dark">
                                    {{ $item->getTranslation('name') }}
                                </span>
                                <div class="w-100 d-inline">
                                    <strong class="text-body mr-1 mb-0">{{ $item->getTotalPrice(true) }}</strong>

                                    <span class="mb-0 text-body {{ $item->base_price !== $item->total_price ? '':'d-none' }}">
                                        <del>{{ $item->getBasePrice(true) }}</del>
                                    </span>

                                    {{--                                    <span x-data="{}"--}}
                                    {{--                                          class="badge badge-soft-success rounded text-success align-items-center px-2 py-2 ml-2 text-12--}}
                                    {{--                                            {{ $item->base_price !== $item->total_price ? 'd-inline-flex':'d-none' }}">--}}
                                    {{--                                        @svg('heroicon-s-tag', ['class' => 'square-16 mr-1'])--}}
                                    {{--                                        <span>--}}
                                    {{--                                            {{ translate('Discount').' '.(100-(100*$item->total_price/$item->base_price)) }}!--}}
                                    {{--                                        </span>--}}
                                    {{--                                    </span>--}}
                                </div>

                            </div>

                            @if($item->isInStock())
                                <span class="badge badge-success badge-pill ml-1">{{ translate('In stock') }}</span>
                            @else
                                <span class="badge badge-danger badge-pill ml-1">{{ translate('Sold out') }}</span>
                            @endif

                            {{--                            <x-panels.add-to-cart-button :model="$item" class="d-inline-flex" btnType="primary" btnSize="xs"></x-panels.add-to-cart-button>--}}

                        </div>
                    </div>
                </a>
            @endforeach

            @else
             <!-- Empty Wishlist Section -->
             <div class="container-fluid space-2">
                <div class="text-center mx-md-auto">
                    <figure class="max-w-10rem max-w-sm-15rem mx-auto mb-3">
                        @svg('heroicon-o-heart', ['class' => 'text-dark', 'style' => 'width: 72px;'])
                    </figure>
                    <div class="mb-5">
                        <h3 class="h3">{{ translate('Your wishlist is currently empty') }}</h3>
                        <p>{{ translate('Visit the shop and add some items to your wishlist you like') }}</p>
                    </div>
                    <a class="btn btn-primary btn-pill transition-3d-hover px-5" href="{{ route('search') }}">
                        {{ translate('Explore Products') }}
                    </a>
                </div>
            </div>
            <!-- End Empty Cart Section -->
        @endif


    </div>

</div>
