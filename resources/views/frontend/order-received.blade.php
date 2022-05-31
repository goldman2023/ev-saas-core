@extends('frontend.layouts.' . $globalLayout)

@php
  $first_item = $order->order_items->first()->subject;
  $is_bookable_product = $first_item instanceof \App\Models\Product && $first_item->isBookableService();
@endphp

@section('meta_title'){{ translate('Your order is received').' - '.\TenantSettings::get('site_name').' | '.\TenantSettings::get('site_motto') }}@stop

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
        @if($order->isAbandoned())
          <h1 class="text-sm font-semibold uppercase tracking-wide text-danger">{{ translate('Not processed') }}</h1>
        @elseif($order->isPendingPayment())
          <h1 class="text-sm font-semibold uppercase tracking-wide text-info">{{ translate('In checkout process') }}</h1>
        @else
          <h1 class="text-sm font-semibold uppercase tracking-wide text-primary">{{ translate('Thank you!') }}</h1>
        @endif

        @if($order->isAbandoned())
          <p class="mt-2 text-4xl font-extrabold tracking-tight sm:text-5xl">{{ translate('Abandoned order!') }}</p>
          <p class="mt-2 text-base text-gray-500 mb-4">{{ str_replace('%d%', $order->id, 'Your order #%d% has been abandoned. You can always continue with purchase by clicking the button below.') }}</p>

          <a href="{{ $order->getAbandonedOrderStripeCheckoutPermalink() }}" class="btn-primary">
            {{ translate('Revive order') }}
          </a>
        @elseif($order->isPendingPayment())
          <p class="mt-2 text-4xl font-extrabold tracking-tight sm:text-5xl">{{ translate('Please review your order') }}</p>
          <p class="mt-2 text-base text-gray-500 mb-4">{{ str_replace('%d%', $order->id, 'Your order #%d% is either waiting for checkout to be finished or is currently being processed by payment processor. Please continue with checkout process or wait until the payment is realized.') }}</p>
        @elseif($first_item instanceof \App\Models\Plan)
          <p class="mt-2 text-4xl font-extrabold tracking-tight sm:text-5xl">{{ translate('Successfully bought a plan!') }}</p>
          <p class="mt-2 text-base text-gray-500 mb-4">{{ str_replace('%d%', $order->id, 'Your order #%d% has been processed. You have successfully subscribed to plan listed below.') }}</p>
        @elseif($first_item->type === \App\Enums\ProductTypeEnum::bookable_service()->value)
          <p class="mt-2 text-4xl font-extrabold tracking-tight sm:text-5xl">{{ translate('Please review your order') }}</p>
          <p class="mt-2 text-base text-gray-500 mb-4">{{ str_replace('%d%', $order->id, 'Your order #%d% has been processed. Please select the available booking time.') }}</p>

          <div class="w-full mb-4">
            @if($is_bookable_product)
              <button type="button" class="btn-primary" @click="Calendly.showPopupWidget('{{ $first_item->getBookingLink() }}');">
                {{ translate('Schedule a meeting') }}
              </button>
            @endif
          </div>
        @elseif($first_item->type === \App\Enums\ProductTypeEnum::standard()->value)
          <p class="mb-2 text-4xl font-extrabold tracking-tight sm:text-5xl">{{ translate('We are processing the order!') }}</p>
          <p class="mb-2 text-base text-gray-500">{{ str_replace('%d%', $order->id, 'Your order #%d% has been received and will be processed asap.') }}</p>

          <div class="badge-info py-2 mb-2 text-18">{{ translate('processing') }}</div>

          <p class="text-base text-gray-500">{{ translate('Orders usually ship withing 2 days and you will receive tracking number and order tracking details.') }}</p>
        @endif

        
        {{-- <dl class="mt-12 text-sm font-medium">
          <dt class="text-gray-900">Tracking number</dt>
          <dd class="text-indigo-600 mt-2">51547878755545848512</dd>
        </dl> --}}
      </div>
  
      <div class="border-t border-gray-200">
        <h2 class="sr-only">Your order</h2>
  
        <h3 class="sr-only">Items</h3>
  
        @if($order->order_items->isNotEmpty())
            @foreach($order->order_items as $item)
              {{-- @dd($item->subject) --}}
              <div class="w-full flex flex-col">
                <div class="py-10 border-b border-gray-200 flex space-x-6">
                  <img src="{{ $item->subject->getThumbnail(['w' => 600]) }}" alt="" class="flex-none w-20 h-20 object-center object-contain bg-gray-100 rounded-lg sm:w-40 sm:h-40">
                  <div class="flex-auto flex flex-col">
                    <div>
                        <h4 class="font-semibold text-gray-900">
                            <span>{{ $item->name }}</span>
                        </h4>
                        <p class="mt-2 text-sm text-gray-600 line-clamp-3">{{ $item->excerpt }}</p>
                    </div>
                    <div class="mt-6 flex-1 flex items-end">
                        <dl class="flex text-sm divide-x divide-gray-200 space-x-4 sm:space-x-6">
                            <div class="flex">
                                <dt class="font-semibold text-gray-900">{{ translate('Quantity') }}</dt>
                                <dd class="ml-2 text-gray-700">{{ $item->quantity }}</dd>
                            </div>
                            <div class="pl-4 flex sm:pl-6">
                                <dt class="font-semibold text-gray-900">{{ translate('Price') }}</dt>
                                <dd class="ml-2 text-gray-700">{{ FX::formatPrice($item->total_price * $item->quantity) }}</dd>
                            </div>
                        </dl>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
        @endif
        
        @do_action('view.order-received.items.end', $order)

        <div class="grid grid-cols-3">
          @if(!$order->is_temp)
            <div class="col-span-3 md:col-span-1 py-4 md:py-6 space-y-0 space-x-3 md:space-x-0 md:space-y-3 border-b border-gray-200 md:border-none">
              @if(!empty($order->invoices->first()?->meta['test_stripe_hosted_invoice_url'] ?? null))
                <a href="{{ $order->invoices->first()?->meta['test_stripe_hosted_invoice_url'] ?? '#' }}" target="_blank" class="btn-primary">
                  {{ translate('Latest invoice') }}
                </a>
              @endif

              @if($order->order_items?->first()?->subject?->isSubscribable() ?? false)
                <a href="{{ route('stripe.portal_session') }}" target="_blank" class="btn-primary">
                  {{ translate('Billing portal') }}
                </a>
              @endif
            </div>
            <dl class="grid grid-cols-2 col-span-3 md:col-span-2 gap-x-6 text-sm py-6">
              @if($order->same_billing_shipping || !empty($order->shipping_address))
                <div>
                  @if($order->same_billing_shipping)
                    <dt class="font-medium text-gray-900">{{ translate('Shipping address') }}</dt>
                    <dd class="mt-2 text-gray-700">
                      <address class="not-italic">
                        <span class="block">{{ $order->billing_first_name.' '.$order->billing_last_name }}</span>
                        <span class="block">{{ $order->billing_address }}</span>
                        <span class="block">{{ $order->billing_city }}, {{ $order->billing_zip }}</span>
                        <span class="block">{{ (!empty($order->billing_state) ? $order->billing_state.', ' : '').\Countries::get(code: $order->billing_country)->name }}</span>
                      </address>
                    </dd>
                  @elseif(!empty($order->shipping_address))
                    <dt class="font-medium text-gray-900">{{ translate('Shipping address') }}</dt>
                    <dd class="mt-2 text-gray-700">
                      <address class="not-italic">
                        <span class="block">{{ $order->shipping_first_name.' '.$order->shipping_last_name }}</span>
                        <span class="block">{{ $order->shipping_address }}</span>
                        <span class="block">{{ $order->shipping_city }}, {{ $order->shipping_zip }}</span>
                        <span class="block">{{ (!empty($order->shipping_state) ? $order->shipping_state.', ' : '').\Countries::get(code: $order->shipping_country)->name }}</span>
                      </address>
                    </dd>
                  @endif
                </div>
              @endif

              <div>
                <dt class="font-medium text-gray-900">{{ translate('Billing address') }}</dt>
                <dd class="mt-2 text-gray-700">
                  <address class="not-italic">
                    <span class="block">{{ $order->billing_first_name.' '.$order->billing_last_name }}</span>
                    <span class="block">{{ $order->billing_address }}</span>
                    <span class="block">{{ $order->billing_city }}, {{ $order->billing_zip }}</span>
                    <span class="block">{{ (!empty($order->billing_state) ? $order->billing_state.', ' : '').\Countries::get(code: $order->billing_country)->name }}</span>
                  </address>
                </dd>
              </div>


            </dl>
          @endif

          <dl class="space-y-6 border-t border-gray-200 text-sm pt-6 col-start-1 md:col-start-2 col-end-4">
            <div class="flex justify-between">
              <dt class="font-medium text-gray-900">{{ translate('Subtotal') }}</dt>
              <dd class="text-gray-700">{{ \FX::formatPrice($order->base_price) }}</dd>
            </div>
            <div class="flex justify-between">
              <dt class="flex font-medium text-gray-900">
                {{ translate('Discount') }}
                {{-- <span class="rounded-full bg-gray-200 text-xs text-gray-600 py-0.5 px-2 ml-2">STUDENT50</span> --}}
              </dt>
              <dd class="text-gray-700">-{{ \FX::formatPrice($order->discount_amount) }}</dd>
            </div>
            <div class="flex justify-between">
              <dt class="font-medium text-gray-900">{{ translate('Shipping') }}</dt>
              <dd class="text-gray-700">0</dd>
            </div>
            <div class="flex justify-between">
              <dt class="font-semibold text-gray-900">{{ translate('Total') }}</dt>
              <dd class="font-semibold text-gray-900">{{ \FX::formatPrice($order->total_price) }}</dd>
            </div>
          </dl>
        </div>
        
      </div>
    </div>
</section>  
@endsection
