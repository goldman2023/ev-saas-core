@extends('frontend.layouts.app')

@section('content')

<div class="bg-white">


    <div class="max-w-7xl mx-auto mt-8">



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
    <main class="max-w-7xl mx-auto">

        <section aria-labelledby="products-heading" class="pt-6 pb-24">
            <h2 id="products-heading" class="sr-only">Products</h2>

            <div class="grid grid-cols-1 gap-x-8 gap-y-10 lg:grid-cols-4">
                <!-- Filters -->
                <form class="hidden lg:block">
                    <h3 class="sr-only">Categories</h3>
                    <ul role="list" class="space-y-4 border-b border-gray-200 pb-6 text-sm font-medium text-gray-900">

                        @foreach(Categories::getAll() as $category)
                        <li>
                            <a href="{{ $category->getPermalink() }}">
                                {{ $category->name }}
                            </a>
                        </li>

                        @endforeach

                    </ul>

                    {{-- Promo block --}}
                    <a href="#" class="group block">
                        <div aria-hidden="true" class="aspect-w-3 aspect-h-2 overflow-hidden rounded-lg group-hover:opacity-75 lg:aspect-w-5 lg:aspect-h-6">
                          <img src="https://tailwindui.com/img/ecommerce-images/home-page-01-collection-01.jpg" alt="Brown leather key ring with brass metal loops and rivets on wood table." class="h-full w-full object-cover object-center">
                        </div>
                        <h3 class="mt-4 text-base font-semibold text-gray-900">
                            {{ translate('Individual Orders') }}
                        </h3>
                        <p class="mt-2 text-sm text-gray-500">
                            {{ translate('We can make you a custom made order. Reach out to us and we will send you a price quote in 1 working day.') }}
                        </p>
                        <a href="#" class="btn-primary mt-3">
                            {{ translate('Fill out order form') }}
                        </a>
                      </a>

                </form>

                <!-- Product grid -->
                <div class="grid sm:grid-cols-12 gap-y-10 gap-x-6 sm:grid-cols-1 lg:col-span-3 lg:gap-x-8">
                    @foreach ($products as $item)
                    @if($item instanceof \App\Models\Product)
                    <x-default.products.product-card :product="$item"></x-default.products.product-card>
                    {{-- <x-feed.elements.product-card :product="$item"></x-feed.elements.product-card> --}}
                    @endif
                    @endforeach

                    {{ $products->links() }}




                    <!-- More products... -->
                </div>
            </div>
        </section>
    </main>
</div>
</div>

@endsection