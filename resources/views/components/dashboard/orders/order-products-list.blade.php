<!-- Products -->
<div class="w-full">
    <div class="space-y-8">
        @if($order_items->isNotEmpty())
        @foreach($order_items as $item)
        <div class="bg-white border-t border-b border-gray-200 shadow-sm sm:border sm:rounded-lg">
            <div class="py-6 px-4 sm:px-6 lg:grid lg:grid-cols-12 lg:gap-x-8 lg:p-8">
                <div class="sm:flex lg:col-span-12">
                    <div
                        class="flex-shrink-0 w-full aspect-w-1 aspect-h-1 rounded-lg overflow-hidden sm:aspect-none sm:w-40 border border-gray-200 shadow">
                        @if(!empty($item?->subject))
                            <img src="{{ $item->subject->getThumbnail(['w' => 600]) }}" alt=""
                                class="w-full h-full object-center object-cover sm:w-full sm:h-full">
                        @endif
                    </div>

                    <div class="flex flex-col mt-6 sm:mt-0 sm:ml-6 flex-grow">
                        <h3 class="flex item-center justify-between font-bold text-lg text-gray-900">
                            @empty($item->subject?->getPermalink() ?? null)
                                <span>{{ $item->name }}</span>
                            @else
                                <a href="{{ $item->subject->getPermalink() }}" target="_blank">
                                    {{ $item->name }}
                                </a>
                            @endempty

                            <span class="text-12">
                                {{ FX::formatPrice($item->total_price) }} {{ $order->type === 'subscription' ? ' / ' . $order->invoicing_period : '' }}</dd>
                            </span>
                        </h3>

                        <p class="mt-1 text-sm text-gray-500">
                            {{ translate('Serial number: ')}}

                            {!! sprintf("%06d", $item->order->id) !!}
                        </p>

                        @if($item->descendants->isNotEmpty())
                            <ul class="w-full flex flex-col gap-y-2 mt-2">
                                @foreach($item->descendants as $addon_item)
                                    <li class="w-full flex items-center justify-between border border-gray-200 rounded px-2 py-1">
                                        <div class="flex items-center ">
                                          <span class="pr-2">+</span>
                                          <strong class="text-12 line-clamp-1 pr-2">{{ $addon_item->name }}</strong>
                                          <span class="text-12 line-clamp-1">{{ translate('Quantity') }}: {{ $addon_item->quantity }}</span>
                                        </div>

                                        <strong class="text-12 text-gray-900">{{ \FX::formatPrice($addon_item->total_price) }}</strong>
                                    </li>
                                @endforeach
                            </ul>
                          @endif
                        {{-- <p class="mt-3 text-sm text-gray-500">{!! $item->excerpt !!}</p> --}}

                        <dl class="flex text-sm space-x-4 sm:space-x-6 mt-5">
                            <div class="pr-4 flex sm:pr-6">
                                <dt class="font-semibold text-gray-900 mr-1">{{ translate('Price') }} </dt>

                                @if($item->descendants->isNotEmpty())
                                  @php
                                    $addons_total_sum = $item->descendants->reduce(function ($carry, $addon) {
                                        return $carry + $addon->total_price;
                                    });
                                    $addons_count = $item->descendants->reduce(function ($carry, $addon) {
                                        return $carry + $addon->quantity;
                                    });
                                  @endphp
                                  <dd class="ml-2 text-gray-700">
                                    {{ FX::formatPrice($item->total_price + $addons_total_sum) }} {{ $order->type === 'subscription' ? ' / ' . $order->invoicing_period : '' }}</dd>
                                @else
                                  <dd class="ml-2 text-gray-700">
                                    {{ FX::formatPrice($item->total_price) }} {{ $order->type === 'subscription' ? ' / ' . $order->invoicing_period : '' }}</dd>
                                @endif
                            </div>

                            <div class="flex">
                                <dt class="font-semibold text-gray-900">{{ translate('Quantity') }}</dt>
                                @if($item->descendants->isNotEmpty())
                                    <dd class="ml-2 text-gray-700">{{ $item->quantity + $addons_count }}</dd>
                                @else
                                    <dd class="ml-2 text-gray-700">{{ $item->quantity }}</dd>
                                @endif
                            </div>
                        </dl>


                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @endif

        {{-- TODO: for digital products skip shipping --}}
        {{-- <div class="border-t border-gray-200 py-6 px-4 sm:px-6 lg:p-8">
            @php
            $progress_i = 0;

            if($order->payment_status === \App\Enums\PaymentStatusEnum::paid()->value) {
            $progress_i += 1;
            }

            if($order->shipping_status === \App\Enums\ShippingStatusEnum::sent()->value) {
            $progress_i += 3;
            }
            if($order->shipping_status === \App\Enums\ShippingStatusEnum::delivered()->value) {
            $progress_i += 5;
            }
            @endphp
            <p class="text-sm font-medium text-gray-900">{{ translate('Order timeline') }}</p>
            <div class="mt-6" aria-hidden="true">
                <div class="bg-gray-200 rounded-full overflow-hidden">
                    <div class="h-2 bg-primary rounded-full"
                        style="width: calc((1 * 2 + {{ $progress_i }}) / 8 * 100%)"></div>
                </div>
                <div class="hidden sm:grid grid-cols-4 text-sm font-medium text-gray-600 mt-6">
                    <div class="text-primary">{{ translate('Order placed') }}</div>
                    <div class="text-center text-primary">{{ translate('Processing') }}</div>
                    <div class="text-center {{ ($progress_i == 3) ? 'text-primary' : '' }}">{{
                        translate('Shipped') }}</div>
                    <div class="text-right {{ ($progress_i == 5) ? 'text-primary' : '' }}">{{
                        translate('Delivered') }}</div>
                </div>
            </div>
        </div> --}}

    </div>
</div>
