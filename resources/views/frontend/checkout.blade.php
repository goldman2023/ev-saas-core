@extends('frontend.layouts.' . $globalLayout)

@section('meta_title'){{ translate('Checkout page').' '.\TenantSettings::get('site_name').' | '.\TenantSettings::get('site_motto') }}@stop

@section('meta_keywords'){{ translate('checkout, cart, purchase, ecommerce') }}@stop

@section('meta')

@endsection

@section('content')
    <section class="checkout position-relative mb-5"
        x-data="{
            selected_shipping_method: 0
        }"
    >
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="bg-white rounded card">
                        asd
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="bg-white rounded card">
                        <div class="card-body">
                            <div class="border-bottom pb-2 mb-3">
                                <h3 class="card-header-title">{{ translate('Order summary') }}</h3>
                            </div>

                            <div class="">
                                @if($cart_items->isNotEmpty())
                                    @foreach($cart_items as $item)
                                        @php
                                            $has_variations = ($item->main instanceof \App\Models\EVBaseModel) ? $item->main->getTranslation('name') : $item->hasVariations();
                                            $name = ($item->main instanceof \App\Models\EVBaseModel) ? $item->main->getTranslation('name') : $item->getTranslation('name');
                                            $excerpt = ($item->main instanceof \App\Models\EVBaseModel) ? $item->main->getTranslation('excerpt') : $item->getTranslation('excerpt');
                                            $permalink = ($item->main instanceof \App\Models\EVBaseModel) ? $item->main->permalink : $item->permalink;
                                            $variant_name = $item->getVariantName(key_by: 'name');
                                        @endphp

                                        <!-- Cart Item -->
                                            <div class="border-bottom pb-3 mb-3">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0">
                                                        <div class="avatar avatar-lg mr-3">
                                                            <a href="{{ $permalink }}" target="_blank">
                                                                <img class="avatar-img border" src="{{ $item->getThumbnail(['w'=>100,'h'=>100]) }}" alt="{{ $name }}">
                                                                <sup class="avatar-status bg-primary text-white">{{ $item->purchase_quantity }}</sup>
                                                            </a>
                                                        </div>
                                                    </div>

                                                    <div class="flex-grow-1">
                                                        <h6 class="clearfix mb-1">
                                                            <div class="badge badge-soft-info float-right">
                                                                {{ \FX::formatPrice($item->purchase_quantity * $item->total_price) }}
                                                            </div>

                                                            <a href="{{ $permalink }}" target="_blank">
                                                                {{ $name }}
                                                            </a>
                                                        </h6>

                                                        @if($has_variations)
                                                            <div class="d-grid">
                                                                @if($variant_name->isNotEmpty())
                                                                    @foreach($variant_name as $attribute_name => $attribute_value)
                                                                        <div class="text-body lh-13">
                                                                            <span class="small">{{ $attribute_name }}:</span>
                                                                            <span class="small">{{ $attribute_value }}</span>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        @else
                                                            <span class="clamp text-12 mb-2" data-clamp-lines="2">{{ $excerpt }}</span>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Cart Item -->
                                    @endforeach



                                        <!-- Subtotal Calculation -->
                                        <div class="border-bottom pb-2 mb-3">
                                            <div class="d-grid gap-3">
                                                <dl class="row mb-1">
                                                    <dt class="col-sm-6">{{ translate('Items') }} ({{ $total_items_count }})</dt>
                                                    <dd class="col-sm-6 text-right mb-0 "><strong>{{ $originalPrice['display'] }}</strong></dd>
                                                </dl>

                                                <dl class="row mb-1">
                                                    <dt class="col-sm-6">{{ translate('Discount') }}</dt>
                                                    <dd class="col-sm-6 text-right text-success mb-0"><strong>-{{ $discountedAmount['display'] }}</strong></dd>
                                                </dl>

                                                {{-- TODO: Add Shipping Cost (and shipping  and VAT cost. Is discount calculated when VAT is included in price or not? --}}

                                                <span class="divider divider-third-right py-2"></span>

                                                <dl class="row mb-1">
                                                    <dt class="col-sm-6">{{ translate('Subtotal') }}</dt>
                                                    <dd class="col-sm-6 text-right mb-0 "><strong>{{ $subtotalPrice['display'] }}</strong></dd>
                                                </dl>

                                            </div>
                                        </div>
                                        <!-- End Subtotal Calculation -->

                                        <!-- Shipping Method Selector -->
                                        <div class="border-bottom pb-3 mb-3">
                                            <div class="d-grid gap-3">
                                                <!-- Check -->
                                                <div class="form-check pointer">
                                                    <input class="form-check-input" type="radio" name="deliveryRadioName" id="deliveryRadio1Eg2"
                                                           x-bind:checked="selected_shipping_method === 0"
                                                           @click="selected_shipping_method=0">
                                                    <label class="form-check-label text-dark pointer" for="deliveryRadio1Eg2">
                                                        Free - Standard delivery
                                                        <span class="d-block text-muted small">Shipment may take 10+ business days</span>
                                                    </label>
                                                </div>
                                                <!-- End Check -->

                                                <!-- Check -->
                                                <div class="form-check pointer">
                                                    <input class="form-check-input" type="radio" name="deliveryRadioName" id="deliveryRadio2Eg2"
                                                           x-bind:checked="selected_shipping_method === 1"
                                                           @click="selected_shipping_method=1">
                                                    <label class="form-check-label text-dark pointer" for="deliveryRadio2Eg2">
                                                        $9.99 - Express delivery
                                                        <span class="d-block text-muted small">Shipment may take 2-3 business days</span>
                                                    </label>
                                                </div>
                                                <!-- End Check -->
                                            </div>
                                        </div>
                                        <!-- End Shipping Method Selector -->

                                        <!-- Total Calculation -->
                                        <div class="">
                                            <div class="d-grid gap-3">
                                                <dl class="row mb-1">
                                                    <dt class="col-sm-6">{{ translate('Delivery') }}</dt>
                                                    <dd class="col-sm-6 text-right mb-0">Free</dd>
                                                </dl>
                                                <dl class="row mb-0">
                                                    <dt class="col-sm-6 capitalize">{{ translate('Total') }}</dt>
                                                    <dd class="col-sm-6 text-right text-dark mb-0 "><strong>{{ $subtotalPrice['display'] }}</strong></dd>
                                                </dl>
                                            </div>
                                        </div>
                                        <!-- End Total Calculation -->

                                        <div class="d-flex flex-column">
                                            <a href="{{ '#' }}" class="btn btn-primary mt-3">
                                                {{ translate('Confirm order') }}
                                            </a>
                                            <a href="{{ route('cart') }}" class="d-none align-items-center w-100 justify-content-center text-dark text-12 mt-3">
                                                @svg('heroicon-o-chevron-left', ['class' => 'square-12 mr-1'])
                                                <span>{{ translate('or go back to cart') }}</span>
                                            </a>
                                        </div>
                                @else
                                    <!-- Empty Cart Section -->
                                    <div class="container-fluid space-2">
                                        <div class="text-center mx-md-auto">
                                            <figure class="max-w-10rem max-w-sm-15rem mx-auto mb-3">
                                                @svg('lineawesome-shopping-cart-solid', ['class' => 'text-dark', 'style' => 'width: 72px;'])
                                            </figure>
                                            <div class="mb-5">
                                                <h3 class="h3">{{ translate('Your cart is currently empty') }}</h3>
                                                <p>{{ translate('Before you can checkout you must add some products to your shopping cart.') }}</p>
                                            </div>
                                            <a class="btn btn-primary btn-pill transition-3d-hover px-5" href="{{ route('search') }}">
                                                {{ translate('Start Shopping') }}
                                            </a>
                                        </div>
                                    </div>
                                    <!-- End Empty Cart Section -->
                                @endif

                            </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('modal')
