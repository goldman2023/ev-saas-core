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

                    <div class="w-full mt-3 mb-3">
                        @isset($filterable_attributes)
                        <livewire:forms.attributes-filter-form :attributes="$filterable_attributes" />
                        @endisset
                    </div>



                    {{-- Promo block --}}
                    <a href="#" class="group block mt-6">

                        <h3 class="mt-4 text-base font-semibold text-gray-900">
                            {{ translate('Individual Orders') }}
                        </h3>
                        <p class="mt-2 text-sm text-gray-500">
                            {{ translate('We can make you a custom made order. Reach out to us and we will send you a
                            price quote in 1 working day.') }}
                        </p>

                    </a>

                </form>

                <!-- Products archive -->
                <livewire:tenant.product.products-archive class="sm:!grid-cols-1" />
            </div>
        </section>
    </main>
</div>
</div>

@endsection
