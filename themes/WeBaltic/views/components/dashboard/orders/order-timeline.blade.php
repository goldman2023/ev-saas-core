<nav aria-label="Progress">
    <ol role="list" class="overflow-hidden">

      @foreach($steps as $key => $label)
        @if($key < $order_cycle_status)
          <!-- Completed Step -->
          <li class="relative pb-6">
            <div class="absolute top-4 left-4 -ml-px mt-0.5 h-full w-0.5 bg-indigo-600" aria-hidden="true"></div>
            <!-- Complete Step -->
            <div class="group relative flex items-center">
              <span class="flex h-9 items-center">
                <span class="relative  flex h-8 w-8 items-center justify-center rounded-full bg-indigo-600">
                  @svg('heroicon-s-check', ['class' => 'h-5 w-5 text-white'])
                </span>
              </span>
              <span class="ml-4 flex min-w-0 flex-col">
                <span class="text-sm font-medium">{{ $label }}</span>
                {{-- <span class="text-sm text-gray-500">Signed.</span> --}}
              </span>
            </div>
          </li>
        @elseif($key == $order_cycle_status)
          <!-- Current Step -->
          <li class="relative pb-6">
            <div class="absolute top-4 left-4 -ml-px mt-0.5 h-full w-0.5 bg-gray-300" aria-hidden="true"></div>
            <!-- Current Step -->
            <div class="group relative flex items-center" aria-current="step">
              <span class="flex h-9 items-center" aria-hidden="true">
                <span class="relative  flex h-8 w-8 items-center justify-center rounded-full border-2 border-indigo-600 bg-white">
                  <span class="h-2.5 w-2.5 rounded-full bg-indigo-600"></span>
                </span>
              </span>
              <span class="ml-4 flex min-w-0 flex-col">
                <span class="text-sm font-medium text-indigo-600">{{ $label }}</span>
                {{-- <span class="text-sm text-gray-500">Pending.</span> --}}
              </span>
            </div>
          </li>
        @else
          <!-- Upcoming Step -->
          <li class="relative @if($key !== count($steps) - 1) pb-6 @endif">
            {{-- <div class="absolute top-4 left-4 -ml-px mt-0.5 h-full w-0.5 bg-gray-300" aria-hidden="true"></div> --}}
            <!-- Upcoming Step -->
            <div class="group relative flex items-center">
              <span class="flex h-9 items-center" aria-hidden="true">
                <span class="relative  flex h-8 w-8 items-center justify-center rounded-full border-2 border-gray-300 bg-white group-hover:border-gray-400">
                  <span class="h-2.5 w-2.5 rounded-full bg-transparent group-hover:bg-gray-300"></span>
                </span>
              </span>
              <span class="ml-4 flex min-w-0 flex-col">
                <span class="text-sm font-medium text-indigo-600">{{ $label }}</span>
                {{-- <span class="text-sm text-gray-500">Due date not set</span> --}}
              </span>
            </div>
          </li>
        @endif
      @endforeach

      {{-- <li class="relative pb-6">
        <div class="absolute top-4 left-4 -ml-px mt-0.5 h-full w-0.5 bg-gray-300" aria-hidden="true"></div>
        <!-- Upcoming Step -->
        <a href="#" class="group relative flex items-start">
          <span class="flex h-9 items-center" aria-hidden="true">
            <span class="relative z-10 flex h-8 w-8 items-center justify-center rounded-full border-2 border-gray-300 bg-white group-hover:border-gray-400">
              <span class="h-2.5 w-2.5 rounded-full bg-transparent group-hover:bg-gray-300"></span>
            </span>
          </span>
          <span class="ml-4 flex min-w-0 flex-col">
            <span class="text-sm font-medium text-gray-500">Welding QA</span>
            <span class="text-sm text-gray-500">Not checked.</span>
          </span>
        </a>
      </li>

      <li class="relative pb-6">
        <!-- Upcoming Step -->
        <a href="#" class="group relative flex items-start">
          <span class="flex h-9 items-center" aria-hidden="true">
            <span class="relative z-10 flex h-8 w-8 items-center justify-center rounded-full border-2 border-gray-300 bg-white group-hover:border-gray-400">
              <span class="h-2.5 w-2.5 rounded-full bg-transparent group-hover:bg-gray-300"></span>
            </span>
          </span>
          <span class="ml-4 flex min-w-0 flex-col">
            <span class="text-sm font-medium text-gray-500">Zincification</span>
            <span class="text-sm text-gray-500">Due date not set.</span>
            <span class="text-sm text-gray-500">Generate Bill of landing</span>
          </span>
        </a>
      </li>

       <li class="relative pb-6">
        <!-- Upcoming Step -->
        <a href="#" class="group relative flex items-start">
          <span class="flex h-9 items-center" aria-hidden="true">
            <span class="relative z-10 flex h-8 w-8 items-center justify-center rounded-full border-2 border-gray-300 bg-white group-hover:border-gray-400">
              <span class="h-2.5 w-2.5 rounded-full bg-transparent group-hover:bg-gray-300"></span>
            </span>
          </span>
          <span class="ml-4 flex min-w-0 flex-col">
            <span class="text-sm font-medium text-gray-500">Delivery to warehouse</span>
            <span class="text-sm text-gray-500">Not delivered.</span>
            <span class="text-sm text-gray-500">Notification to customer not sent</span>
          </span>
        </a>
      </li>

      <li class="relative pb-6">
        <!-- Upcoming Step -->
        <a href="#" class="group relative flex items-start">
          <span class="flex h-9 items-center" aria-hidden="true">
            <span class="relative z-10 flex h-8 w-8 items-center justify-center rounded-full border-2 border-gray-300 bg-white group-hover:border-gray-400">
              <span class="h-2.5 w-2.5 rounded-full bg-transparent group-hover:bg-gray-300"></span>
            </span>
          </span>
          <span class="ml-4 flex min-w-0 flex-col">
            <span class="text-sm font-medium text-gray-500">Assembly</span>
            <span class="text-sm text-gray-500">Not started.</span>
            <span class="text-sm text-gray-500">Generate manufacturing PDF</span>
          </span>
        </a>
      </li>

      <li class="relative pb-6">
        <!-- Upcoming Step -->
        <a href="#" class="group relative flex items-start">
          <span class="flex h-9 items-center" aria-hidden="true">
            <span class="relative z-10 flex h-8 w-8 items-center justify-center rounded-full border-2 border-gray-300 bg-white group-hover:border-gray-400">
              <span class="h-2.5 w-2.5 rounded-full bg-transparent group-hover:bg-gray-300"></span>
            </span>
          </span>
          <span class="ml-4 flex min-w-0 flex-col">
            <span class="text-sm font-medium text-gray-500">Final QA</span>
            <span class="text-sm text-gray-500">Not checked</span>
            <span class="text-sm text-gray-500">Notification to customer not sent</span>
          </span>
        </a>
      </li>

      <li class="relative pb-6">
        <!-- Upcoming Step -->
        <a href="#" class="group relative flex items-start">
          <span class="flex h-9 items-center" aria-hidden="true">
            <span class="relative z-10 flex h-8 w-8 items-center justify-center rounded-full border-2 border-gray-300 bg-white group-hover:border-gray-400">
              <span class="h-2.5 w-2.5 rounded-full bg-transparent group-hover:bg-gray-300"></span>
            </span>
          </span>
          <span class="ml-4 flex min-w-0 flex-col">
            <span class="text-sm font-medium text-gray-500">Final Invoice</span>
            <span class="text-sm text-gray-500">Generate Invoice (Send to client)</span>
            <span class="text-sm text-gray-500">Vin Code not Generated</span>
          </span>
        </a>
      </li>

      <li class="relative pb-6">
        <!-- Upcoming Step -->
        <a href="#" class="group relative flex items-start">
          <span class="flex h-9 items-center" aria-hidden="true">
            <span class="relative z-10 flex h-8 w-8 items-center justify-center rounded-full border-2 border-gray-300 bg-white group-hover:border-gray-400">
              <span class="h-2.5 w-2.5 rounded-full bg-transparent group-hover:bg-gray-300"></span>
            </span>
          </span>
          <span class="ml-4 flex min-w-0 flex-col">
            <span class="text-sm font-medium text-gray-500">Certificate Generation</span>
            <span class="text-sm text-gray-500">Generate Certificate (Send to client)</span>
          </span>
        </a>
      </li>

      <li class="relative pb-6">
        <!-- Upcoming Step -->
        <a href="#" class="group relative flex items-start">
          <span class="flex h-9 items-center" aria-hidden="true">
            <span class="relative z-10 flex h-8 w-8 items-center justify-center rounded-full border-2 border-gray-300 bg-white group-hover:border-gray-400">
              <span class="h-2.5 w-2.5 rounded-full bg-transparent group-hover:bg-gray-300"></span>
            </span>
          </span>
          <span class="ml-4 flex min-w-0 flex-col">
            <span class="text-sm font-medium text-gray-500">Order Completed</span>
            <span class="text-sm text-gray-500">Notify customer</span>
          </span>
        </a>
      </li>

      <li class="relative">
        <!-- Upcoming Step -->
        <a href="#" class="group relative flex items-start">
          <span class="flex h-9 items-center" aria-hidden="true">
            <span class="relative z-10 flex h-8 w-8 items-center justify-center rounded-full border-2 border-gray-300 bg-white group-hover:border-gray-400">
              <span class="h-2.5 w-2.5 rounded-full bg-transparent group-hover:bg-gray-300"></span>
            </span>
          </span>
          <span class="ml-4 flex min-w-0 flex-col">
            <span class="text-sm font-medium text-gray-500">Customer Review</span>
            <span class="text-sm text-gray-500">Not submited</span>
          </span>
        </a>
      </li> --}}
    </ol>
    <div class="w-full mt-6">
        <a href="{{ route('order.change-status', $order->id) }}" class="btn-primary w-full !px-10 text-center !py-3">

            <span>
                {{ translate('Next status') }}
            </span>

            @svg('heroicon-o-arrow-right', ['class' => 'h-4 h-4 ml-3'])

        </a>
    </div>
  </nav>
