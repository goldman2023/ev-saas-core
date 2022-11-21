<div class="bg-gray-100">
    <div class="py-16 sm:py-24 xl:mx-auto xl:max-w-7xl xl:px-8">
        <div class="px-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8 xl:px-0">
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">
               {{ translate('Product categories') }}
            </h2>
            <a href="{{ route('products.all') }}"
                class="hidden text-sm font-semibold text-indigo-600 hover:text-indigo-500 sm:block">
                {{ translate('Browse all categories') }}
                <span aria-hidden="true"> &rarr;</span>
            </a>
        </div>

        <div class="mt-4 flow-root">
            <div class="-my-2">
                <div class="relative box-content overflow-x-auto py-2 xl:overflow-visible">
                    <div
                        class="min-w-screen-xl flex  gap-8 px-4 sm:px-6 lg:px-8 xl:relative xl:grid xl:grid-cols-4 xl:gap-x-8 xl:space-x-0 xl:px-0">
                        @foreach ($categories as $category)

                        <a href="{{ $category->getPermalink() }}"
                            class="relative flex h-60 min-w-[190px] flex-col overflow-hidden rounded-lg p-6 hover:opacity-75 xl:w-auto">
                            <span aria-hidden="true" class="absolute inset-0">
                                <img src="{{ $category->getThumbnail() }}" alt=""
                                    class="h-full w-full object-cover object-center">
                            </span>
                            <span aria-hidden="true"
                                class="absolute inset-x-0 bottom-0 h-2/3 bg-gradient-to-t from-gray-800 opacity-50"></span>
                            <span class="relative mt-auto text-center text-xl font-bold text-white">
                                {{ $category->name }}
                            </span>
                        </a>
                        @endforeach



                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 px-4 sm:hidden">
            <a href="{{ route('products.all') }}"
                class="block text-sm font-semibold text-indigo-600 hover:text-indigo-500">
                {{ translate('Browse all categories') }}
                <span aria-hidden="true"> &rarr;</span>
            </a>
        </div>
    </div>
</div>
