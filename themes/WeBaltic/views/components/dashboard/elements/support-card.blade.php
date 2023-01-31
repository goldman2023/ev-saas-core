
<div class="w-full border border-gray-200 bg-white shadow-sm sm:rounded-lg p-4 {{ $class }}">
    <div class="flex flex-col items-center pb-2">
        <img class="w-24 h-24 mb-3 rounded-full shadow-lg" src="{{ get_site_logo() }}" alt="{{ get_site_name() }}"/>
        <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">
            {{ translate('Customer Support') }}
        </h5>
        <span class="text-sm text-gray-500 dark:text-gray-400">
            {{ translate('Need help? Reach out to us!') }}
        </span>
        <div class="flex mt-4 space-x-3 md:mt-6">
            <a href="/contacts" class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                {{ translate('Contact Us') }}
            </a>
            <a href="#" class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-700 dark:focus:ring-gray-700">
               {{ translate('Send Us a message') }}
            </a>
        </div>
    </div>
</div>