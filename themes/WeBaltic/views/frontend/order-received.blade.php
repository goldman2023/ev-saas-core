@extends('frontend.layouts.' . $globalLayout)

@php
  $first_item = $order_items->first()->subject;
@endphp

@section('meta_title'){{ translate('Your order is received').' - '.\TenantSettings::get('site_name').' | '.\TenantSettings::get('site_motto') }}@stop

@section('meta_keywords'){{ translate('order, thank you page, checkout, cart, purchase, ecommerce') }}@stop

@push('head_scripts')

@endpush

@section('content')

<x-theme::dashboard.orders.customer-order-steps :order="$order" class="mb-6 pt-[60px] static md:static"></x-theme::dashboard.orders.customer-order-steps>

<section class="bg-white">

    <div class="max-w-3xl mx-auto px-4 py-8 sm:px-6 sm:py-16 lg:px-8">
      <div class="w-full mb-3">
        <h1 class="text-sm font-semibold uppercase tracking-wide text-primary">{{ translate('Thank you!') }}</h1>

        @if($order->isAbandoned())
          <p class="mt-2 text-4xl font-extrabold tracking-tight sm:text-5xl">{{ translate('Abandoned order!') }}</p>
          <p class="mt-2 text-base text-gray-500 mb-4">{{ str_replace('%d%', $order->id, 'Your order #%d% has been abandoned. You can always continue with purchase by clicking the button below.') }}</p>

          <a href="{{ $order->getAbandonedOrderStripeCheckoutPermalink() }}" class="btn-primary">
            {{ translate('Revive order') }}
          </a>
        @elseif($order->isPendingPayment())
          <p class="mt-2 text-4xl font-extrabold tracking-tight sm:text-5xl">{{ translate('Please review your order') }}</p>
          <p class="mt-2 text-base text-gray-500 mb-4">{{ str_replace('%d%', $order->id, 'Your order #%d% is either waiting for checkout to be finished or is currently being processed by payment processor. Please continue with checkout process or wait until the payment is realized.') }}</p>
        @elseif($first_item->type === \App\Enums\ProductTypeEnum::standard()->value)
          <p class="mb-2 text-4xl font-extrabold tracking-tight sm:text-5xl">{{ translate('We are processing the order!') }}</p>
          <p class="mb-2 text-base text-gray-500">{{ str_replace('%d%', $order->id, 'Your order #%d% has been received and will be processed asap.') }}</p>

          <div class="flex flex-col space-y-1 mt-4 pt-4 border-t border-gray-200">
            <div class="flex gap-x-2">
              <dt class="text-gray-900">{{ translate('Due:') }}</dt>
              <dd class="font-medium text-gray-900">{{ translate('Now') }}</dd>
            </div>
            <div class="flex gap-x-2">
              <dt class="text-gray-900">{{ translate('Payment Method:') }}</dt>
              <dd class="font-medium text-gray-900">{{ $order->invoices->first()?->payment_method?->name ?? '' }}</dd>
            </div>
            <div class="flex gap-x-2 items-center">
              <dt class="text-gray-900">{{ translate('Status:') }}</dt>
              <dd class="badge-info py-2 text-18">{{ translate('processing') }}</dd>
            </div>
          </div>

          @auth
            <div class="block space-y-1 mt-1.5 pt-1.5">
                <a href="{{ route('order.details', $order->id) }}" class="btn-primary">
                  {{ translate('View Order') }}
                </a>
            </div>
          @endauth
        @endif
      </div>

      <div class="border-t border-gray-200">

        @php
          $flushed_addons = [];
        @endphp

        @if($order_items->isNotEmpty())
            @foreach($order_items as $item)
              <div class="w-full flex flex-col">
                <div class="py-10 border-b border-gray-200 flex space-x-6">
                  @if(!empty($item->subject))
                    <img src="{{ $item->subject->getThumbnail(['w' => 600]) }}" alt="" class="flex-none w-20 h-20 object-center object-contain bg-gray-100 rounded-lg sm:w-40 sm:h-40">
                  @endif
                  <div class="flex-auto flex flex-col">
                    <div>
                        <h4 class="font-semibold text-gray-900">
                            <span>{{ $item->name }}</span>
                        </h4>
                        <p class="mt-2 text-sm text-gray-600 line-clamp-3">
                            {!! $item->excerpt !!}
                        </p>

                        @if($item->descendants->isNotEmpty())
                          <ul class="w-full flex flex-col gap-y-2 mt-2">
                              @foreach($item->descendants as $addon_item)
                                  <li class="w-full flex items-center justify-between border border-gray-200 rounded px-2 py-1">
                                      <div class="flex items-center ">
                                        <span class="pr-2">+</span>
                                        <strong class="text-12 line-clamp-1 pr-2">{{ $addon_item->name }}</strong>
                                        <span class="text-12 line-clamp-1">{{ translate('Quantity:') }} {{ $addon_item->quantity }}</span>
                                      </div>
                                      
                                      <strong class="text-12 text-gray-900">{{ \FX::formatPrice($addon_item->total_price) }}</strong>
                                  </li>
                              @endforeach
                          </ul>
                        @endif
                    </div>
                    <div class="mt-6 flex-1 flex items-end">
                        <dl class="flex text-sm divide-x divide-gray-200 space-x-4 sm:space-x-6">
                            @if($order->type === 'standard' || $order->type === 'installments')
                              <div class="flex ">
                                <dt class="font-semibold text-gray-900">{{ translate('Unit price') }}:</dt>
                                <dd class="ml-2 text-gray-700">{{ FX::formatPrice($item->base_price) }}</dd>
                              </div>
                            @endif
                            <div class="@if($order->type === 'standard' || $order->type === 'installments') pl-4 flex sm:pl-6 @endif">
                                <dt class="font-semibold text-gray-900">{{ translate('Quantity') }}:</dt>
                                <dd class="ml-2 text-gray-700">{{ $item->quantity }}</dd>
                            </div>
                            <div class="pl-4 flex sm:pl-6">
                                <dt class="font-semibold text-gray-900">{{ translate('Total price') }}:</dt>

                                @if($item->descendants->isNotEmpty())
                                  @php
                                    $addons_total_sum = $item->descendants->reduce(function ($carry, $addon) {
                                        return $carry + $addon->total_price;
                                    });
                                  @endphp
                                  <dd class="ml-2 text-gray-700">
                                    {{ FX::formatPrice($item->total_price + $addons_total_sum) }} {{ $order->type === 'subscription' ? ' / ' . $order->invoicing_period : '' }}</dd>
                                @else
                                  <dd class="ml-2 text-gray-700">
                                    {{ FX::formatPrice($item->total_price) }} {{ $order->type === 'subscription' ? ' / ' . $order->invoicing_period : '' }}</dd>
                                @endif
                                
                            </div>
                        </dl>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
        @endif

        @do_action('view.order-received.items.end', $order)

        <div class="grid grid-cols-3 gap-x-8">
          @if(!$order->is_temp)
            <div class="col-span-3 md:col-span-1 py-4 md:py-6 space-y-0 space-x-3 md:space-x-0 md:space-y-3 border-b border-gray-200 md:border-none">
              
              <div class="flex flex-col space-y-3">
                {{-- @if(!empty($order->invoices->first()?->meta['test_stripe_hosted_invoice_url'] ?? null)) --}}
                @if($order->invoices->first())
                  <a href="{{ route('invoice.download', $order->invoices->first()->id) }}" target="_blank" class="btn-primary min-w-[130px] justify-center">
                      @if($order->invoices->first()->isForStandard())
                        {{ translate('Download invoice') }}
                      @else
                        {{ translate('Latest invoice') }}
                      @endif
                  </a>
                @endif
                {{-- @endif --}}

                @if($order_items?->first()?->subject?->isSubscribable() ?? false)
                  <a href="{{ route('stripe.portal_session') }}" target="_blank" class="btn-primary min-w-[130px] justify-center">
                    {{ translate('Billing portal') }}
                  </a>
                @endif
              </div>
            </div>

            <dl class="grid grid-cols-2 col-span-3 md:col-span-2 gap-x-6 text-sm py-6">
              @if($order->same_billing_shipping || !empty($order->shipping_address))
                <div>
                  @if($order->same_billing_shipping)
                    <dt class="font-medium text-gray-900">{{ translate('Billing address') }}</dt>
                    <dd class="mt-2 text-gray-700">
                      <address class="not-italic">
                        <span class="block">{{ $order->billing_first_name.' '.$order->billing_last_name }}</span>
                        <span class="block">{{ $order->billing_address }}</span>
                        <span class="block">{{ $order->billing_city }}, {{ $order->billing_zip }}</span>
                        <span class="block">{{ (!empty($order->billing_state) ? $order->billing_state.', ' : '').(\Countries::get(code: $order->billing_country)?->name ?? '') }}</span>
                      </address>
                    </dd>
                  @elseif(!empty($order->shipping_address))
                    <dt class="font-medium text-gray-900">{{ translate('Shipping address') }}</dt>
                    <dd class="mt-2 text-gray-700">
                      <address class="not-italic">
                        <span class="block">{{ $order->shipping_first_name.' '.$order->shipping_last_name }}</span>
                        <span class="block">{{ $order->shipping_address }}</span>
                        <span class="block">{{ $order->shipping_city }}, {{ $order->shipping_zip }}</span>
                        <span class="block">{{ (!empty($order->shipping_state) ? $order->shipping_state.', ' : '').(\Countries::get(code: $order->shipping_country)?->name ?? '') }}</span>
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
                    <span class="block">{{ (!empty($order->billing_state) ? $order->billing_state.', ' : '').(\Countries::get(code: $order->billing_country)?->name ?? '') }}</span>
                  </address>
                </dd>
              </div>
            </dl>
          @endif

          <dl class="space-y-6 border-t border-gray-200 text-sm pt-6 col-start-1 md:col-start-2 col-end-4">

            {{-- Non-subscription Orders --}}
            <div class="flex justify-between">
              <dt class="font-medium text-gray-900">{{ translate('Items') }}</dt>
              <dd class="text-gray-700">{{ \FX::formatPrice($order->base_price) }}</dd>
            </div>

            @if($order->discount_amount > 0)
              <div class="flex justify-between">
                <dt class="flex font-medium text-gray-900">
                  {{ translate('Discount') }}
                </dt>
                <dd class="text-gray-700">-{{ \FX::formatPrice($order->discount_amount) }}</dd>
              </div>
            @endif

            <div class="flex justify-between border-t border-gray-200 pt-6">
              <dt class="font-medium text-gray-900">{{ translate('Subtotal') }}</dt>
              <dd class="text-gray-700">{{ \FX::formatPrice($order->subtotal_price) }}</dd>
            </div>

            @if($order->tax_amount > 0)
              <div class="flex justify-between">
                <dt class="font-medium text-gray-900">{{ translate('Tax') }} {{ \TaxService::isTaxIncluded() ? translate('(included)') : '' }}</dt>
                <dd class="text-gray-700">{{  $order->tax_incl ? '('.\FX::formatPrice($order->tax_amount).')' : \FX::formatPrice($order->tax_amount) }}</dd>
              </div>
            @endif

            <div class="flex justify-between pt-3 mb-1 border-t border-gray-200">
              <dt class="font-semibold text-gray-900">{{ translate('Total') }}</dt>
              <dd class="font-semibold text-gray-900">{{ \FX::formatPrice($order->total_price) }}</dd>
            </div>

            @if($order->type === \App\Enums\OrderTypeEnum::installments()->value && $order->invoices->isNotEmpty())
              <div class="flex flex-col gap-y-2 pt-3 !mt-2 border-t border-gray-200 pl-5">
                @foreach($order->invoices as $index => $invoice)
                  <div class="flex justify-between ">
                    <dt class="font-semibold text-gray-900">- {{ sprintf(translate('Invoice (%d):'), $index+ 1) }}</dt>
                    <dd class="font-semibold text-gray-900">{{ \FX::formatPrice($invoice->total_price) }}</dd>
                  </div>
                @endforeach
              </div>
            @endif

          </dl>
        </div>

      </div>
    </div>
</section>
@endsection
