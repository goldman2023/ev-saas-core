<div class="mt-8">
    @foreach($user->orders as $order)
      <div class="mx-auto mb-12">
        <div class="space-y-2 px-4 sm:flex sm:items-baseline sm:justify-between sm:space-y-0 sm:px-0">
          <div class="flex sm:items-baseline sm:space-x-4">
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">Order #{{ $order->id }}</h1>
            <a href="{{ route('order.details', $order->id) }}" class="hidden text-sm font-medium text-indigo-600 hover:text-indigo-500 sm:block">
              {{ translate('View details') }}
              <span aria-hidden="true"> &rarr;</span>
            </a>
          </div>
          <p class="text-sm text-gray-600">{{ translate('Order placed') }}
              <time datetime="2021-03-22" class="font-medium text-gray-900">
              {{ $order->created_at }}
          </time>
          </p>
          <a href="{{ route('order.details', $order->id) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 sm:hidden">
              {{ translate('View details') }}
            <span aria-hidden="true"> &rarr;</span>
          </a>
        </div>

        <!-- Products -->
        <div class="mt-6">
          <h2 class="sr-only">Products purchased</h2>

          <div class="space-y-8">
              @foreach($order->order_items as $item)
                <div class="border-t border-b border-gray-200 bg-white shadow-sm sm:rounded-lg sm:border">
                  <div class="py-6 px-4 sm:px-6 lg:grid lg:grid-cols-12 lg:gap-x-8 lg:p-8 !pb-0">
                    <div class="sm:flex lg:col-span-7">
                      <div class="aspect-w-1 aspect-h-1 w-full flex-shrink-0 overflow-hidden rounded-lg sm:aspect-none sm:h-40 sm:w-40">
                          @if(!empty($item?->subject))
                            <img src="{{ $item->subject->getThumbnail(['w' => 600]) }}" alt=" {{ $item->name }}"
                                class="h-auto w-full object-cover object-center sm:h-auto sm:w-full">
                          @endif
                      </div>

                      <div class="mt-6 sm:mt-0 sm:ml-6">
                        <h3 class="text-base font-medium text-gray-900">
                          <a href="#">
                              {{ $item->name }}
                          </a>
                        </h3>
                        <p class="mt-2 text-sm font-medium text-gray-900">
                          <strong class="text-14">{{ \FX::formatPrice($order->total_price) }}</strong>
                          {{-- $35.00 --}}
                      </p>

                      </div>
                    </div>

                    <div class="mt-6 lg:col-span-5 lg:mt-0">
                      <dl class="grid grid-cols-2 gap-x-6 text-sm">
                        <div class="">

                        </div>
                        <div>
                          <dt class="font-medium text-gray-900">Shipping updates</dt>
                          <dd class="mt-3 space-y-3 text-gray-500">
                            <p>f•••@example.com</p>
                            <p>1•••••••••40</p>
                            <button type="button" class="font-medium text-indigo-600 hover:text-indigo-500">Edit</button>
                          </dd>
                        </div>
                      </dl>
                    </div>
                  </div>

                  <div class="border-t border-gray-200 py-6 px-4 sm:px-6 lg:p-8">
                    <h4 class="sr-only">Status</h4>
                    <p class="text-sm font-medium text-gray-900">Preparing to ship on <time datetime="2021-03-24">March 24, 2021</time></p>
                    <div class="mt-6" aria-hidden="true">
                      <div class="overflow-hidden rounded-full bg-gray-200">
                        <div class="h-2 rounded-full bg-indigo-600" style="width: calc((1 * 2 + 1) / 8 * 100%)"></div>
                      </div>
                      <div class="mt-6 hidden grid-cols-4 text-sm font-medium text-gray-600 sm:grid">
                        <div class="text-indigo-600">Order placed</div>
                        <div class="text-center text-indigo-600">Processing</div>
                        <div class="text-center">Shipped</div>
                        <div class="text-right">Delivered</div>
                      </div>
                    </div>
                  </div>
                </div>
              @endforeach

          </div>
        </div>
      </div>
    @endforeach
  </div>
