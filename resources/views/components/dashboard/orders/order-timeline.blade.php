<!-- This example requires Tailwind CSS v2.0+ -->
<nav aria-label="Progress">
    <ol role="list" class="overflow-hidden">
      <li class="relative pb-10">
        <div class="absolute top-4 left-4 -ml-px mt-0.5 h-full w-0.5 bg-indigo-600" aria-hidden="true"></div>
        <!-- Complete Step -->
        <a href="#" class="group relative flex items-start">
          <span class="flex h-9 items-center">
            <span class="relative z-10 flex h-8 w-8 items-center justify-center rounded-full bg-indigo-600 group-hover:bg-indigo-800">
              <!-- Heroicon name: mini/check -->
              <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
              </svg>
            </span>
          </span>
          <span class="ml-4 flex min-w-0 flex-col">
            <span class="text-sm font-medium">Contract</span>
            <span class="text-sm text-gray-500">Signed.</span>
          </span>
        </a>
      </li>

      <li class="relative pb-10">
        <div class="absolute top-4 left-4 -ml-px mt-0.5 h-full w-0.5 bg-gray-300" aria-hidden="true"></div>
        <!-- Current Step -->
        <a href="#" class="group relative flex items-start" aria-current="step">
          <span class="flex h-9 items-center" aria-hidden="true">
            <span class="relative z-10 flex h-8 w-8 items-center justify-center rounded-full border-2 border-indigo-600 bg-white">
              <span class="h-2.5 w-2.5 rounded-full bg-indigo-600"></span>
            </span>
          </span>
          <span class="ml-4 flex min-w-0 flex-col">
            <span class="text-sm font-medium text-indigo-600">Manufacturing order approval</span>
            <span class="text-sm text-gray-500">Pending.</span>
          </span>
        </a>
      </li>

      <li class="relative pb-10">
        <div class="absolute top-4 left-4 -ml-px mt-0.5 h-full w-0.5 bg-gray-300" aria-hidden="true"></div>
        <!-- Upcoming Step -->
        <a href="#" class="group relative flex items-start">
          <span class="flex h-9 items-center" aria-hidden="true">
            <span class="relative z-10 flex h-8 w-8 items-center justify-center rounded-full border-2 border-gray-300 bg-white group-hover:border-gray-400">
              <span class="h-2.5 w-2.5 rounded-full bg-transparent group-hover:bg-gray-300"></span>
            </span>
          </span>
          <span class="ml-4 flex min-w-0 flex-col">
            <span class="text-sm font-medium text-gray-500">Welding</span>
            <span class="text-sm text-gray-500">Due date not set</span>
          </span>
        </a>
      </li>

      <li class="relative pb-10">
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

      <li class="relative">
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

       <li class="relative">
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

      <li class="relative">
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

      <li class="relative">
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

      <li class="relative">
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

      <li class="relative">
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

      <li class="relative">
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
      </li>
    </ol>
  </nav>
