@extends('frontend.layouts.' . $globalLayout)

@section('meta_title'){{ translate('Your order is canceled!').' - '.\TenantSettings::get('site_name').' | '.\TenantSettings::get('site_motto') }}@stop

@section('meta_keywords'){{ translate('order, thank you page, checkout, cart, purchase, ecommerce') }}@stop

@section('meta')

@endsection

@section('content')
<section class="bg-white">
    <div class="max-w-3xl mx-auto px-4 py-16 sm:px-6 sm:py-24 lg:px-8">
      <div class="w-full">
        <h1 class="text-sm font-semibold uppercase tracking-wide text-indigo-600">{{ translate('Order abandoned!') }}</h1>
        <p class="mt-2 text-4xl font-extrabold tracking-tight sm:text-5xl">{{ translate('Sorry to see you abandon your order...') }}</p>
        <p class="mt-2 text-base text-gray-500">{{ str_replace('%d%', $order->id, 'Your order #%d% has been abandoned but you may still be able to continue if you revive your order by clicking here.') }}</p>

        {{-- <dl class="mt-12 text-sm font-medium">
          <dt class="text-gray-900">Tracking number</dt>
          <dd class="text-indigo-600 mt-2">51547878755545848512</dd>
        </dl> --}}
      </div>

      <div class="mt-10 border-t border-gray-200">
        <h2 class="sr-only">Your order</h2>

        <h3 class="sr-only">Items</h3>

        @if($order->order_items->isNotEmpty())
            @foreach($order->order_items as $item)
                <div class="py-10 border-b border-gray-200 flex space-x-6">
                    <img src="{{ $item->subject->getTHumbnail(['w' => 600]) }}" alt="" class="flex-none w-20 h-20 object-center object-contain bg-gray-100 rounded-lg sm:w-40 sm:h-40">
                    <div class="flex-auto flex flex-col">
                    <div>
                        <h4 class="font-semibold text-gray-900">
                            <span>{{ $item->name }}</span>
                        </h4>
                        <p class="mt-2 text-sm text-gray-600 line-clamp-3">
                            {!! $item->excerpt !!}
                        </p>
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
            @endforeach
        @endif

        <div class="sm:ml-40 sm:pl-6">
          <dl class="space-y-6 border-t border-gray-200 text-sm pt-10">
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
