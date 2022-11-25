@extends('frontend.layouts.app')

@section('content')

<div class="bg-gray-100 pt-8">


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
                <div>
                    <form class="hidden lg:block">
                        <h3 class="sr-only">Categories</h3>
                        <ul role="list"
                            class="space-y-4 border-b border-gray-200 pb-6 text-sm font-medium text-gray-900">

                            @foreach(Categories::getAll() as $category)
                            <li>
                                <a href="{{ $category->getPermalink() }}">
                                    {{ $category->name }}
                                </a>
                            </li>

                            @endforeach

                        </ul>
                    </form>

                    <div>
                        <x-products.promo-block></x-products.promo-block>
                    </div>
                </div>



                <!-- Product grid -->
                <div class="grid sm:grid-cols-4 gap-y-10 gap-x-6 sm:grid-cols-3 lg:col-span-3 lg:gap-x-8">
                    @foreach ($products as $item)
                    @if($item instanceof \App\Models\Product)
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
