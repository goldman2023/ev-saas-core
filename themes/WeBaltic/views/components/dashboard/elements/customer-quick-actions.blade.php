<div class="w-full border border-gray-200 bg-white shadow-sm sm:rounded-lg p-4 {{ $class }}">
    <h2 class="text-lg font-medium text-gray-900">{{ translate('Quick actions') }}</h2>
    <p class="mt-1 text-sm text-gray-500">
        {{ translate('') }}
    </p>
    
    <ul role="list" class="mt-3 grid grid-cols-1 gap-6 border-t border-gray-200 pt-4 pb-2">
      <li class="flow-root">
        <div class="relative -m-2 flex items-center space-x-4 rounded-xl p-2  hover:bg-gray-50">
          <div class="flex-shrink-0 flex items-center justify-center h-16 w-16 rounded-lg bg-green-500">
            @svg('heroicon-o-shopping-cart', ['class' => 'h-6 w-6 text-white'])
          </div>
          <div>
            <h3 class="text-sm font-medium text-gray-900">
              <a href="{{ route('quote.create') }}" target="_blank" class="focus:outline-none">
                <span class="absolute inset-0" aria-hidden="true"></span>
                <span>{{ translate('Request a new quote') }}</span>
              </a>
            </h3>
            <p class="mt-1 text-sm text-gray-500">{{ translate('Request a new quote for desired items and specs') }}</p>
          </div>
        </div>
      </li>
  
      <li class="flow-root">
        <div class="relative -m-2 flex items-center space-x-4 rounded-xl p-2 hover:bg-gray-50">
          <div class="flex-shrink-0 flex items-center justify-center h-16 w-16 rounded-lg bg-sky-600">
            @svg('heroicon-o-phone', ['class' => 'h-6 w-6 text-white'])
          </div>
          <div>
            <h3 class="text-sm font-medium text-gray-900">
              <a href="tel:{{ get_tenant_setting('company_number') }}" class="focus:outline-none">
                <span class="absolute inset-0" aria-hidden="true"></span>
                <span>{{ translate('Contact support') }}</span>
              </a>
            </h3>
            <p class="mt-1 text-sm text-gray-500">{{ translate('Any questions? Feel free to contact our support team') }}</p>
          </div>
        </div>
      </li>
    </ul>
  </div>
  