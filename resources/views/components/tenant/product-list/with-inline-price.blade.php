<div class="bg-white">
    <div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
        <div class="px-4 sm:px-6 sm:flex sm:items-center sm:justify-between lg:px-8 xl:px-0">
            <h2 class="text-2xl font-extrabold tracking-tight text-gray-900">
                <x-ev.label :label="ev_dynamic_translate('Customers also purchased', true)">
                </x-ev.label>
            </h2>

            <a href="{{ route('products.index') }}"
                class="hidden text-sm font-semibold text-indigo-600 hover:text-indigo-500 sm:block">
                {{ translate('See all Products') }}
                <span aria-hidden="true"> &rarr;</span></a>
        </div>

        <div class="mt-6 grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
            @foreach ($products as $product)

                <div class="group relative">
                    <div
                        class="w-full min-h-80 bg-gray-200 aspect-w-1 aspect-h-1 rounded-md overflow-hidden group-hover:opacity-75 lg:h-80 lg:aspect-none">

                        <x-tenant.system.image alt="{{ $product->getTranslation('name') }}"
                            class="w-full h-full object-center object-cover lg:w-full lg:h-full"
                            :image="$product->thumbnail_img"></x-tenant.system.image>

                    </div>
                    <div class="mt-4 flex justify-between">
                        <div>
                            <h3 class="text-sm text-gray-700">
                                <a href="{{ route('product', $product->slug) }}">
                                    <span aria-hidden="true" class="absolute inset-0"></span>
                                    {{ $product->getTranslation('name') }}
                                </a>
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">Black</p>
                        </div>
                        <p class="text-sm font-medium text-gray-900">
                            @if (home_base_price($product->id) != home_discounted_base_price($product->id))
                                <del class="fw-600 opacity-50 mr-1">{{ home_base_price($product->id) }}</del>
                            @endif
                            <span class="fw-700 text-primary">{{ home_discounted_base_price($product->id) }}</span>
                        </p>
                    </div>
                </div>
            @endforeach

            {{-- TODO: Empty state shown only for tenant owner --}}
            <!-- This example requires Tailwind CSS v2.0+ -->
            <button type="button"
                class="relative block w-full border-2 border-gray-300 border-dashed rounded-lg p-12 text-center hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" stroke="currentColor"
                    fill="none" viewBox="0 0 48 48" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 14v20c0 4.418 7.163 8 16 8 1.381 0 2.721-.087 4-.252M8 14c0 4.418 7.163 8 16 8s16-3.582 16-8M8 14c0-4.418 7.163-8 16-8s16 3.582 16 8m0 0v14m0-4c0 4.418-7.163 8-16 8S8 28.418 8 24m32 10v6m0 0v6m0-6h6m-6 0h-6" />
                </svg>
                <span class="mt-2 block text-sm font-medium text-gray-900">
                    {{ translate('Add New Product') }}
                </span>
            </button>

            <!-- More products... -->
        </div>
    </div>
</div>
