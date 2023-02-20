<x-panels.flyout-panel id="cart-panel" title="{{ translate('Cart') }}" framework="tailwind">

    <div class="h-full flex flex-col relative" x-data="{
            processing: @entangle('processing').defer,
        }">

        <x-ev.loaders.spinner class="absolute-center z-10 hidden"
                              wire:loading.class.remove="hidden"></x-ev.loaders.spinner>

{{--            TODO: Add loading class to prevent clicking items beneath--}}
        <div class="flex flex-col h-full" wire:loading.class="opacity-30">

            <!-- Cart Header -->
            <h3 class="text-20 mb-3 pb-2 border-b flex items-center">
                <span>{{ translate('Cart') }}</span>
                <span class="badge-info flex items-center px-2 py-1 ml-3 text-12 text-warning">
                    @svg('heroicon-s-shopping-bag', ['class' => 'w-[14px] h-[14px] mr-2'])
                    {{ str_replace('%x%', $totalItemsCount, translate('%x% item(s) in cart.')) }}
                </span>
            </h3>

            <!-- Cart Warnings -->
            <div class="c-flyout-cart__warnings flex-col mb-3" x-show="has_warnings" :class="{'flex':has_warnings}"
                x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 scale-90"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-400"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-90">
                <ol class="list-decimal border border-gray-200 rounded text-14 p-3 pl-7"
                    x-data="{ warnings: [] }"
                    @display-flyout-cart-errors.window="warnings = $event.detail.warnings;">
                    <template x-for="warning in warnings">
                        <li class="text-danger text-14" x-html="warning"></li>
                    </template>
                </ol>
            </div>

            <!-- Cart Items -->
            <div class="flex flex-col mb-1 grow">
                @if($items->isNotEmpty())
                    @foreach($items as $item)
                        @php
                            $hasVariations = ($item?->is_variation ?? false) ? $item->main->hasVariations() : $item->hasVariations();
                            $name = ($item?->is_variation ?? false) ? $item->main->getTranslation('name') : $item->getTranslation('name');
                            $excerpt = ($item?->is_variation ?? false) ? $item->main->getTranslation('excerpt') : $item->getTranslation('excerpt');
                        @endphp

                        <div id="cart-item-{{ $item->id }}-{{ base64_encode($item::class) }}"
                            class="cart-item border shadow-lg border-gray-200 rounded p-3 flex items-start mb-3"
                            :class="{ 'pointer-events-none': processing }"
                            x-data="{
                                qty: {{ $item->purchase_quantity }},
                                model_id: {{ $item->id }},
                                model_type: '{{ base64_encode($item::class) }}',
                                addons: @js($item->purchased_addons?->map(fn($addon) => [
                                    'qty' => $addon->purchase_quantity,
                                    'id' => $addon->id,
                                    'model_type' => base64_encode($addon::class),
                                ])?->sortBy('id', SORT_NATURAL)?->values() ?? []),
                                setQtyInCart() {
                                    if(!processing) {
                                        processing = true;

                                        hideWarnings();
                                        $wire.addToCart(this.model_id, this.model_type, this.qty, false, this.addons, false);
                                    }
                                }
                            }"
                            @cart-processing-end.window="
                                if(Number($event.detail.id) === Number(model_id) && model_type == $event.detail.model_type) {
                                    {{-- TODO: Find a way to prevent $watch of qty property here - cuz we are setting it again! --}}
                                    qty = $event.detail.qty;
                                    addons = $event.detail.addons;
                                }
                            "
                             @cart-item-warnings.window="
                                $nextTick(() => {
                                    if($event.detail.warnings.length > 0) {
                                        has_warnings = true;
                                        $dispatch('display-flyout-cart-errors', {'warnings': $event.detail.warnings});

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

                                <div class="flex flex-col col-span-9 pl-3 pr-3 mt-1">

                                    <div class="flex flex-col grow">
                                        <div class="flex flex-row justify-between items-center mb-1">
                                            <strong class="text-gray-800 text-16 w-full inline-block  line-clamp-1" style="line-height: 1.2;">{{ $name }}</strong>

                                            <div class="ml-4 w-[18px] h-[18px] rounded flex items-center justify-center cursor-pointer"
                                                @click="$wire.removeFromCart(model_id, model_type)">
                                                @svg('heroicon-o-trash', ['class' => 'w-[18px] h-[18px] text-danger'])
                                            </div>
                                        </div>

                                        @if(!$hasVariations)
                                            <span class="text-gray-500 text-12 line-clamp-2">{{ $excerpt }}</span>
                                        @else
                                            <ul class="c-flyout-cart__item-variations-name-list flex mb-0">
                                                @foreach($item->getVariantName(as_collection: true) as $name)
                                                    <li class="line-clamp-1">{{ $name }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>



                                    <div class="w-full flex flex-wrap flex-row justify-between items-center pb-0.5">
                                        <x-system.quantity-counter :model="$item" :wired="true" :mini="true"></x-system.quantity-counter>

                                        <strong class="font-semibold text-14" >
                                            <span class="spinner-border text-gray-800 text-10 w-[16px] h-[16px] hidden" > </span>
                                            <span >{{ \FX::formatPrice($item->purchase_quantity * $item->total_price) }}</span>
                                        </strong>
                                    </div>
                                </div>

                                @if($item->purchased_addons->isNotEmpty())
                                    <ul class="flex flex-col col-span-12 pt-2 mt-2 border-t border-gray-200 gap-y-2">
                                        @foreach($item->purchased_addons as $addon)
                                            <li class="flex justify-between ">
                                                <p class="flex line-clamp-1">
                                                    <span class="text-14">{{ $addon->name }}</span>
                                                    <x-system.quantity-counter :parent="$item" :model="$addon" :wired="true" :mini="true"></x-system.quantity-counter>
                                                    {{-- <span class="text-14">{{ $addon->purchase_quantity }}</span> --}}
                                                </p>
                                                <x-system.we-price :model="$addon"></x-system.we-price>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
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
                            <a class="btn btn-pill w-full !text-md !py-3 btn-primary text-white transition-3d-hover px-5 py-2"
                            href="{{ route('products.all') }}">
                                {{ translate('Start Shopping') }}
                            </a>
                        </div>
                    </div>
                    <!-- End Empty Cart Section -->
                @endif

            </div>


            <!-- Cart Footer -->
            @if($items->isNotEmpty())
                <div class="w-full flex flex-col border-t pt-3">
                    <div class="flex justify-between items-center mb-1">
                        <span>{{ translate('Items:') }}</span>
                        <strong>{{ $originalPrice['display'] }}</strong>
                    </div>

                    @if($discountAmount['raw'] > 0)
                        <div class="flex justify-between items-center">
                            <span>{{ translate('Discounts:') }}</span>
                            <strong class="text-success">-{{ $discountAmount['display'] }}</strong>
                        </div>
                    @endif

                    <hr class="my-2 ml-auto w-1/2 h-[1px] bg-gray-200 rounded border-0 dark:bg-gray-700">

                    <div class="flex justify-between items-center">
                        <span>{{ translate('Subtotal:') }}</span>
                        <strong class="text-dark">{{ $subtotalPrice['display'] }}</strong>
                    </div>

                    <a href="{{ route('checkout') }}" class="btn mt-3 bg-sky-600 text-white">
                        {{ translate('Checkout') }}
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-panels.flyout-panel>
