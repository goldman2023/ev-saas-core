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
            addons: [], // TODO: Addons should be object with keys as following: {model_id}-{base64_model_type}
            toggleAddon(addon_id, addon_type, addon_qty) {
                let addonIndex = this.addons.findIndex((addon) => addon.id == addon_id && addon.model_type == addon_type);

                if(addonIndex >= 0) {
                    // In addons array already - remove it
                    this.addons.splice(addonIndex, 1);
                } else {
                    // Not in addons array yet - push it
                    this.addons.push({
                        model_type: addon_type,
                        id: addon_id,
                        qty: addon_qty
                    });
                }
            }
        }" @cart-processing-end.window="
            if(Number($event.detail.id) === Number(model_id) && model_type == $event.detail.model_type) {
                qty = 1;
                addons = [];
                processing = false;

                $dispatch('display-flyout-panel', {'id': 'cart-panel'});
            }
        "
        @if($product->hasVariations())
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
            {{-- TODO: use we-price instead or something like that... --}}
            <livewire:tenant.product.price :model="$product" :with_label="true" :with-discount-label="true"
                original-price-class="text-body text-16" total-price-class="text-24 fw-700 text-primary">
            </livewire:tenant.product.price>

            {{-- Variations Selector --}}
            @if($product->hasVariations())
                <livewire:tenant.product.product-variations-selector :product="$product" class="mt-2">
                </livewire:tenant.product.product-variations-selector>
            @endif

            {{-- Product Addons --}}
            @if($product->product_addons->isNotEmpty())
                <fieldset class="border-t border-b border-gray-200 my-3" wire:ignore>
                    <div class="divide-y divide-gray-200">
                        @foreach($product->product_addons as $addon)
                            <div class="relative flex items-start py-4" x-data="{
                                reactiveChecked($el) {
                                    {{-- Reason for not using alpine's `:checked` and using x-effect instead, is that :checked doesn't work as expected and is not reactive when addons = [] is done somewhere in code - it doesn't deselect. --}}
                                    {{-- x-effect is alpine's core reactivity function, so it has to work! --}}
                                    if(addons.findIndex((addon) => addon.id == {{ $addon->id }} && addon.model_type == '{{ base64_encode($addon::class) }}') >= 0) {
                                        $el.checked = true;
                                    } else {
                                        $el.checked = false;
                                    }
                                }
                            }">
                                <div class="mr-3 flex h-5 items-center cursor-pointer">
                                    <input id="product-addon-{{ $addon->slug.'-'.$addon->id }}" type="checkbox" value="{{ $addon->id }}"
                                        x-on:change="toggleAddon({{ $addon->id }}, '{{ base64_encode($addon::class) }}', 1)"
                                        x-effect="reactiveChecked($el)"
                                        class="h-4 w-4 rounded border-gray-300 text-primary" wire:ignore.self>
                                </div>

                                <div class="min-w-0 flex-1 text-sm">
                                    <label for="product-addon-{{ $addon->slug.'-'.$addon->id }}" class="flex justify-between font-medium text-gray-700">
                                        <strong>{{ $addon->name }}</strong>
                                        <x-system.we-price :model="$addon"></x-system.we-price>
                                    </label>

                                    <p class="text-gray-500 line-clamp-1">{{ $addon->excerpt }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </fieldset>
            @endif
            {{-- END Product Addons --}}


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

            {{-- DONE: Disable add to cart button and quantity counter if available stock is <= 0 --}}
            <div class="w-full flex mt-3">
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

        </div>
    </div>
</div>
