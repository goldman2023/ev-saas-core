<x-panels.flyout-panel id="cart-panel" title="{{ translate('Cart') }}" framework="tailwind">

    <div class="h-full flex flex-col relative" x-data="{
        processing: @entangle('processing').defer,
        }"
        @cart-processing-ending.window="
            $nextTick(() => { // Wait for qty to be changed and then stop processing
                processing = false; // Turn off the Cart processing now. Reason is that if we change qty after turning processing off, we would run qty watcher again and initiate addToCart again!
            });
        ">
        <x-ev.loaders.spinner class="absolute-center z-10 hidden"
                              wire:loading.class.remove="hidden"></x-ev.loaders.spinner>

{{--            TODO: Add loading class to prevent clicking items beneath--}}
        <div class="flex flex-col h-full" wire:loading.class="opacity-30">

            <!-- Cart Header -->
            <h3 class="text-20 mb-3 pb-2 border-b flex items-center">
                <span>{{ translate('Cart') }}</span>
                <span class="badge-info flex items-center px-2 py-1 ml-3 text-12 text-warning">
                    @svg('heroicon-s-shopping-bag', ['class' => 'w-[14px] h-[14px] mr-2'])
                    {{ str_replace('%x%', $totalItemsCount, translate('You have %x% item(s) in your cart.')) }}
                </span>
            </h3>

            <!-- Cart Warnings -->
            <div class="c-flyout-cart__warnings flex-col mb-3" x-show="has_warnings" :class="{'flex':has_warnings}">
                <div class="bg-red-600 text-white rounded text-14 p-2" x-ref="c-flyout-cart__warnings-text">

                </div>
            </div>

            <!-- Cart Items -->
            <div class="flex flex-col mb-1 grow">
                @if($items->isNotEmpty())
                    @foreach($items as $item)
                        @php
                            $hasVariations = ($item->hasMain()) ? $item->main->hasVariations() : $item->hasVariations();
                            $name = ($item->hasMain()) ? $item->main->getTranslation('name') : $item->getTranslation('name');
                            $excerpt = ($item->hasMain()) ? $item->main->getTranslation('excerpt') : $item->getTranslation('excerpt');
                        @endphp

                        <div id="cart-item-{{ $item->id }}-{{ str_replace('\\','-',$item::class) }}"
                             class="cart-item border shadow-lg border-gray-200 rounded p-3 flex items-start mb-3"
                             :class="{ 'pointer-events-none': processing }"
                             x-data="{
                                qty: {{ $item->purchase_quantity }},
                                model_id: {{ $item->id }},
                                model_type: '{!! addslashes($item::class) !!}',
                             }"
                             x-init="
                                $watch('qty', function(value) {
                                    if(!processing) {
                                        $('.c-flyout-cart__items .cart-item').addClass('pointer-events-none'); // manually prevent pointer events while processing
                                        hideWarnings();
                                        $wire.addToCart(model_id, model_type, value, false);
                                    }
                                 });
                            "
                             @cart-processing-ending.window="
                                if(Number($event.detail.id) === Number(model_id) && model_type == $event.detail.model_type) {
                                    qty = $event.detail.qty;
                                }

                                $('.c-flyout-cart__items .cart-item').removeClass('pointer-events-none'); // manually remove prevent-pointer-events class
                            "
                             @cart-item-warnings.window="
                                $nextTick(() => {
                                    if($event.detail.warnings.length > 0) {
                                        has_warnings = true;
                                         $($refs['c-flyout-cart__warnings-text']).html($event.detail.warnings[0].split('\\n').map(text => '<span>' + text + '</span><br>').join(''));

                                         setTimeout(() => {
                                            hideWarnings();
                                         }, 5000);
                                    }
                                });"
                        >
                            <div class="w-full grid grid-cols-12">

                                <div class="c-flyout-cart__item-thumb col-span-3">
                                    <img src="{{ $item->getThumbnail(['w'=>100,'h'=>100]) }}" class="border w-[100px] h-[100px] rounded-lg fit-cover" />
                                </div>

                                <div class="flex flex-col col-span-6 pl-3 pr-3 mt-1">
                                    <strong class="text-gray-800 text-16 w-full inline-block mb-1 line-clamp-1" style="line-height: 1.2;">{{ $name }}</strong>

                                    @if(!$hasVariations)
                                        <span class="text-gray-500 text-12 line-clamp-2">{{ $excerpt }}</span>
                                    @else
                                        <ul class="c-flyout-cart__item-variations-name-list flex mb-0">
                                            @foreach($item->getVariantName(as_collection: true) as $name)
                                                <li class="line-clamp-1">{{ $name }}</li>
                                            @endforeach
                                        </ul>
                                    @endif

                                    <div class="bg-danger mr-auto w-[18px] h-[18px] rounded flex items-center justify-center cursor-pointer mt-auto mb-1"
                                         @click="$wire.removeFromCart(model_id, model_type)">
                                        @svg('heroicon-o-x', ['class' => 'w-[12px] h-[12px] text-white'])
                                    </div>
                                </div>

                                <div class="flex flex-col items-center justify-center col-span-3 pl-0 pr-3 pt-3">
                                    <strong class="font-semibold text-14 text-sky-600 mb-1" >
                                        <span class="spinner-border text-sky-600 text-10 w-[16px] h-[16px] hidden" > </span>
                                        <span >{{ \FX::formatPrice($item->purchase_quantity * $item->total_price) }}</span>
                                    </strong>

                                    <x-system.quantity-counter :model="$item" :wired="true" :mini="true"></x-system.quantity-counter>
                                </div>
                            </div>

                        </div>
                    @endforeach
                @else
                    <!-- Empty Cart Section -->
                    <div class="w-full mx-2">
                        <div class="text-center md:mx-auto">
                            <figure class="max-w-[10rem] sm:max-w-[15rem] mx-auto mb-3 flex justify-center">
                                @svg('lineawesome-shopping-cart-solid', ['class' => 'text-slate-600', 'style' => 'width: 72px;'])
                            </figure>
                            <div class="mb-5">
                                <h3 class="h3">{{ translate('Your cart is currently empty') }}</h3>
                                <p class="mx-3 mt-3">{{ translate('Before proceed to checkout you must add some products to your shopping cart.') }}</p>
                            </div>
                            <a class="btn btn-pill bg-sky-600 text-white transition-3d-hover px-5 py-2" href="{{ route('feed.products') }}">
                                {{ translate('Start Shopping') }}
                            </a>
                        </div>
                    </div>
                    <!-- End Empty Cart Section -->
                @endif

            </div>

            <!-- Cart Footer -->
            @if($items->isNotEmpty())
                <div class="w-100 flex flex-col border-top pt-2">
                    <div class="flex justify-between items-center mb-1">
                        <span>{{ translate('Items:') }}</span>
                        <strong>{{ $originalPrice['display'] }}</strong>
                    </div>
                    <div class="flex justify-between items-center">
                        <span>{{ translate('Discounts:') }}</span>
                        <strong class="text-success">-{{ $discountAmount['display'] }}</strong>
                    </div>

                    <span class="divide-y divider-third-right py-2"></span>

                    <div class="flex justify-between items-center">
                        <span>{{ translate('Subtotal:') }}</span>
                        <strong class="text-dark">{{ $subtotalPrice['display'] }}</strong>
                    </div>

                    <a href="{{ route('checkout.single.page') }}" class="btn mt-3 bg-sky-600 text-white">
                        {{ translate('Checkout') }}
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-panels.flyout-panel>

{{-- <div x-data="{ show: false }" x-cloak
     x-init="$(document).on('keyup', function(e) { if (e.key == 'Escape' && show) {show = false} });">
    <section
        class="c-flyout-cart fixed bg-white shadow-lg"
        :class="{ 'show': show }"
        @toggle-cart.window="show = !show"
        @display-cart.window="show = true"
    >

    </section>

    <div class="c-flyout-cart__overlay"
         x-show="show"
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0 "
         x-transition:enter-end="opacity-70 "
         x-transition:leave="transition ease-in duration-500"
         x-transition:leave-start="opacity-70 "
         x-transition:leave-end="opacity-0 "
         @click="show = false"
    >
    </div>
</div> --}}
