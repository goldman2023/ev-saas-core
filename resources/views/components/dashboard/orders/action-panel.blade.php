<div class="bg-white border border-gray-200 rounded-lg">
    <div class="px-3 py-3 border-b border-gray-200">
        <div class="flex justify-between items-center flex-wrap sm:flex-nowrap">
            <div class="w-full">
                <h4 class="font-semibold">{{ translate('Manage orders') }}</h4>
            </div>
        </div>
    </div>
    <div class="px-3 py-3 sm:px-3">
        <li class="flow-root">
            <div class="grid grid-cols-3">
                <label for="small" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">
                    {{ translate('Action') }}
                </label>
                <select id="small"
                    class="block col-span-2 p-2 mb-6 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option selected>{{ translate('Select an action') }}</option>
                    <option value="action_1">
                        {{ translate('Generate printing lablel - Certificate') }}
                    </option>

                    <option value="action_1">
                        {{ translate('Export to PDF') }}
                    </option>

                    <option value="action_1">
                        {{ translate('Generate Delivery List') }}
                    </option>

                </select>


            </div>

            <a href="#"
                class="relative bg-gray-100 m-2 p-3 flex items-center space-x-4 rounded-xl hover:bg-gray-200">

                <div>
                    <h3 class="text-sm font-medium text-gray-900">
                        <span>{{ translate('Update Orders') }}</span>
                    </h3>
                    <p class="mt-1 text-sm text-gray-500 line-clamp-2">
                        2 Orders Will Be Updated
                    </p>
                </div>

                <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-lg bg-primary">
                    @svg('heroicon-o-arrow-right', ['class' => 'h-6 w-6 text-white'])
                </div>
            </a>
        </li>
    </div>
</div>
