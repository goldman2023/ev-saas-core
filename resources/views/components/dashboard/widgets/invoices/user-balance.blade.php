@if($user_balance != 0)
<div class="relative bg-white pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden">
    <dt>
      <div class="absolute bg-indigo-500 rounded-md p-3">
        @svg('heroicon-o-currency-euro', ['class' => 'h-6 w-6 text-white'])
      </div>
      <p class="ml-16 text-sm font-medium text-gray-500 truncate">
        {{ translate('Balance') }}
      </p>
    </dt>
    <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
      <p class="text-2xl font-semibold text-gray-900">
        {{ FX::formatPrice($user_balance) }}
        {{-- {{ $user_subscription->getTotalPrice() }} --}}
        <span class="text-16">

        </span>
      </p>
      <p class="ml-2 flex items-baseline text-sm font-semibold text-red-600">

      </p>
      <div class="absolute bottom-0 inset-x-0 bg-gray-50 px-4 py-4 sm:px-6">
        <div class="text-sm text-gray-500">
            {{ translate('Your next payment will be covered by your existing balance') }}
        </div>
      </div>
    </dd>
  </div>
@endif
