@extends('frontend.layouts.' . $globalLayout)

@php
  $first_item = $order->order_items->first()->subject;
  $is_bookable_product = $first_item instanceof \App\Models\Product && $first_item->isBookableService();
@endphp

@section('meta_title'){{ translate('Your order is received').' - '.\TenantSettings::get('site_name').' | '.\TenantSettings::get('site_motto') }}@stop

@section('meta_keywords'){{ translate('order, thank you page, checkout, cart, purchase, ecommerce') }}@stop

@push('head_scripts')
  @if($is_bookable_product)
  <link href="https://calendly.com/assets/external/widget.css" rel="stylesheet">
  <script src="https://calendly.com/assets/external/widget.js" type="text/javascript"></script>
  @endif
@endpush

@section('content')

<section class="bg-white">

    <div class="max-w-3xl mx-auto px-4 py-8 sm:px-6 sm:py-16 lg:px-8">
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

          @if(!empty($ghost_user))
              {{-- User is a guest/ghost user --}}
              <x-system.alert type="warning" text="{!! translate('Please finalize your registration.').'<br>'.translate('Email').': '.$ghost_user->email !!}" :only-text="true" />
          @else
              {{-- User is already registered --}}
              <a href="{{ route('my.plans.management') }}" class="btn-primary">
                {{ translate('Manage subscriptions') }}
              </a>
          @endif
        @elseif($first_item->type === \App\Enums\ProductTypeEnum::bookable_service()->value)
          <p class="mt-2 text-4xl font-extrabold tracking-tight sm:text-5xl">{{ translate('Please review your order') }}</p>
          <p class="mt-2 text-base text-gray-500 mb-4">{{ str_replace('%d%', $order->id, 'Your order #%d% has been processed. Please select the available booking time.') }}</p>

          <div class="w-full mb-4">
            @if(!empty($ghost_user))
              <x-system.alert type="warning" text="{!! translate('Please finalize your registration before scheduling a meeting.').'<br>'.translate('Email').': '.$ghost_user->email !!}" :only-text="true" />
            @else
              @if($is_bookable_product)
                <button type="button" class="btn-primary" @click="Calendly.showPopupWidget('{{ $first_item->getBookingLink() }}');">
                  {{ translate('Schedule a meeting') }}
                </button>
              @endif
            @endif
          </div>
        @elseif($first_item->type === \App\Enums\ProductTypeEnum::standard()->value)
          <p class="mb-2 text-4xl font-extrabold tracking-tight sm:text-5xl">{{ translate('We are processing the order!') }}</p>
          <p class="mb-2 text-base text-gray-500">{{ str_replace('%d%', $order->id, 'Your order #%d% has been received and will be processed asap.') }}</p>

          <div class="badge-info py-2 mb-2 text-18">{{ translate('processing') }}</div>

          {{-- TODO: Make this dynamic --}}
          <p class="text-base text-gray-500">{{ translate('Orders usually ship withing 2 days and you will receive tracking number and order tracking details.') }}</p>

        @elseif($first_item->type === \App\Enums\ProductTypeEnum::course()->value)
          <p class="mb-2 text-4xl font-extrabold tracking-tight sm:text-5xl">{{ translate('Successfully bought a course!') }}</p>
          <p class="mb-2 text-base text-gray-500">{{ str_replace('%d%', $order->id, 'Your order #%d% has been processed. You successfully bought a course.') }}</p>

          <div class="w-full mb-4">
            @if(!empty($ghost_user))
              <x-system.alert type="warning" text="{!! translate('Before accessing the course, please go to your email and finalize your registration.').' <br /> '.translate('Email').': '.$ghost_user->email !!}" :only-text="true" />
            @else
              <a href="{{ route(\App\Models\CourseItem::getRouteName(), [
                  'product_slug' => $first_item->slug,
                  'slug' => $first_item->course_items->first()?->slug ?? ' ',
              ]) }}" class="btn-success">
                  {{ translate('View course') }}
              </a>
            @endif
          </div>
        @endif


        {{-- <dl class="mt-12 text-sm font-medium">
          <dt class="text-gray-900">Tracking number</dt>
          <dd class="text-indigo-600 mt-2">51547878755545848512</dd>
        </dl> --}}
      </div>

      <div class="border-t border-gray-200">

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
                                <dt class="font-semibold text-gray-900">{{ translate('Total price') }}</dt>
                                <dd class="ml-2 text-gray-700">{{ FX::formatPrice($item->total_price) }}</dd>
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
                <a href="{{ $order->invoices->first()?->meta['test_stripe_hosted_invoice_url'] ?? '#' }}" target="_blank" class="btn-primary min-w-[130px] justify-center">
                  {{ translate('Latest invoice') }}
                </a>
              @endif

              @if($order->order_items?->first()?->subject?->isSubscribable() ?? false)
                <a href="{{ route('stripe.portal_session') }}" target="_blank" class="btn-primary min-w-[130px] justify-center">
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
            @if(!empty($subscription = $order->user_subscription))
                @php
                  $tax_sum = 0;
                  $items_sum = 0;
                @endphp
                <div class="w-full flex flex-col">
                  <div class="w-full flex justify-between mb-2">
                      <strong class="text-16 font-semibold">{{ translate('Subscription') }}</strong>
                  </div>
                  @foreach($subscription->order->order_items as $order_item)
                      <div class="w-full flex justify-between mb-1">
                          <span class="text-14 text-gray-600 font-normal">
                              {{ $order_item->subject->name }}: {{ $order_item->quantity.' '.translate('user') }} x {{ \FX::formatPrice($order_item->total_price) }} / {{ translate('user') }} / {{ $order->invoicing_period }}
                          </span>

                          <span class="text-14 text-gray-600 font-normal">{{ \FX::formatPrice($order_item->quantity * $order_item->total_price) }} / {{ $order->invoicing_period }}</span>
                      </div>

                      @php
                        $items_sum += $order_item->total_price;
                        if($subscription->getTaxAmount(false) > 0) {
                          $tax_sum += $subscription->getTaxAmount(format: false);
                        }
                      @endphp
                  @endforeach
                </div>


              <div class="w-full flex flex-col mt-3 pt-3 border-t border-gray-200">
                  @if($tax_sum > 0)
                      <div class="w-full flex justify-between">
                          <span class="text-14 text-gray-500 font-normal">
                              {{ translate('VAT amount') }}:
                          </span>
                          <span class="text-14 text-gray-500 font-normal">
                              {{ $subscription->getTaxAmount(format: true) }} / {{ $order->invoicing_period }}
                          </span>
                      </div>
                  @endif

                  <div class="w-full flex justify-between items-center mt-3 pt-3 border-t border-gray-200">
                    <span class="text-14 text-gray-600 font-normal">
                        {{ translate('Next payment due on') }} 
                        <strong>
                          {{-- @dd($order->load(['invoices' => fn($query) => $query->withoutGlobalScopes()])->invoices) --}}
                          {{ \Carbon::createFromTimestamp($order->load(['invoices' => fn($query) => $query->withoutGlobalScopes()])->invoices->first()?->end_date)->format('d M, Y') }}
                        </strong>
                    </span>

                    <span class="text-14 text-gray-600 font-normal">
                        {{ translate('Total') }}: <strong>{{ $subscription->getTotalPrice(format: true) }} / {{ $order->invoicing_period }}</strong>
                    </span>
                  </div>
              </div>
            @else
              {{-- Non-subscription Orders --}}
              <div class="flex justify-between">
                <dt class="font-medium text-gray-900">{{ translate('Subtotal') }}</dt>
                <dd class="text-gray-700">{{ \FX::formatPrice($order->base_price) }}</dd>
              </div>
              @if($order->discount_amount > 0)
                <div class="flex justify-between">
                  <dt class="flex font-medium text-gray-900">
                    {{ translate('Discount') }}
                    {{-- <span class="rounded-full bg-gray-200 text-xs text-gray-600 py-0.5 px-2 ml-2">STUDENT50</span> --}}
                  </dt>
                  <dd class="text-gray-700">-{{ \FX::formatPrice($order->discount_amount) }}</dd>
                </div>
              @endif

              @if($first_item->isShippable())
                <div class="flex justify-between">
                  <dt class="font-medium text-gray-900">{{ translate('Shipping') }}</dt>
                  <dd class="text-gray-700">{{  \FX::formatPrice(0) }}</dd>
                </div>
              @endif
              
              <div class="flex justify-between pt-3 mb-1 border-t border-gray-200">
                <dt class="font-semibold text-gray-900">{{ translate('Total') }}</dt>
                <dd class="font-semibold text-gray-900">{{ \FX::formatPrice($order->total_price) }}</dd>
              </div>
            @endif
            
          </dl>
        </div>

      </div>
    </div>
</section>
@endsection