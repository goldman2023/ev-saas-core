<!-- This example requires Tailwind CSS v2.0+ -->
<div class="we-horizontal-slider-wrapper w-full">
    <div class="we-horizontal-slider grid grid-cols-3 gap-6">
        <div class="relative bg-white pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden">
            <dt>
                <div class="absolute bg-indigo-500 rounded-md p-3">
                    <!-- Heroicon name: outline/users -->
                    @svg('heroicon-s-users', ['class' => 'h-6 w-6 text-white'])
                </div>
                <p class="ml-16 text-sm font-medium text-gray-500 truncate">{{ translate('Total users') }}</p>
            </dt>
            <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
                <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\User::count() }}</p>
                <p class="ml-2 flex items-baseline text-sm font-semibold text-green-600">
                    <!-- Heroicon name: solid/arrow-sm-up -->
                    @svg('heroicon-o-arrow-up', ['class' => 'h-6 w-6 text-white'])

                    <span class="sr-only"> Increased by </span>
                    {{ App\Models\User::ByDays(1)->count();
                    }} {{ translate('Today') }}
                </p>
                <div class="absolute bottom-0 inset-x-0 bg-gray-50 px-4 py-4 sm:px-6">
                    <div class="text-sm">
                        <a href="{{ route('crm.all_customers') }}"
                            class="font-medium text-indigo-600 hover:text-indigo-500">

                            {{ translate('View all') }}

                            <span class="sr-only">
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
                    @svg('heroicon-s-envelope-open', ['class' => 'h-6 w-6 text-white'])

                </div>
                <p class="ml-16 text-sm font-medium text-gray-500 truncate">
                    {{ translate('Orders') }}
                </p>
            </dt>
            <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
                <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\Order::count() }}</p>
                <p class="ml-2 flex items-baseline text-sm font-semibold text-green-600">
                    <!-- Heroicon name: solid/arrow-sm-up -->
                    @svg('heroicon-o-arrow-up', ['class' => 'h-6 w-6 text-white'])

                    <span class="sr-only"> Increased by </span>
                    {{ App\Models\Order::ByDays(1)->count() }} {{ translate('New') }}
                </p>
                <div class="absolute bottom-0 inset-x-0 bg-gray-50 px-4 py-4 sm:px-6">
                    <div class="text-sm">
                        <a href="{{ route('orders.index') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                            {{ translate('View all') }}
                            <span class="sr-only"> Avg. Open Rate stats</span></a>
                    </div>
                </div>
            </dd>
        </div>

        <!-- This example requires Tailwind CSS v2.0+ -->
        <a href="{{ route('product.create') }}" type="button"
            class="bg-white relative block w-full border-2 border-gray-300 border-dashed rounded-lg p-12 text-center hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" stroke="currentColor"
                fill="none" viewBox="0 0 48 48" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 14v20c0 4.418 7.163 8 16 8 1.381 0 2.721-.087 4-.252M8 14c0 4.418 7.163 8 16 8s16-3.582 16-8M8 14c0-4.418 7.163-8 16-8s16 3.582 16 8m0 0v14m0-4c0 4.418-7.163 8-16 8S8 28.418 8 24m32 10v6m0 0v6m0-6h6m-6 0h-6" />
            </svg>
            <span class="mt-2 block text-sm font-medium text-gray-900">
                {{ translate('Add new product') }}
            </span>
        </a>

    </div>




</div>
