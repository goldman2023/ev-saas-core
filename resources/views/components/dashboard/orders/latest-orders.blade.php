
<div class="p-4 mb-6 w-full max-w-md bg-white rounded-lg border shadow-md sm:p-8 dark:bg-gray-800 dark:border-gray-700">
    <div class="flex justify-between items-center mb-4">
        <h5 class="text-lg font-medium leading-none text-gray-900 dark:text-white">
           {{ translate('Latest') }}
        </h5>
        <a href="{{ route('crm.all_customers') }}" class="text-sm font-medium text-blue-600 hover:underline dark:text-blue-500">
            {{ translate('View latest orders') }}
            {{-- TODO: Add a count of unseen orders for this user --}}
        </a>
   </div>
   <div class="flow-root">
        <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
            @foreach($orders as $order)
            @if(empty($order->user))
            @continue;
            @endif
            <li class="py-3 sm:py-4">
                <a href="{{ $order->getPermalink() }}">

                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <img class="w-8 h-8 rounded-full" src="{{ $order->user->getThumbnail() }}" alt="{{ $order->user->name }}">
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                           {{ translate('Order') }} #{{ $order->id }}
                           <span class="text-xs font-normal">{{ $order->updated_at->diffForHumans() }}</span>
                        </p>
                        <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                            {{ $order->user->email }}
                        </p>
                    </div>
                    <div class="items-center text-base font-semibold text-gray-900 dark:text-white">
                        {{ FX::formatPrice($order->total_price) }}
                        <div  class="text-right text-xs font-normal text-gray-500 truncate dark:text-gray-400">
                        <p>
                           {{ translate('QTY:') }}  {{ $order->order_items()->count() }}
                        </p>
                        </div>
                    </div>
                </div>
            </a>
            </li>
            @endforeach

        </ul>
   </div>
</div>
