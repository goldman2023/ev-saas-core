<div>

    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-md font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent"
            role="tablist">
            <li class="mr-2" role="presentation">
                <button style="min-width: 200px;" class="min-w-[100px] inline-block pl-0 p-4 border-b-2 rounded-t-lg text-left" id="engagement-stats-tab" data-tabs-target="#engagement-stats"
                    type="button" role="tab" aria-controls="engagement-stats" aria-selected="false">
                    {{ translate('Activity') }}

                    <span class="block text-xl">{{ $activityCount }}
                    <small class="text-sm">{{ translate('This Month') }}</small>
                    </span>
                </button>
            </li>
            <li class="mr-2" role="presentation">
                <button
                style="min-width: 200px;"
                    class="text-left inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                    id="order-stats-tab" data-tabs-target="#order-stats" type="button" role="tab" aria-controls="order-stats"
                    aria-selected="false">
                    {{ translate('Orders') }}
                    <span class="block text-lg">
                        {{ $ordersCount }}
                        <small class="text-sm">{{ translate('This Month') }}</small>

                    </span>

                </button>
            </li>

        </ul>
    </div>
    <div id="myTabContent">
        <div class="hidden " id="order-stats" role="tabpanel"
            aria-labelledby="order-stats-tab">
            <div class="we-pie-chart-wrapper">
                <div class="h-[400px] card">
                    <div class="text-xl font-medium">
                        {{ translate("Orders This Month") }}
                    </div>
                    <livewire:livewire-line-chart :line-chart-model="$lineChartModel" />
                </div>
            </div>
        </div>
        <div class="hidden" id="engagement-stats" role="tabpanel"
            aria-labelledby="engagement-stats-tab">
            <div class="we-pie-chart-wrapper">
                <div class="h-[400px] card">
                    <div class="text-xl font-medium">
                        {{ translate("Activity Statistics") }}
                    </div>
                    <livewire:livewire-line-chart :line-chart-model="$activityChartModel" />
                </div>

            </div>
        </div>

    </div>
    @livewireChartsScripts




</div>
