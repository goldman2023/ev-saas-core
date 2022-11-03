<div class="bg-white border border-gray-200 rounded-lg">
    <div class="px-3 py-3 border-b border-gray-200">
        <div class="flex justify-between items-center flex-wrap sm:flex-nowrap">
            <div class="w-full">
                <h4 class="font-semibold">{{ translate('Export invoices') }}</h4>
            </div>
        </div>
    </div>
    <div class="px-3 py-3 sm:px-3">
        <li class="flow-root">
            <div class="grid grid-cols-2">
                <label for="small" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">
                    {{ translate('Year') }}
                </label>
                <select id="small"
                    class="block p-2 mb-6 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option selected>{{ translate('Choose a year') }}</option>
                    <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                    <option value="2021">2021</option>
                </select>

                <label for="small" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">
                    {{ translate('Month') }}
                </label>
                <select id="small"
                    class="block p-2 mb-6 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option selected>{{ translate('Month') }}</option>
                    <option value="US">January</option>
                    <option value="CA">February</option>
                    <option value="FR">April</option>
                    <option value="DE">May</option>
                </select>
            </div>

            <a href="{{ route('my.plans.management') }}"
                class="relative -m-2 p-2 flex items-center space-x-4 rounded-xl hover:bg-gray-50">
                <div class="flex-shrink-0 flex items-center justify-center h-16 w-16 rounded-lg bg-primary">
                    @svg('heroicon-o-view-list', ['class' => 'h-6 w-6 text-white'])
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-900">
                        <span>{{ translate('Download Invoice File') }}</span>
                    </h3>
                    <p class="mt-1 text-sm text-gray-500 line-clamp-2">
                        {{ translate('.csv format') }}</p>
                </div>
            </a>
        </li>
    </div>
</div>
