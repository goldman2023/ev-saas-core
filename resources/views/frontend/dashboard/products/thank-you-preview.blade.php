@extends('frontend.layouts.app')

@php
$first_item = $product;
$is_bookable_product = $first_item instanceof \App\Models\Product && $first_item->isBookableService();
@endphp

@section('meta_title'){{ translate('Your order is received').' - '.\TenantSettings::get('site_name').' |
'.\TenantSettings::get('site_motto') }}@stop

@section('meta_keywords'){{ translate('order, thank you page, checkout, cart, purchase, ecommerce') }}@stop

@section('meta')
@if($is_bookable_product)
<link href="https://calendly.com/assets/external/widget.css" rel="stylesheet">
<script src="https://calendly.com/assets/external/widget.js" type="text/javascript"></script>
@endif
@endsection

@section('content')
<section class="bg-white">
    <div class="max-w-3xl mx-auto px-4 py-16 sm:px-6 sm:py-16 lg:px-8">
        <div class="w-full mb-3">
            <h1 class="text-sm font-semibold uppercase tracking-wide text-primary">{{ translate('Thank you!') }}</h1>

            @if($first_item->type === \App\Enums\ProductTypeEnum::bookable_service()->value)
            <p class="mt-2 text-4xl font-extrabold tracking-tight sm:text-5xl">{{ translate('Please review your order')
                }}</p>
            <p class="mt-2 text-base text-gray-500 mb-4">{{ translate('Your order #%d% has been processed. Please select
                the available booking time.') }}</p>

            <div class="w-full mb-4">
                @if($is_bookable_product)
                <button type="button" class="btn-primary"
                    @click="Calendly.showPopupWidget('{{ $first_item->getBookingLink() }}');">
                    {{ translate('Schedule a meeting') }}
                </button>
                @endif
            </div>
            @elseif($first_item->type === \App\Enums\ProductTypeEnum::standard()->value)
            <p class="mb-2 text-4xl font-extrabold tracking-tight sm:text-5xl">{{ translate('We are processing the
                order!') }}</p>
            <p class="mb-2 text-base text-gray-500">{{ translate('Your order #%d% has been received and will be
                processed asap.') }}</p>

            <div class="badge-info py-2 mb-2 text-18">{{ translate('processing') }}</div>

            <p class="text-base text-gray-500">{{ translate('Orders usually ship withing 2 days and you will receive
                tracking number and order tracking details.') }}</p>
            @else
            <p class="mt-2 text-4xl font-extrabold tracking-tight sm:text-5xl">{{ translate('Please review your order')
                }}</p>
            <p class="mt-2 text-base text-gray-500 mb-4">{{ translate('Your order #%d% has been processed.') }}</p>
            @endif

            @if(!empty($first_item->getCoreMeta('unlockables')))
            <a href="{{ route('product.single.unlockable_content', ['slug' => $first_item->slug]) }}"
                class="btn-primary">
                {{ translate('See purchased content') }}
            </a>
            @endif

            @if(!empty($first_item->getCoreMeta('thank_you_cta_custom_url')) &&
            !empty($first_item->getCoreMeta('thank_you_cta_custom_button_title')))
            <section class="py-4 md:py-6 mt-4 md:mt-6 border-t border-gray-200"
                style="background-image: url('flex-ui-assets/elements/pattern-white.svg'); background-position: center;">
                <div class="container px-4 mx-auto">
                    <div class="flex flex-wrap items-center -mx-4">
                        <div class="w-full md:w-1/2 px-4 mb-14 md:mb-0">
                            <div class="max-w-md">
                                <h2 class="mb-2 text-18 md:text-20 font-heading font-bold">{{
                                    $first_item->getCoreMeta('thank_you_cta_custom_title') }}</h2>
                                <p class="text-14 md:text-16 font-heading font-medium text-gray-600">{{
                                    $first_item->getCoreMeta('thank_you_cta_custom_text') }}</p>
                            </div>
                        </div>
                        <div class="w-full md:w-1/2 px-4">
                            <div class="flex flex-wrap items-center md:justify-end">
                                <a class="btn-primary" href="{{ $first_item->getCoreMeta('thank_you_cta_custom_url') }}"
                                    target="_blank">
                                    {{ $first_item->getCoreMeta('thank_you_cta_custom_button_title') }}
                                </a>
                            </div>
                        </div>
                    </div>
            </section>
            @endif

            {{-- <dl class="mt-12 text-sm font-medium">
                <dt class="text-gray-900">Tracking number</dt>
                <dd class="text-indigo-600 mt-2">51547878755545848512</dd>
            </dl> --}}
        </div>

        <div class="border-t border-gray-200">
            <h2 class="sr-only">Your order</h2>

            <h3 class="sr-only">Items</h3>

            {{-- @if($order->order_items->isNotEmpty())
            @foreach($order->order_items as $item) --}}
            {{-- @dd($item->subject) --}}
            <div class="w-full flex flex-col">
                <div class="py-10 border-b border-gray-200 flex space-x-6">
                    <img src="{{ $first_item->getThumbnail(['w' => 600]) }}" alt=""
                        class="flex-none w-20 h-20 object-center object-contain bg-gray-100 rounded-lg sm:w-40 sm:h-40">
                    <div class="flex-auto flex flex-col">
                        <div>
                            <h4 class="font-semibold text-gray-900">
                                <span>{{ $first_item->name }}</span>
                            </h4>
                            <p class="mt-2 text-sm text-gray-600 line-clamp-3">
                                {!! $first_item->excerpt !!}
                            </p>
                        </div>
                        <div class="mt-6 flex-1 flex items-end">
                            <dl class="flex text-sm divide-x divide-gray-200 space-x-4 sm:space-x-6">
                                <div class="flex">
                                    <dt class="font-semibold text-gray-900">{{ translate('Quantity') }}</dt>
                                    <dd class="ml-2 text-gray-700">{{ $first_item->quantity }}</dd>
                                </div>
                                <div class="pl-4 flex sm:pl-6">
                                    <dt class="font-semibold text-gray-900">{{ translate('Price') }}</dt>
                                    <dd class="ml-2 text-gray-700">{{ FX::formatPrice($first_item->total_price *
                                        $first_item->quantity) }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
            {{-- @endforeach
            @endif --}}

            {{-- @do_action('view.order-received.items.end', $order) --}}

            <div class="sm:ml-40 sm:pl-6">
                {{-- @if(!$order->is_temp)
                <dl class="grid grid-cols-2 gap-x-6 text-sm py-6">
                    @if($order->same_billing_shipping || !empty($order->shipping_address))
                    <div>
                        @if($order->same_billing_shipping)
                        <dt class="font-medium text-gray-900">{{ translate('Shipping address') }}</dt>
                        <dd class="mt-2 text-gray-700">
                            <address class="not-italic">
                                <span class="block">{{ $order->billing_first_name.' '.$order->billing_last_name
                                    }}</span>
                                <span class="block">{{ $order->billing_address }}</span>
                                <span class="block">{{ $order->billing_city }}, {{ $order->billing_zip }}</span>
                                <span class="block">{{ (!empty($order->billing_state) ? $order->billing_state.', ' :
                                    '').\Countries::get(code: $order->billing_country)->name }}</span>
                            </address>
                        </dd>
                        @elseif(!empty($order->shipping_address))
                        <dt class="font-medium text-gray-900">{{ translate('Shipping address') }}</dt>
                        <dd class="mt-2 text-gray-700">
                            <address class="not-italic">
                                <span class="block">{{ $order->shipping_first_name.' '.$order->shipping_last_name
                                    }}</span>
                                <span class="block">{{ $order->shipping_address }}</span>
                                <span class="block">{{ $order->shipping_city }}, {{ $order->shipping_zip }}</span>
                                <span class="block">{{ (!empty($order->shipping_state) ? $order->shipping_state.', ' :
                                    '').\Countries::get(code: $order->shipping_country)->name }}</span>
                            </address>
                        </dd>
                        @endif
                    </div>
                    @endif

                    <div>
                        <dt class="font-medium text-gray-900">{{ translate('Billing address') }}</dt>
                        <dd class="mt-2 text-gray-700">
                            <address class="not-italic">
                                <span class="block">{{ $order->billing_first_name.' '.$order->billing_last_name
                                    }}</span>
                                <span class="block">{{ $order->billing_address }}</span>
                                <span class="block">{{ $order->billing_city }}, {{ $order->billing_zip }}</span>
                                <span class="block">{{ (!empty($order->billing_state) ? $order->billing_state.', ' :
                                    '').\Countries::get(code: $order->billing_country)->name }}</span>
                            </address>
                        </dd>
                    </div>
                </dl>
                @endif --}}

                <h4 class="sr-only">Payment</h4>
                {{-- <dl class="grid grid-cols-2 gap-x-6 border-t border-gray-200 text-sm py-10">
                    <div>
                        <dt class="font-medium text-gray-900">Payment method</dt>
                        <dd class="mt-2 text-gray-700">
                            <p>Apple Pay</p>
                            <p>Mastercard</p>
                            <p><span aria-hidden="true">•••• </span><span class="sr-only">Ending in </span>1545</p>
                        </dd>
                    </div>
                    <div>
                        <dt class="font-medium text-gray-900">Shipping method</dt>
                        <dd class="mt-2 text-gray-700">
                            <p>DHL</p>
                            <p>Takes up to 3 working days</p>
                        </dd>
                    </div>
                </dl> --}}

                <h3 class="sr-only">Summary</h3>

                <dl class="space-y-6 border-t border-gray-200 text-sm pt-6">
                    <div class="flex justify-between">
                        <dt class="font-medium text-gray-900">{{ translate('Subtotal') }}</dt>
                        <dd class="text-gray-700">{{ \FX::formatPrice($first_item->base_price) }}</dd>
                    </div>
                    {{-- <div class="flex justify-between">
                        <dt class="flex font-medium text-gray-900">
                            {{ translate('Discount') }}
                            <span
                                class="rounded-full bg-gray-200 text-xs text-gray-600 py-0.5 px-2 ml-2">STUDENT50</span>
                        </dt>
                        <dd class="text-gray-700">-{{ \FX::formatPrice($first_item->discount_amount) }}</dd>
                    </div> --}}
                    <div class="flex justify-between">
                        <dt class="font-medium text-gray-900">{{ translate('Shipping') }}</dt>
                        <dd class="text-gray-700">0</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="font-semibold text-gray-900">{{ translate('Total') }}</dt>
                        <dd class="font-semibold text-gray-900">{{ \FX::formatPrice($first_item->total_price) }}</dd>
                    </div>
                </dl>
            </div>

        </div>
    </div>
</section>
@endsection
