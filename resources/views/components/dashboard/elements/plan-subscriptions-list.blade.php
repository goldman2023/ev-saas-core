<div class="bg-white border border-gray-200 rounded-lg {{ $class }}">
    <div class="px-4 py-5 border-b border-gray-200 sm:px-6 ">
        <div class="flex justify-between items-center flex-wrap sm:flex-nowrap">
            <div class="w-full">
              <h4 class="font-semibold">{{ translate('Subscriptions') }}</h4>
            </div>
        </div>
    </div>
    <div class="px-4 py-5 sm:px-6">
        @if($plan_subscriptions->isNotEmpty())
            <div class="w-full space-x-3">
                @foreach($plan_subscriptions as $subscription)
                    <div class="w-full flex flex-col">
                        <div class="w-full flex justify-between mb-2">
                            <strong class="text-16 font-semibold">{{ translate('Subscription') }}</strong>
                        </div>
                        
                        {{-- Order Items --}}
                        @foreach($subscription->order->order_items as $order_item)
                            <div class="w-full flex justify-between mb-1">
                                <span class="text-14 text-gray-600 font-normal">
                                    <strong>{{ $order_item->subject->name }}</strong>: {{ $order_item->quantity.' '.translate('user') }} x {{ \FX::formatPrice($order_item->total_price) }} / {{ translate('user') }} / {{ $subscription->order->invoicing_period }}
                                </span>

                                <span class="text-14 text-gray-600 font-normal">{{ \FX::formatPrice($order_item->total_price * $order_item->quantity) }} / {{ $subscription->order->invoicing_period }}</span>
                            </div>
                        @endforeach

                        {{-- Discount --}}
                        @if($subscription->getDiscountAmount(false) > 0)
                            <div class="w-full flex justify-between mt-3 pt-3 border-t border-gray-200">
                                <span class="text-14 text-gray-500 font-normal">
                                    {{ translate('Discount') }}: <strong></strong>
                                </span>
                                <span class="text-14 text-gray-500 font-normal">
                                    -{{ $subscription->getDiscountAmount() }} 
                                    @if($subscription->getDiscountDuration() === 'forever')
                                        / {{ $subscription->order->invoicing_period }}
                                    @endif
                                </span>
                            </div>
                        @endif

                        {{-- VAT --}}
                        @if($subscription->getTaxAmount(false) > 0)
                            <div class="w-full flex justify-between mt-3 pt-3 border-t border-gray-200">
                                <span class="text-14 text-gray-500 font-normal">
                                    {{ translate('VAT amount') }}: <strong></strong>
                                </span>
                                <span class="text-14 text-gray-500 font-normal">
                                    {{ $subscription->getTaxAmount() }} / {{ $subscription->order->invoicing_period }}
                                </span>
                            </div>
                        @endif

                        <div class="w-full flex justify-between items-center mt-3 pt-3 border-t border-gray-200">
                            <span class="text-14 text-gray-600 font-normal">
                                {{ translate('Next payment due on') }} <strong>{{ \Carbon::createFromTimestamp($subscription->order->load(['invoices' => fn($query) => $query->withoutGlobalScopes()])->invoices->first()?->end_date)->format('d M, Y') }}</strong>
                            </span>

                            <span class="text-14 text-gray-600 font-normal">
                                {{ translate('Total') }}: <strong>{{ $subscription->getTotalUpcomingPrice(format: true) }} / {{ $subscription->order->invoicing_period }}</strong>
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
            <a href="{{ route('my.plans.management') }}" class="w-full btn-primary mt-5 text-center justify-center">
                {{ translate('Manage Subscriptions') }}
            </a>
        @else
            <li class="flow-root">
                <a href="{{ route('my.plans.management') }}" class="relative -m-2 p-2 flex items-center space-x-4 rounded-xl hover:bg-gray-50">
                    <div class="flex-shrink-0 flex items-center justify-center h-16 w-16 rounded-lg bg-primary">
                        @svg('heroicon-o-list-bullet', ['class' => 'h-6 w-6 text-white'])
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-900">
                            <span>{{ translate('Subscribe to a plan') }}</span>
                        </h3>
                        <p class="mt-1 text-sm text-gray-500 line-clamp-2">{{ translate('Unlock various possibilities by subscribing to a plan of your choice!') }}</p>
                    </div>
                </a>
            </li>
        @endif
    </div>
</div>
