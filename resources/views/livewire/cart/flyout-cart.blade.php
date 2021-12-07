<div x-data="{ show: false }" x-cloak
     x-init="$(document).on('keyup', function(e) { if (e.key == 'Escape' && show) {show = false} });">
    <section
        class="c-flyout-cart position-fixed bg-white shadow-lg"
        :class="{ 'show': show }"
        x-data="{
            processing: @entangle('processing').defer,
            targetItem: null
        }"
        x-init="$watch('show', (value) => {
            (!value) ? $('.cart-item').tooltip('dispose'): '';
        })"
        x-effect="window.initClamp('.c-flyout-cart');"
        @toggle-cart.window="show = !show"
        @display-cart.window="show = true"
        @cart-processing-ending.window="
            $nextTick(() => { // Wait for qty to be changed and then stop processing
                processing = false; // Turn off the Cart processing now. Reason is that if we change qty after turning processing off, we would run qty watcher again and initiate addToCart again!
            });
        "
    >
        <div class="h-100 d-flex flex-column position-relative p-4" >
            <x-ev.loaders.spinner class="absolute-center z-10 d-none"
                                  wire:loading.class.remove="d-none"></x-ev.loaders.spinner>

            <div class="d-flex flex-column h-100" wire:loading.class="opacity-3">
                <div class="c-flyout-cart__close square-32 d-flex align-items-center justify-content-center position-absolute pointer" @click="show = false">
                    @svg('heroicon-o-x', ['class' => 'square-16'])
                </div>

                <!-- Cart Header -->
                <h3 class="h4 mb-3 pb-2 border-bottom d-flex align-items-center">
                    <span>{{ translate('Cart') }}</span>
                    <span class="badge badge-soft-warning d-flex align-items-center px-2 py-1 ml-3 text-12 text-warning">
                    @svg('heroicon-s-shopping-bag', ['class' => 'square-14 mr-2'])
                    {{ str_replace('%x%', $totalItemsCount, translate('You have %x% items in your cart.')) }}
                </span>
                </h3>

                <!-- Cart Items -->
                <div class="c-flyout-cart__items d-flex flex-column mb-1 flex-grow-1">
                    @if($items->isNotEmpty())
                        @foreach($items as $item)
                            @php
                                $hasVariations = ($item->main instanceof \App\Models\EVBaseModel) ? $item->main->getTranslation('name') : $item->hasVariations();
                                $name = ($item->main instanceof \App\Models\EVBaseModel) ? $item->main->getTranslation('name') : $item->getTranslation('name');
                                $excerpt = ($item->main instanceof \App\Models\EVBaseModel) ? $item->main->getTranslation('excerpt') : $item->getTranslation('excerpt');
                            @endphp

                            <div id="cart-item-{{ $item->id }}-{{ str_replace('\\','-',$item::class) }}"
                                 class="cart-item card p-3 d-flex flex-row align-items-start mb-3"
                                 x-data="{
                                    qty: {{ $item->purchase_quantity }},
                                    model_id: {{ $item->id }},
                                    model_type: '{!! addslashes($item::class) !!}'
                                 }"
                                 x-init="
                                    $watch('qty', function(value) {
                                        if(!processing) {
                                            $($el).tooltip('dispose');
                                            $wire.addToCart(model_id, model_type, value, false);
                                        }
                                     });
                                "
                                 @cart-processing-ending.window="
                                    if(Number($event.detail.id) === Number(model_id) && model_type == $event.detail.model_type) {
                                        qty = $event.detail.qty;
                                    }
                                "
                                 @cart-item-warnings.window="
                                 {{-- TODO: Think of a way to determine if Cart is in transition(show: false -> true) and display warnings ONLY AFTER transition is over! --}}
                                     $nextTick(() => {
                                             if($event.detail.warnings.length > 0 && Number($event.detail.id) === Number(model_id) && model_type == $event.detail.model_type) {
                                                 $($el).tooltip({
                                                     placement: 'bottom',
                                                     html: true,
                                                     title: $event.detail.warnings[0].split('\\n').map(text => '<span>' + text + '</span><br>').join(''),
                                                     customClass: 'tooltip-danger tooltip-lg',
                                                     trigger: 'manual'
                                                 });
                                                 $($el).tooltip('show');

    {{-- TODO: Use clearTimeout() somehow to take care of issue when + or - are clicked few times in a row in less than 4s --}}
                                         setTimeout(() => {
                                             $($el).tooltip('hide');
                                             setTimeout(() => $($el).tooltip('dispose'), 1000);
                                         }, 4000);
                                     }
                             });
"
                            >
                                <div class="row full-row">

                                    <div class="c-flyout-cart__item-thumb col-3">
                                        <img src="{{ $item->getThumbnail(['w'=>100,'h'=>100]) }}" class="border rounded-lg fit-cover" />
                                    </div>

                                    <div class="d-flex flex-column col-6 px-0 pr-3 mt-1">
                                        <strong class="fw-600 text-16 w-100 clamp d-inline-block mb-0" data-clamp-lines="1" style="line-height: 1.2;">{{ $name }}</strong>

                                        @if(!$hasVariations)
                                            <span class="clamp text-12 mb-2" data-clamp-lines="1">{{ $excerpt }}</span>
                                        @else
                                            {{-- TODO: Display variation attributes here in one row: (Inspiration -> https://cdn.dribbble.com/users/4817709/screenshots/16356375/media/86177cbea95d2df2983700a6e54bac2f.png) --}}

                                            <ul class="c-flyout-cart__item-variations-name-list d-flex mb-0">
                                                @foreach($item->getVariantName(as_collection: true) as $name)
                                                    <li>{{ $name }}</li>
                                                @endforeach
                                            </ul>
                                        @endif

                                        <div class="bg-danger mr-auto square-18 rounded d-flex align-items-center justify-content-center pointer mt-auto"
                                             @click="$wire.removeFromCart(model_id, model_type)">
                                            @svg('heroicon-o-x', ['class' => 'square-12 text-white'])
                                        </div>
                                    </div>

                                    <div class="d-flex flex-column align-items-center justify-content-center col-3 pl-0 pr-3 ">
                                        <strong class="fw-600 text-14 text-primary mb-1" >
                                            <span class="spinner-border text-primary text-10 square-16 d-none" > </span>
                                            <span >{{ \FX::formatPrice($item->purchase_quantity * $item->total_price) }}</span>
                                        </strong>

                                        <x-default.forms.quantity-counter :model="$item" :wired="true" :mini="true"></x-default.forms.quantity-counter>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    @else
                        <!-- Empty Cart Section -->
                        <div class="container-fluid space-2">
                            <div class="text-center mx-md-auto">
                                <figure class="max-w-10rem max-w-sm-15rem mx-auto mb-3">
                                    @svg('lineawesome-shopping-cart-solid', ['class' => 'text-dark', 'style' => 'width: 72px;'])
                                </figure>
                                <div class="mb-5">
                                    <h3 class="h3">{{ translate('Your cart is currently empty') }}</h3>
                                    <p>{{ translate('Before proceed to checkout you must add some products to your shopping cart.') }}</p>
                                </div>
                                <a class="btn btn-primary btn-pill transition-3d-hover px-5" href="{{ route('search') }}">
                                    {{ translate('Start Shopping') }}
                                </a>
                            </div>
                        </div>
                        <!-- End Empty Cart Section -->
                    @endif

                </div>

                <!-- Cart Footer -->
                @if($items->isNotEmpty())
                    <div class="w-100 d-flex flex-column border-top pt-2">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span>{{ translate('Items:') }}</span>
                            <strong>{{ $originalPrice['display'] }}</strong>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span>{{ translate('Discounts:') }}</span>
                            <strong class="text-success">-{{ $discountedAmount['display'] }}</strong>
                        </div>

                        <span class="divider divider-third-right py-2"></span>

                        <div class="d-flex justify-content-between align-items-center">
                            <span>{{ translate('Subtotal:') }}</span>
                            <strong class="text-dark">{{ $subtotalPrice['display'] }}</strong>
                        </div>

                        <a href="{{ route('checkout') }}" class="btn btn-primary mt-3">
                            {{ translate('Checkout') }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <div class="c-flyout-cart__overlay"
         x-show="show"
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0 "
         x-transition:enter-end="opacity-7 "
         x-transition:leave="transition ease-in duration-500"
         x-transition:leave-start="opacity-7 "
         x-transition:leave-end="opacity-0 "
         @click="show = false"
    >
    </div>
</div>
