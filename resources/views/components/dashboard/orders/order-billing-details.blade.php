<!-- Billing -->
<div class="mt-16">
    <div class="bg-gray-100 py-6 px-4 sm:px-6 sm:rounded-lg lg:px-8 lg:py-8 lg:grid lg:grid-cols-12 lg:gap-x-8">
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
