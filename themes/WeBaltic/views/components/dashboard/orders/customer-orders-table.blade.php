<div class="w-full">
    @foreach($user->orders as $order)
      <div class="border-t border-b border-gray-200 bg-white shadow-sm sm:rounded-lg sm:border mb-5">
        {{-- <h3 class="sr-only">{{ translate('Order placed on') }} <time datetime="2021-07-06">{{ $order->created_at->format('d M, Y H:i') }}</time></h3> --}}

        <div class="flex items-center flex-wrap gap-y-2 border-b border-gray-200 p-4 sm:grid sm:grid-cols-6 sm:gap-x-6 sm:p-6">
          <dl class="grid flex-1 grid-cols-5 gap-x-6 text-sm sm:col-span-5 sm:grid-cols-5 lg:col-span-5">
            <div>
              <dt class="font-medium text-gray-900">{{ translate('Order ID') }}</dt>
              <dd class="mt-1 text-gray-500">#{{ $order->id }}</dd>
            </div>
            <div class="hidden sm:block">
              <dt class="font-medium text-gray-900">{{ translate('Date placed') }}</dt>
              <dd class="mt-1 text-gray-500">
                <time datetime="{{ $order->created_at->format('Y-m-d') }}">{{ $order->created_at->format('d M, Y') }}</time>
              </dd>
            </div>
            <div>
              <dt class="font-medium text-gray-900">{{ translate('Total (with tax)') }}</dt>
              <dd class="mt-1 font-medium text-gray-900">{{ \FX::formatPrice($order->total_price) }}</dd>
            </div>
            <div>
              <dt class="font-medium text-gray-900">{{ translate('Status') }}</dt>
              <dd class="mt-1 font-medium {{ get_order_cycle_status_color($order->getWEF('cycle_status')) }}">
                {{ \WeThemes\WeBaltic\App\Enums\OrderCycleStatusEnum::getPublicStatusesLabels()[$order->getWEF('cycle_status')] ?? \WeThemes\WeBaltic\App\Enums\OrderCycleStatusEnum::labels()[2] }}
              </dd>
            </div>
            <div>
              <dt class="font-medium text-gray-900">{{ translate('Payment status') }}</dt>
              <dd class="mt-1 font-medium text-gray-900">
                {{-- Make label function... --}}
                @if($order->payment_status === \App\Enums\PaymentStatusEnum::paid()->value)
                  <span class="badge-success">
                      {{ ucfirst($order->payment_status) }}
                  </span>
                @elseif($order->payment_status === \App\Enums\PaymentStatusEnum::pending()->value)
                  <span class="badge-info">
                      {{ ucfirst($order->payment_status) }}
                  </span>
                @elseif($order->payment_status === \App\Enums\PaymentStatusEnum::unpaid()->value)
                  <span class="badge-danger">
                      {{ ucfirst($order->payment_status) }}
                  </span>
                @elseif($order->payment_status === \App\Enums\PaymentStatusEnum::canceled()->value)
                  <span class="badge-warning">
                      {{ ucfirst($order->payment_status) }}
                  </span>
                @endif
              </dd>
            </div>
          </dl>

          <div class="lg:col-span-1 lg:flex lg:items-center lg:justify-end lg:space-x-4">
            <a href="{{ route('order.details', $order->id) }}" class="flex items-center justify-center rounded-md border border-gray-300 bg-white py-2 px-2.5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
              @svg('heroicon-o-document-text', ['class' => 'w-5 h-5 mr-1'])
              <span>{{ translate('Details') }}</span>
            </a>
          </div>
        </div>

        <!-- Products -->
        <ul role="list" class="divide-y divide-gray-200">
          @foreach($order->order_items as $item)
            <li class="p-4 sm:p-6">
              <div class="flex items-center sm:items-start">
                @if(!empty($item?->subject))
                  <div class="w-[160px] h-[100px] flex-shrink-0 overflow-hidden rounded-lg bg-gray-200 sm:w-[160px] sm:h-[100px]">
                    <img src="{{ $item->subject->getThumbnail(['w' => 600]) }}" alt="{{ $item->name }}" class="h-full w-full object-cover object-center">
                  </div>
                @endif
                
                <div class="ml-6 flex-1 text-sm">
                  <div class="font-medium text-gray-900 sm:flex sm:justify-between">
                    <h5>{{ $item->name }}</h5>
                    <p class="mt-2 sm:mt-0">{{ \FX::formatPrice($item->total_price) }}</p>
                  </div>
                  @if(!empty($item->excerpt))
                    <p class="hidden text-gray-500 sm:mt-2 sm:block">
                      {{ $item->excerpt }}
                    </p>
                  @endif
                </div>
              </div>

              <div class="relative mt-4">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                  <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center">
                  <div class="inline-flex items-center rounded-full border border-gray-300 bg-white px-4 py-1.5 text-sm font-medium leading-5 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <span>{{ translate('Invoices') }}</span>
                  </div>
                </div>
              </div>

              <livewire:dashboard.tables.recent-invoices-widget-table :order="$order"
                        :show-per-page="false" :show-search="false" :column-select="false" :filters-enabled="false" :show-pagination="false" />

              {{-- <div class="mt-6 sm:flex sm:justify-between">
                <div class="flex items-center">
                  <!-- Heroicon name: mini/check-circle -->
                  <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                  </svg>
                  <p class="ml-2 text-sm font-medium text-gray-500">Delivered on <time datetime="2021-07-12">July 12, 2021</time></p>
                </div>

                <div class="mt-6 flex items-center space-x-4 divide-x divide-gray-200 border-t border-gray-200 pt-4 text-sm font-medium sm:mt-0 sm:ml-4 sm:border-none sm:pt-0">
                  <div class="flex flex-1 justify-center">
                    <a href="#" class="whitespace-nowrap text-indigo-600 hover:text-indigo-500">View product</a>
                  </div>
                  <div class="flex flex-1 justify-center pl-4">
                    <a href="#" class="whitespace-nowrap text-indigo-600 hover:text-indigo-500">Buy again</a>
                  </div>
                </div>
              </div> --}}
            </li>
          @endforeach
        </ul>
      </div>
    @endforeach
  </div>
