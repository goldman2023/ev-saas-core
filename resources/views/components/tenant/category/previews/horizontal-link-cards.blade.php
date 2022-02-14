<!-- This example requires Tailwind CSS v2.0+ -->
<div class="py-16 sm:py-24 xl:max-w-7xl xl:mx-auto xl:px-8">
    <div class="px-4 sm:px-6 sm:flex sm:items-center sm:justify-between lg:px-8 xl:px-0">
        <h2 class="text-2xl font-extrabold tracking-tight text-gray-900">
            <x-ev.label>
                {{ translate('Shop by Category') }}
            </x-ev.label>
        </h2>
        <a href="{{ route('categories.all') }}"
            class="hidden text-sm font-semibold text-indigo-600 hover:text-indigo-500 sm:block">

            <x-ev.label :label="ev_dynamic_translate('Browse all categories', true)">
                <span aria-hidden="true"> &rarr;</span>
            </x-ev.label>

        </a>

    </div>
<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 mt-4" >
    @foreach ($categories as $key => $category)

        <div
            class="relative rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
            <div class="flex-shrink-0">
                <img class="h-10 w-10 rounded-full"
                    src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                    alt="">
            </div>
            <div class="flex-1 min-w-0">
                <a href="{{ route('category.products.index', $category->slug) }}" class="focus:outline-none">
                    <span class="absolute inset-0" aria-hidden="true"></span>
                    <p class="text-sm font-medium text-gray-900">
                        {{ $category->name }}
                    </p>
                    <p class="text-sm text-gray-500 truncate">
                        {{ $category->products()->count() }} {{ translate('Products') }}
                    </p>
                </a>
            </div>
        </div>

    @endforeach

    <!-- More people... -->
</div>
</div>
