<div>
    <h3 class="text-lg font-medium text-gray-900">Upcoming payment</h3>
    <div class="bg-white shadow overflow-hidden sm:rounded-md mt-2">
        @if(tenant()->upcomingInvoice())
        @php
        $invoice = tenant()->upcomingInvoice();
        @endphp
        <div class="hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition duration-150 ease-in-out">
            <div class="px-4 py-4 sm:px-6">
                <div class="flex items-center justify-between">
                    <div class="text-sm leading-5 font-medium text-indigo-600 truncate">
                        {{ tenant()->plan_name }}
                    </div>
                    <div class="flex flex-shrink-0">
                        <div class="ml-2 flex-shrink-0 flex items-center">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                {{ ucfirst(tenant()->defaultPaymentMethod()->asStripePaymentMethod()->card->brand) }}
                            </span>
                            <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                **{{ tenant()->defaultPaymentMethod()->asStripePaymentMethod()->card->last4 }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="mt-2 sm:flex sm:justify-between">
                    <div class="sm:flex">
                        <div class="mr-6 flex items-center text-sm leading-5 text-gray-500">
                            <svg class="flex-shrink-0 h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                            <div class="ml-1">
                                {{ $invoice->total() }}
                            </div>
                        </div>
                    </div>
                    <div class="mt-2 flex items-center text-sm leading-5 text-gray-500 sm:mt-0">
                        <svg class="flex-shrink-0 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                        </svg>
                        <div class="ml-1">
                            Due on
                            <time datetime="{{ $invoice->date()->format('Y-m-d') }}">
                                {{ $invoice->date()->format('M d, Y') }}
                            </time>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <p class="p-4 text-sm text-gray-600">
            You're not subscribed yet. Please select a plan below.
        </p>
        @endif
    </div>
</div>