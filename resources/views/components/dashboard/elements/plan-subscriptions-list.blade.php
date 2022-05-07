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
                    <div class="w-full flex justify-between">
                        <strong class="text-16 font-semibold">{{ $subscription->plan->name }}</strong>
                        <span class="text-16 font-normal">{{ $subscription->order->invoicing_period === 'month' ?  $subscription->plan->getTotalPrice(true) :  $subscription->plan->getTotalAnnualPrice(true) }} / {{ $subscription->order->invoicing_period }}</span>
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
                        @svg('heroicon-o-view-list', ['class' => 'h-6 w-6 text-white'])
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
