@extends('frontend.layouts.app')

@section('content')

<div class="bg-gray-100 pt-12">
    <div class="container !px-6 mx-auto">
        <div class="flex items-baseline justify-between border-b border-gray-200 pb-6">
            <h1 class="text-4xl font-bold tracking-tight text-gray-900">
                @isset($selected_category->name)
                    {{ $selected_category->name }}
                @else
                    {{ translate('All products') }}
                @endisset
            </h1>
        </div>
    </div>
    <div class="w-full mb-8">
        @isset($selected_category)
        <div>
            {{ Breadcrumbs::render('category', $selected_category) }}
        </div>
        @else
        {{ Breadcrumbs::render('products') }}

        @endisset
    </div>
    <main class="container !px-6 mx-auto">

        <section aria-labelledby="products-heading" class="pt-6 pb-24">
            <h2 id="products-heading" class="sr-only">
                {{ translate('Products') }}
            </h2>

            <div class="grid grid-cols-1 gap-x-8 gap-y-10 lg:grid-cols-4">
                <!-- Filters -->
                <form class="hidden lg:block">
                    <h3 class="sr-only">{{ translate('Categories') }}</h3>
                    <ul role="list" class="space-y-4 border-b border-gray-200 pb-6 text-sm font-medium text-gray-900">
                        <li>
                            <a href="{{ route('products.all') }}">
                                {{ translate('All Products') }}
                            </a>
                        </li>
                        @foreach(\App\Models\Category::where('parent_id', null)->whereHas('products')->get() as $category)
                        <li>
                            <a href="{{ $category->getPermalink() }}">
                                {{ $category->name }}
                            </a>
                        </li>
                        @endforeach

                    </ul>

                    <div class="flex mt-3 mb-3">
                        <div class="flex items-center h-5">
                            <input id="helper-checkbox" aria-describedby="helper-checkbox-text" type="checkbox" value=""
                                class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        </div>
                        <div class="ml-2 text-sm">
                            <label for="helper-checkbox" class="font-medium text-gray-900 dark:text-gray-300">
                                Stabdžiai
                            </label>
                            <p id="helper-checkbox-text" class="text-xs font-normal text-gray-500 dark:text-gray-300">

                            </p>
                        </div>
                    </div>

                    <h3 class="font-bold mt-3">
                        Ašys
                    </h3>
                    <div class="flex mt-3 mb-3">
                        <div class="flex items-center h-5">
                            <input id="helper-checkbox" aria-describedby="helper-checkbox-text" type="checkbox" value=""
                                class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        </div>
                        <div class="ml-2 text-sm">
                            <label for="helper-checkbox" class="font-medium text-gray-900 dark:text-gray-300">
                                1 Ašis
                            </label>
                            <p id="helper-checkbox-text" class="text-xs font-normal text-gray-500 dark:text-gray-300">

                            </p>
                        </div>

                    </div>

                    <div class="flex mt-3 mb-3">
                        <div class="flex items-center h-5">
                            <input id="helper-checkbox" aria-describedby="helper-checkbox-text" type="checkbox" value=""
                                class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        </div>
                        <div class="ml-2 text-sm">
                            <label for="helper-checkbox" class="font-medium text-gray-900 dark:text-gray-300">
                                2 Ašys
                            </label>
                            <p id="helper-checkbox-text" class="text-xs font-normal text-gray-500 dark:text-gray-300">

                            </p>
                        </div>

                    </div>

                    <div class="flex mt-3 mb-3">
                        <div class="flex items-center h-5">
                            <input id="helper-checkbox" aria-describedby="helper-checkbox-text" type="checkbox" value=""
                                class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        </div>
                        <div class="ml-2 text-sm">
                            <label for="helper-checkbox" class="font-medium text-gray-900 dark:text-gray-300">
                                3 Ašys
                            </label>
                            <p id="helper-checkbox-text" class="text-xs font-normal text-gray-500 dark:text-gray-300">

                            </p>
                        </div>

                    </div>

                    {{-- Promo block --}}
                    <a href="#" class="group block mt-6">
                        <div aria-hidden="true"
                            class="aspect-w-3 aspect-h-2 overflow-hidden rounded-lg group-hover:opacity-75 lg:aspect-w-5 lg:aspect-h-6">
                            <img src="https://tailwindui.com/img/ecommerce-images/home-page-01-collection-01.jpg"
                                alt="Brown leather key ring with brass metal loops and rivets on wood table."
                                class="hidden h-full w-full object-cover object-center">
                        </div>
                        <h3 class="mt-4 text-base font-semibold text-gray-900">
                            {{ translate('Individual Orders') }}
                        </h3>
                        <p class="mt-2 text-sm text-gray-500">
                            {{ translate('We can make you a custom made order. Reach out to us and we will send you a
                            price quote in 1 working day.') }}
                        </p>
                        <button class="btn-primary mt-3">
                            {{ translate('Filter') }}
                        </button>
                    </a>

                </form>

                <!-- Product grid -->
                <div class="grid sm:grid-cols-12 gap-y-10 gap-x-6 sm:grid-cols-1 lg:col-span-3 lg:gap-x-8">
                    @foreach ($products as $item)
                    @if($item instanceof \App\Models\Product && $item)
                    <x-default.products.product-card :product="$item"></x-default.products.product-card>
                    {{-- <x-feed.elements.product-card :product="$item"></x-feed.elements.product-card> --}}
                    @endif
                    @endforeach

                    @if($products->hasPages())
                    <div class="w-full">
                        {{ $products->onEachSide(3)->links('pagination::tailwind') }}
                    </div>
                    @endif



                    <!-- More products... -->
                </div>
            </div>
        </section>
    </main>
</div>
</div>

@endsection
