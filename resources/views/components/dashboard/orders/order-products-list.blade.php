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

                    <div class="flex flex-col mt-6 sm:mt-0 sm:ml-6">
                        <h3 class="text-base font-medium text-gray-900">
                            <a href="#">{{ $item->name }}</a>
                        </h3>

                        <p class="mt-3 text-sm text-gray-500">{{ $item->excerpt }}</p>

                        <dl class="flex text-sm divide-x divide-gray-200 space-x-4 sm:space-x-6 mt-5">
                            <div class="flex">
                                <dt class="font-semibold text-gray-900">{{ translate('Quantity') }}</dt>
                                <dd class="ml-2 text-gray-700">{{ $item->quantity }}</dd>
                            </div>
                            <div class="pl-4 flex sm:pl-6">
                                <dt class="font-semibold text-gray-900">{{ translate('Price') }}</dt>
                                <dd class="ml-2 text-gray-700">
                                    {{ FX::formatPrice($item->total_price) }} {{ $order->type !==
                                    'standard' ? ' / '.$order->invoicing_period : '' }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

                {{-- <div class="mt-6 lg:mt-0 lg:col-span-5">
                    <dl class="grid grid-cols-2 gap-x-6 text-sm">
                        <div>
                            <dt class="font-medium text-gray-900">Delivery address</dt>
                            <dd class="mt-3 text-gray-500">
                                <span class="block">Floyd Miles</span>
                                <span class="block">7363 Cynthia Pass</span>
                                <span class="block">Toronto, ON N3Y 4H8</span>
                            </dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-900">Shipping updates</dt>
                            <dd class="mt-3 text-gray-500 space-y-3">
                                <p>f•••@example.com</p>
                                <p>1•••••••••40</p>
                                <button type="button"
                                    class="font-medium text-indigo-600 hover:text-indigo-500">Edit</button>
                            </dd>
                        </div>
                    </dl>
                </div> --}}
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
  <!-- Billing -->
  <div class="mt-16">
    <div
        class="bg-gray-100 py-6 px-4 sm:px-6 sm:rounded-lg lg:px-8 lg:py-8 lg:grid lg:grid-cols-12 lg:gap-x-8">
        <dl class="grid grid-cols-2 gap-6 text-sm sm:grid-cols-2 md:gap-x-8 lg:col-span-7">
            <div>
                <dt class="font-medium text-gray-900">{{ translate('Billing address') }}</dt>
                {{-- @if($order->isPaid()) --}}
                <dd class="mt-3 text-gray-500">
                    <span class="block">{{ $order->billing_first_name.' '.$order->billing_last_name
                        }}</span>
                    <span class="block">{{ $order->billing_address }}</span>
                    <span class="block">{{ $order->billing_city }}, {{ $order->billing_zip }}</span>
                    <span class="block">{{ (!empty($order->billing_state) ? $order->billing_state.', ' :
                        '') .
                        (\Countries::get(code: $order->billing_country)?->name ?? '') }}</span>
                </dd>
                {{-- @else
                <dd class="mt-3 text-gray-500">
                    <span class="block">
                        {{ translate('Order is processing, this can take a few minutes.') }}
                    </span>
                </dd>
                @endif --}}
            </div>
            <div>
                @if((auth()->user()?->isAdmin() ?? false) &&
                !empty($order->meta['stripe_payment_intent_id'] ??
                null))
                <dt class="font-medium text-gray-900">{{ translate('Payment information') }}</dt>
                @endif
                <div class="mt-3">
                    <dd class="-ml-4 -mt-4 flex flex-wrap">
                        {{-- <div class="ml-4 mt-4 flex-shrink-0">
                            <svg aria-hidden="true" width="36" height="24" viewBox="0 0 36 24"
                                xmlns="http://www.w3.org/2000/svg" class="h-6 w-auto">
                                <rect width="36" height="24" rx="4" fill="#224DBA" />
                                <path
                                    d="M10.925 15.673H8.874l-1.538-6c-.073-.276-.228-.52-.456-.635A6.575 6.575 0 005 8.403v-.231h3.304c.456 0 .798.347.855.75l.798 4.328 2.05-5.078h1.994l-3.076 7.5zm4.216 0h-1.937L14.8 8.172h1.937l-1.595 7.5zm4.101-5.422c.057-.404.399-.635.798-.635a3.54 3.54 0 011.88.346l.342-1.615A4.808 4.808 0 0020.496 8c-1.88 0-3.248 1.039-3.248 2.481 0 1.097.969 1.673 1.653 2.02.74.346 1.025.577.968.923 0 .519-.57.75-1.139.75a4.795 4.795 0 01-1.994-.462l-.342 1.616a5.48 5.48 0 002.108.404c2.108.057 3.418-.981 3.418-2.539 0-1.962-2.678-2.077-2.678-2.942zm9.457 5.422L27.16 8.172h-1.652a.858.858 0 00-.798.577l-2.848 6.924h1.994l.398-1.096h2.45l.228 1.096h1.766zm-2.905-5.482l.57 2.827h-1.596l1.026-2.827z"
                                    fill="#fff" />
                            </svg>
                            <p class="sr-only">Visa</p>
                        </div>
                        <div class="ml-4 mt-4 mb-3">
                            <p class="text-gray-900">Ending with ****</p>
                            <p class="text-gray-600">Expires ** / **</p>
                        </div> --}}
                        @if((auth()->user()?->isAdmin() ?? false) &&
                        !empty($order->meta['stripe_payment_intent_id'] ?? null))
                        @if(\StripeService::getStripeMode() === 'live')
                        <a target="_blank" class="btn btn-primary"
                            href="https://dashboard.stripe.com/live/payments/{{ $order->meta['stripe_payment_intent_id'] ?? null }}">
                            {{ translate('View transaction details on Stripe') }}
                        </a>
                        @else
                        <a target="_blank" class="btn btn-primary"
                            href="https://dashboard.stripe.com/test/payments/{{ $order->meta['stripe_payment_intent_id'] ?? null }}">
                            {{ translate('View transaction details on Stripe') }}
                        </a>
                        @endif
                        @endif
                    </dd>
                </div>
            </div>
        </dl>

        <dl class="mt-8 divide-y divide-gray-200 text-sm lg:mt-0 lg:col-span-5">
            <div class="pb-4 flex items-center justify-between">
                <dt class="text-gray-600">{{ translate('Subtotal') }}</dt>
                <dd class="font-medium text-gray-900">{{ \FX::formatPrice($order->subtotal_price) }}
                </dd>
            </div>
            <div class="py-4 flex items-center justify-between">
                <dt class="text-gray-600">{{ translate('Shipping') }}</dt>
                <dd class="font-medium text-gray-900">{{ \FX::formatPrice($order->shipping_cost) }}</dd>
            </div>
            <div class="py-4 flex items-center justify-between">
                <dt class="text-gray-600">{{ translate('Tax') }} ({{ $order->tax }}%)</dt>
                <dd class="font-medium text-gray-900">{{ \FX::formatPrice(($order->subtotal_price +
                    (float) $order->shipping_cost) * $order->tax / 100) }}</dd>
            </div>
            <div class="pt-4 flex items-center justify-between">
                <dt class="font-medium text-gray-900">{{ translate('Order total') }}</dt>
                <dd class="font-medium text-indigo-600">{{ \FX::formatPrice($order->total_price) }}</dd>
            </div>
        </dl>
    </div>
</div>