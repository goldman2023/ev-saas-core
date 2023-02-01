@extends('frontend.layouts.' . $globalLayout)

@php
  $first_item = $order->order_items->first()->subject;
@endphp

@section('meta_title'){{ translate('Your quote was received').' - '.\TenantSettings::get('site_name').' | '.\TenantSettings::get('site_motto') }}@stop

@section('meta_keywords'){{ translate('request a quote, thank you page, checkout, cart, quote, ecommerce') }}@stop

@push('head_scripts')

@endpush

@section('content')

<section class="bg-white">

    <div class="max-w-3xl mx-auto px-4 py-8 sm:px-6 sm:py-16 lg:px-8">
      <div class="w-full mb-3">
        @if($first_item->type === \App\Enums\ProductTypeEnum::standard()->value)
          <p class="mb-2 text-4xl font-extrabold tracking-tight sm:text-5xl">{{ translate('We are reviewing your request for quotation!') }}</p>
          <p class="mb-2 text-base text-gray-500">{{ str_replace('%d%', $order->id, 'Your request for quote #%d% has been received and will be processed soon.') }}</p>

          <div class="badge-info py-2 mb-2 text-18">{{ translate('In review') }}</div>

          {{-- <p class="text-base text-gray-500">{{ translate('Orders usually ship withing 2 days and you will receive tracking number and order tracking details.') }}</p> --}}
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
                <div class="py-3 border-b border-gray-200 flex space-x-6">
                  @if(!empty($item->subject))
                    <img src="{{ $item->subject->getThumbnail(['w' => 180]) }}" alt=""
                      class="flex-none w-[80px] h-[80px] object-center object-contain bg-gray-100 rounded-lg sm:w-[80px] sm:h-[80px]">
                  @else
                    <div class="flex-none w-[80px] h-[80px] object-center object-contain bg-gray-100 rounded-lg sm:w-[80px] sm:h-[80px] bg-img-placeholder-stripes"></div>
                  @endif
                  <div class="flex-auto flex flex-col">
                    <div>
                        <h4 class="font-semibold text-gray-900">
                            <span>{{ $item->name }}</span>
                        </h4>
                        <p class="mt-2 text-sm text-gray-600 line-clamp-1">
                            {!! $item->excerpt !!}
                        </p>
                    </div>
                    <div class="mt-2 flex-1 flex items-end">
                        <dl class="flex text-sm divide-x divide-gray-200 space-x-4 sm:space-x-6">
                            <div class="@if($order->type === 'standard') flex @endif">
                                <dt class="font-semibold text-gray-900">{{ translate('Quantity') }}:</dt>
                                <dd class="ml-2 text-gray-700">{{ $item->quantity }}</dd>
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
                    <span class="block">{{ (!empty($order->billing_state) ? $order->billing_state.', ' : '') }}</span>
                  </address>
                </dd>
              </div>
            </dl>
          @endif
        </div>

      </div>
    </div>
</section>
@endsection
