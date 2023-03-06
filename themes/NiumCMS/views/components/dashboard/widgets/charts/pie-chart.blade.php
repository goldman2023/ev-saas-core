<div>

    <div class="border-b border-gray-200 dark:border-gray-700">
        <ul class="we-horizontal-slider bg-white flex lg:flex-wrap -mb-px text-md font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent"
            role="tablist">
            <li role="presentation">
                <button style="min-width: 200px;" class="min-w-[100px] inline-block border-r-1 p-4 border-t-2  text-left" id="engagement-stats-tab" data-tabs-target="#engagement-stats"
                    type="button" role="tab" aria-controls="engagement-stats" aria-selected="false">
                    {{ translate('Activity') }}

                    <span class="block text-xl">{{ $activityCount }}
                    <small class="text-sm">{{ translate('This Month') }}</small>
                    </span>
                </button>
            </li>


            <li role="presentation">
                <button
                style="min-width: 200px;"
                    class="text-left inline-block p-4 border-t-2 border-transparent border-r-1  hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                    id="oruserder-stats-tab" data-tabs-target="#user-stats" type="button" role="tab" aria-controls="order-stats"
                    aria-selected="false">
                    {{ translate('New Users') }}
                    <span class="block text-lg">
                        {{ $newUserCount }}
                        <small class="text-sm">{{ translate('This Month') }}</small>

                    </span>

                </button>
            </li>

        </ul>
    </div>
    <div id="myTabContent">

        <div class="hidden" id="engagement-stats" role="tabpanel"
            aria-labelledby="engagement-stats-tab">
            <div class="we-pie-chart-wrapper">
                <div class="h-[400px] bg-white p-4 pb-8">
                    <div class="text-lg font-medium">
                        {{ translate("Activity Statistics") }}
                    </div>
                    <livewire:livewire-line-chart :line-chart-model="$activityChartModel" />
                </div>

            </div>
        </div>

        <div class="hidden" id="user-stats" role="tabpanel"
            aria-labelledby="user-stats-tab">
            <div class="we-pie-chart-wrapper">
                <div class="h-[400px] bg-white p-4 pb-8">
                    <div class="text-lg font-medium">
                        {{ translate("New Users Acquisition") }}
                    </div>
                    <livewire:livewire-line-chart :line-chart-model="$userChartModel" />
                </div>

            </div>
        </div>

    </div>
    @livewireChartsScripts
</div>
