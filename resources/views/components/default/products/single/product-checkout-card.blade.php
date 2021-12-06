@php($first_variation = $product->getFirstVariation())

<div class="card"
        x-data="{
            processing: false,
            qty: 0,
            model_id: {{ $product->id }},
            model_type: '{!! addslashes($product::class) !!}',
            total_price: {{ ($product->hasVariations()) ? $first_variation->total_price : $product->total_price }},
            total_price_display: '{{ ($product->hasVariations()) ? $first_variation->getTotalPrice(true) : $product->getTotalPrice(true) }}',
            base_price: {{ ($product->hasVariations()) ? $first_variation->base_price : $product->base_price }},
            base_price_display: '{{ ($product->hasVariations()) ? $first_variation->getBasePrice(true) : $product->getBasePrice(true) }}',
        }"
        @cart-processing-ending.window="
            if(Number($event.detail.id) === Number(model_id) && model_type == $event.detail.model_type) {
                qty = 0;
                processing = false;
                $dispatch('display-cart');
            }
        "
        @if($product->hasVariations())
            @variation-changed.window="
                qty = 0;
                model_id = $event.detail.model_id;
                model_type = $event.detail.model_type;
                total_price = $event.detail.total_price;
                total_price_display = $event.detail.total_price_display;
                base_price = $event.detail.base_price;
                base_price_display = $event.detail.base_price_display;
            "
        @endif
>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12 d-flex flex-column">
                <h2 class="h3">{{ $product->getTranslation('name') }}</h1>

                @isset($product->brand)
                    <x-default.products.single.product-brand-box :product="$product"></x-default.products.single.product-brand-box>
                @endisset

                <p class="mb-0">
                    {{ $product->getTranslation('excerpt') }}
                </p>
            </div>

            <div class="col-12 mt-2 mb-2">
                <livewire:tenant.product.price
                    :model="$product"
                    :with_label="true"
                    :with-discount-label="true"
                    original-price-class="text-body text-16"
                    total-price-class="text-24 fw-700 text-primary"
                >
                </livewire:tenant.product.price>

                {{-- Variations Selector --}}
                <livewire:tenant.product.product-variations-selector
                    :product="$product"
                    class="mt-2"
                >


                </livewire:tenant.product.product-variations-selector>


                <x-default.forms.quantity-counter :model="$product" id=""></x-default.forms.quantity-counter>
            </div>


            <div class="col-12">
                <div class="row">
                    <div class="col-8 pr-2">
                        <livewire:cart.add-to-cart-button
                            :model="$product"
                            icon="heroicon-o-shopping-cart"
                            label="{{ translate('Add to cart') }}"
                            btn-type="primary"
                        >

                        </livewire:cart.add-to-cart-button>
                    </div>
                    <div class="col-4 pl-2">
                        <a
                            class="btn btn-secondary align-items-center d-flex justify-content-center align-items-center">
                            {{ svg('heroicon-o-heart', ['class' => 'ev-icon__xs mr-2']) }}
                            {{ translate('Like') }}
                        </a>
                    </div>
                </div>


                @guest
                    <a class="btn btn-sm d-flex mt-3 btn-dark justify-content-center text-center align-items-center">
                        {{ svg('heroicon-o-key', ['class' => 'ev-icon__xs mr-2']) }}
                        {{ translate('Join GunOB') }}

                    </a>
                    <div class="text-center">
                        <small>
                            {{ translate('Gun Enthusiast Marketplace and social network') }}
                        </small>
                        <br>
                    </div>
                @endguest

                <div class="text-center mt-3 d-flex align-items-center justify-content-center">
                    <div class="badge badge-soft-success mr-2 w-auto d-flex align-items-center">
                        {{ svg('heroicon-o-shield-check', ['class' => 'ev-icon__xs text-success mr-2']) }}

                        {{ translate('GunOB Buyers Protection + Escrow') }}
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
