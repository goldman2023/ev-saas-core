<div class="dynamic-stats">
    <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('Plan details') }}</h3>

    <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
      <div class="relative bg-white pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden">
        <dt>
          <div class="absolute bg-indigo-500 rounded-md p-3">
            @svg('heroicon-o-users', ['class' => 'h-6 w-6 text-white'])
          </div>
          <p class="ml-16 text-sm font-medium text-gray-500 truncate">{{ translate('Current Plan') }}</p>
        </dt>
        <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
          @if($user_subscription->hasSingleItem())
            <p class="text-2xl font-semibold text-gray-900">{{ $user_subscription->items->first()?->name ?? '' }}</p>
            <p class="ml-2 flex items-baseline text-sm font-semibold text-green-600">
              1 {{ translate('Seats') }}
            </p>
          @elseif($user_subscription->hasSingleItemMultipleQty())
            <p class="text-2xl font-semibold text-gray-900">{{ $user_subscription->items->first()?->name ?? '' }}</p>
            <p class="ml-2 flex items-baseline text-sm font-semibold text-green-600">
              {{ $user_subscription->items->first()->pivot->qty }} {{ translate('Seats') }}
            </p>
          @elseif($user_subscription->hasMultipleItems())
            <p class="text-2xl font-semibold text-gray-900">{{ translate('Custom') }}</p>
            <p class="ml-2 flex items-baseline text-sm font-semibold text-green-600">
              {{ $user_subscription->licenses->count() }} {{ translate('Seats') }}
            </p>
          @endif

          <div class="absolute bottom-0 inset-x-0 bg-gray-50 px-4 py-4 sm:px-6">
            <div class="text-sm">
              <a href="{{ route('my.plans.management') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                {{ translate('Manage Subscription') }}
              </a>
            </div>
          </div>
        </dd>
      </div>

      <div class="relative bg-white pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden">
        <dt>
          <div class="absolute bg-indigo-500 rounded-md p-3">
            @svg('heroicon-o-mail-open', ['class' => 'h-6 w-6 text-white'])
          </div>
          <p class="ml-16 text-sm font-medium text-gray-500 truncate">{{ translate('Billing period') }}</p>
        </dt>
        <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
          <p class="text-2xl font-semibold text-gray-900">
            @if(($order?->invoicing_period ?? null) === 'year')
              {{ translate('Yearly') }}
            @elseif(($order?->invoicing_period ?? null) === 'month')
              {{ translate('Monthly') }}
            @elseif(($order?->invoicing_period ?? null) === 'week')
              {{ translate('Weekly') }}
            @else
              ?
            @endif
          </p>
          @if(($order?->type ?? null) === 'subscription' && !empty($invoices?->first()?->end_date ?? null))
            <p class="ml-2 flex items-baseline text-sm font-semibold text-green-600">
              {{ translate('Invoice in').' '.(\Carbon::createFromTimestamp($invoices?->first()?->end_date)?->diffInDays() ?? '?').' '.translate('days') }}
            </p>
          @endif
          <div class="absolute bottom-0 inset-x-0 bg-gray-50 px-4 py-4 sm:px-6">
            <div class="text-sm">
              <a href="{{ route('my.orders.all') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                {{ translate('Manage invoices') }}
              </a>
            </div>
          </div>
        </dd>
      </div>

      <div class="relative bg-white pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden">
        <dt>
          <div class="absolute bg-indigo-500 rounded-md p-3">
            @svg('heroicon-o-currency-euro', ['class' => 'h-6 w-6 text-white'])
          </div>
          <p class="flex items-center ml-16 text-sm font-medium text-gray-500 truncate">
            {{ translate('Cost') }}
            @if($user_subscription->getDiscountAmount(false) > 0)
              <span class="badge-success text-12 ml-2">
                {{ translate('Discounted') }}
              </span>
            @endif
          </p>
        </dt>
        <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
          <p class="text-2xl font-semibold text-gray-900">
            {{-- <del class="text-14 mr-2">{{ $user_subscription->getTotalPrice(no_discount: true) }}</del> --}}
            {{ $user_subscription->getTotalPrice() }} / 
            <span class="text-16">
            @if(($order?->invoicing_period ?? null) === 'year')
              {{ translate('Yearly') }}
            @elseif(($order?->invoicing_period ?? null) === 'month')
              {{ translate('Monthly') }}
            @elseif(($order?->invoicing_period ?? null) === 'week')
              {{ translate('Weekly') }}
            @else
              ?
            @endif
            </span>
          </p>
          <p class="ml-2 flex items-baseline text-sm font-semibold text-red-600">

          </p>
          <div class="absolute bottom-0 inset-x-0 bg-gray-50 px-4 py-4 sm:px-6">
            <div class="text-sm">
              <a href="{{ route('my.plans.management') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                {{ translate('Modify plan') }}
              </a>
            </div>
          </div>
        </dd>
      </div>
    </dl>
  </div>
