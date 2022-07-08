<!-- This example requires Tailwind CSS v2.0+ -->
<div class="we-horizontal-slider-wrapper w-full">
    <div class="we-horizontal-slider grid grid-cols-3 gap-6">
        <div class="relative bg-white pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden">
            <dt>
                <div class="absolute bg-indigo-500 rounded-md p-3">
                    <!-- Heroicon name: outline/users -->
                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <p class="ml-16 text-sm font-medium text-gray-500 truncate">{{ translate('Followers') }}</p>
            </dt>
            <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
                <p class="text-2xl font-semibold text-gray-900">{{ auth()->user()->followers()->count() }}</p>
                <p class="ml-2 flex items-baseline text-sm font-semibold text-green-600">

                </p>
                <div class="absolute bottom-0 inset-x-0 bg-gray-50 px-4 py-4 sm:px-6">
                    <div class="text-sm">
                        <a href="{{ route('crm.all_customers') }}"
                            class="font-medium text-indigo-600 hover:text-indigo-500"> View all<span class="sr-only">
                                Total
                                Subscribers stats</span></a>
                    </div>
                </div>
            </dd>
        </div>

        <div class="relative bg-white pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden">
            <dt>
                <div class="absolute bg-indigo-500 rounded-md p-3">
                    <!-- Heroicon name: outline/mail-open -->
                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76" />
                    </svg>
                </div>
                <p class="ml-16 text-sm font-medium text-gray-500 truncate">
                    {{ translate('Shop Visits') }}
                </p>
            </dt>
            <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
                <p class="text-2xl font-semibold text-gray-900">{{ auth()->user()->public_view_count() }}</p>
                <p class="ml-2 flex items-baseline text-sm font-semibold text-green-600">
                    <!-- Heroicon name: solid/arrow-sm-up -->
                    <svg class="self-center flex-shrink-0 h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only"> Increased by </span>
                    {{ App\Models\Order::ByDays(1)->count() }} {{ translate('New') }}
                </p>
                <div class="absolute bottom-0 inset-x-0 bg-gray-50 px-4 py-4 sm:px-6">
                    <div class="text-sm">
                        <a href="{{ route('orders.index') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                            View all<span class="sr-only"> Avg. Open Rate stats</span></a>
                    </div>
                </div>
            </dd>
        </div>

        <div class="relative bg-white pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden">
            <dt>
                <div class="absolute bg-indigo-500 rounded-md p-3">
                    <!-- Heroicon name: outline/cursor-click -->
                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
                    </svg>
                </div>
                <p class="ml-16 text-sm font-medium text-gray-500 truncate">
                    {{ translate('Weekly engagements') }}
                </p>
            </dt>
            <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
                <p class="text-2xl font-semibold text-gray-900">

                </p>
                <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\Activity::where('subject_type', 'App\Models\User')->where('subject_id', auth()->user()->id)->count() }}</p>

                <p class="ml-2 flex items-baseline text-sm font-semibold text-green-600">
                    <!-- Heroicon name: solid/arrow-sm-down -->

                </p>
                <div class="absolute bottom-0 inset-x-0 bg-gray-50 px-4 py-4 sm:px-6">
                    <div class="text-sm">
                        <a href="{{ route('orders.index') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                            View all<span class="sr-only">
                                Avg. Click Rate stats</span></a>
                    </div>
                </div>
            </dd>
        </div>

        <div class="relative hidden bg-white p-3 shadow rounded-lg overflow-hidden">
            <button type="button"
                class="relative block w-full border-2 border-gray-300 border-dashed rounded-lg p-6 h-full text-center hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="mx-auto h-8 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" stroke="currentColor"
                    fill="none" viewBox="0 0 48 48" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 14v20c0 4.418 7.163 8 16 8 1.381 0 2.721-.087 4-.252M8 14c0 4.418 7.163 8 16 8s16-3.582 16-8M8 14c0-4.418 7.163-8 16-8s16 3.582 16 8m0 0v14m0-4c0 4.418-7.163 8-16 8S8 28.418 8 24m32 10v6m0 0v6m0-6h6m-6 0h-6" />
                </svg>
                <span class="mt-2 block text-sm font-medium text-gray-900"> {{ translate('Add your KPI') }} </span>
            </button>
        </div>
    </div>




</div>
