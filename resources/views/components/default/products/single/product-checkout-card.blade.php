@php($first_variation = $product->variations->first())

<div class="w-full relative mt-5" x-data="{
            processing: false,
            processing_variation_change: false,
            qty: 1,
            current_stock: {{ ($product->hasVariations()) ? $first_variation->current_stock : $product->current_stock }},
            is_low_stock: {{ ($product->hasVariations()) ? ($first_variation->isLowStock() ? 'true':'false') : ($product->isLowStock() ? 'true':'false') }},
            model_id: {{ ($product->hasVariations()) ? $first_variation->id : $product->id }},
            model_type: '{!!  ($product->hasVariations()) ? base64_encode($first_variation) : base64_encode($product::class) !!}',
            total_price: {{ ($product->hasVariations()) ? $first_variation->total_price : $product->total_price }},
            total_price_display: '{{ ($product->hasVariations()) ? $first_variation->getTotalPrice(true) : $product->getTotalPrice(true) }}',
            base_price: {{ ($product->hasVariations()) ? $first_variation->base_price : $product->base_price }},
            base_price_display: '{{ ($product->hasVariations()) ? $first_variation->getBasePrice(true) : $product->getBasePrice(true) }}',
        }" @cart-processing-end.window="
            if(Number($event.detail.id) === Number(model_id) && model_type == $event.detail.model_type) {
                qty = 1;
                processing = false;
                $dispatch('display-flyout-panel', {'id': 'cart-panel'});
            }
        " @if($product->hasVariations())
    @variation-changed.window="
        qty = 0;
        current_stock = $event.detail.current_stock;
        is_low_stock = $event.detail.is_low_stock;
        model_id = $event.detail.model_id;
        model_type = $event.detail.model_type;
        total_price = $event.detail.total_price;
        total_price_display = $event.detail.total_price_display;
        base_price = $event.detail.base_price;
        base_price_display = $event.detail.base_price_display;
    "
    @endif
    >
    <x-ev.loaders.spinner class="absolute-center z-10" x-show="processing_variation_change" x-cloak>
    </x-ev.loaders.spinner>

    <div class="w-full" :class="{'opacity-3':processing_variation_change}">

        <div class="w-full flex flex-col pb-5 border-b border-gray-200">
            <livewire:tenant.product.price :model="$product" :with_label="true" :with-discount-label="true"
                original-price-class="text-body text-16" total-price-class="text-24 fw-700 text-primary">
            </livewire:tenant.product.price>

            {{-- Variations Selector --}}
            @if($product->hasVariations())
            <livewire:tenant.product.product-variations-selector :product="$product" class="mt-2">
            </livewire:tenant.product.product-variations-selector>
            @endif

            @if($product->track_iventory)
                <p class="py-2 mb-0">
                    <span class="text-18 text-body font-semibold">{{ translate('Stock:') }}</span>
                    @if($product->showUnits())
                        <strong x-text="current_stock + ' {{ $product->unit }}'"></strong>
                    @else
                        <strong x-text="current_stock + ' {{ $product->unit }}'"></strong>
                    @endif

                    @if($product->isInStock())
                    <span class="badge-success px-2 py-2 ml-2 !text-14 items-center !font-semibold">{{ translate('In
                        Stock') }}</span>
                    @else
                    <span class="badge-danger px-2 py-2 ml-2 !text-14 items-center !font-semibold">{{ translate('Not In
                        Stock') }}</span>
                    @endif
                </p>
            @endif

            {{-- Out of stock / Low stock notifications --}}
            {{-- <template x-if="current_stock <= 0">
                <p class="text-14 p-2 px-3 bg-danger text-white rounded mt-1">{{ translate('This item is not
                    currently in stocks...') }}</p>
            </template>
            <template x-if="current_stock > 0 && is_low_stock">
                <p class="text-14 p-2 px-3 bg-warning text-white rounded mt-1">{{ translate('This item is low in
                    stocks. Hurry up!') }}</p>
            </template> --}}

            {{-- DONE: Disable add to cart button and quantity counter if available stock is <= 0 --}} <div
                class="w-full flex mt-3">
                <x-system.quantity-counter :model="$product" class="mr-5"></x-system.quantity-counter>

                @if(\Payments::isStripeEnabled() && \Payments::isStripeCheckoutEnabled())
                <x-system.buy-now-button :model="$product" class="" label="{{ translate('Buy now') }}"
                    label-not-in-stock="{{ translate('Not in stock') }}">
                </x-system.buy-now-button>
                @else
                <x-system.add-to-cart-button :model="$product" class="" label="{{ translate('Add to cart') }}"
                    label-not-in-stock="{{ translate('Not in stock') }}">
                </x-system.add-to-cart-button>
                @endif
        </div>

        <div class="w-full">
            <livewire:actions.social-action-button action="wishlist" template="wishlist-button-detailed" :object="$product">
            </livewire:actions.social-action-button>
        </div>
    </div>




</div>
