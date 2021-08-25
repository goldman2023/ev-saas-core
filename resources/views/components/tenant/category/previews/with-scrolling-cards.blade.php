<!-- This example requires Tailwind CSS v2.0+ -->
<div class="bg-white">
    <div class="py-16 sm:py-24 xl:max-w-7xl xl:mx-auto xl:px-8">
        <div class="px-4 sm:px-6 sm:flex sm:items-center sm:justify-between lg:px-8 xl:px-0">
            <h2 class="text-2xl font-extrabold tracking-tight text-gray-900">
                <x-ev.label>
                    {{ translate('Shop by Category') }}
                </x-ev.label>
            </h2>
            <a href="{{ route('categories.all') }}"
                class="hidden text-sm font-semibold text-indigo-600 hover:text-indigo-500 sm:block">
                <x-ev.label>
                    {{ translate('Browse all categories') }}
                    <span aria-hidden="true"> &rarr;</span>
                </x-ev.label>

            </a>

        </div>

        <div class="mt-4 flow-root">
            <div class="-my-2">
                <div class="box-content py-2 relative overflow-x-auto xl:overflow-visible">
                    <div
                        class="absolute min-w-screen-xl px-4 flex space-x-8 sm:px-6 lg:px-8 xl:relative xl:px-0 xl:space-x-0 xl:grid xl:grid-cols-5 xl:gap-x-8">

                        @foreach ($categories as $key => $category)
                            <a href="{{ route('products.category', $category->slug) }}"
                                class="relative w-56 h-80 rounded-lg p-6 flex flex-col overflow-hidden hover:opacity-75 xl:w-auto mb-3">
                                <span aria-hidden="true" class="absolute inset-0">
                                    <img src="https://tailwindui.com/img/ecommerce-images/home-page-01-category-01.jpg"
                                        alt="" class="w-full h-full object-center object-cover">
                                </span>
                                <span aria-hidden="true"
                                    class="absolute inset-x-0 bottom-0 h-2/3 bg-gradient-to-t from-gray-800 opacity-50"></span>
                                <span
                                    class="relative mt-auto text-center text-xl font-bold text-white">{{ $category->name }}</span>
                            </a>

                        @endforeach

                        <x-tenant.category.empty-state>
                        </x-tenant.category.empty-state>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 px-4 sm:hidden">
            <a href="{{ route('categories.all') }}"
                class="block text-sm font-semibold text-indigo-600 hover:text-indigo-500">
                {{ translate('Browse all categories') }}
                <span aria-hidden="true"> &rarr;</span></a>
        </div>
    </div>
</div>
