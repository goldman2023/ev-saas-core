<div id="banner" tabindex="-1" class="grid py-3 px-4 w-full bg-gray-50 border border-b border-gray-200 border-b-danger dark:border-gray-700 sm:grid-cols-3 dark:bg-gray-800">
    <div class="pr-6 mb-3 sm:col-span-2 sm:mb-0 sm:pr-0">
        <p class="mb-1 font-bold text-gray-900 dark:text-white">
            <span>{{ translate('You last subscription payment') }}</span>
            <span class="text-danger">{{ translate('failed') }}</span>
        </p>
        <p class="text-sm font-light text-gray-500 dark:text-gray-400">{{ translate('To extend or buy new subscription plan, please go to billing platform') }}</p>
    </div>
    <div class="flex justify-start sm:justify-end">
        <div class="flex items-center sm:space-x-4">
            <a href="{{ \StripeService::createPortalSession() }}" class="btn-primary" target="_blank">
                @svg('heroicon-s-pencil', ['class' => 'mr-2 -ml-1 w-4 h-4'])
                {{ translate('Billing Platform') }}
            </a>
            <button data-collapse-toggle="banner" type="button" class="absolute lg:static top-1 right-1 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
            </button>
        </div>
    </div>
</div>