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
                <form class="lg:block">
                    <h3 class="sr-only">{{ translate('Categories') }}</h3>
                    <ul role="list" class="space-y-4 border-b border-gray-200 pb-6 text-sm font-medium text-gray-900">
                        <li>
                            <a href="{{ route('products.all') }}">
                                {{ translate('All Products') }}
                            </a>
                        </li>
                        @foreach(\App\Models\Category::where('parent_id', null)->whereHas('products')->get() as $category)
                        <li>
                            @isset($selected_category->id)
                            {{-- TODO: Add a new method to CategoryService which checks if first cat. is second cat. or
                            if first cat. is second cat. child (or sub-sub--child etc.) --}}
                            <a href="{{ $category->getPermalink() }}"
                                class="{{ ($selected_category->id === $category->id) ? 'text-primary': '' }}">
                                {{ $category->name }}
                            </a>
                            @else
                            <a href="{{ $category->getPermalink() }}">
                                {{ $category->name }}
                            </a>
                            @endisset
                        </li>
                        @endforeach

                    </ul>

                    <div class="w-full mt-3 mb-3">
                        @isset($filterable_attributes)
                        <livewire:forms.attributes-filter-form :attributes="$filterable_attributes" />
                        @endisset
                    </div>
                </form>

                <!-- Products archive -->
                <livewire:tenant.product.products-archive class="sm:!grid-cols-1" :category="$selected_category" />

                <div class="grid grid-cols-1 gap-x-8 gap-y-10 lg:grid-cols-4">
                </div>

                <div class="w-full grid sm:grid-cols-12 gap-y-10 gap-x-6 lg:col-span-3 lg:gap-x-8">
                    <a href="{{ translate('/priekabu-gamyba') }}" type="button"
                        class="w-full col-span-6 bg-white relative block w-full rounded-lg border-2 border-dashed border-gray-300 p-12 text-center hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <img class="mx-auto h-24 text-gray-400"
                        loading="lazy"
                            src="https://businesspress.fra1.digitaloceanspaces.com/uploads/fff40500-0cca-4b32-8500-92dbfff35e36/1677768657_priekabu-gamyba.gif" />

                        <span class="mt-2 block text-sm font-semibold text-gray-900">
                            {{ translate('Individualūs užsakymai') }}
                        </span>
                    </a>

                    <a href="{{ translate('/priekabu-gamyba') }}" type="button"
                        class="w-full col-span-6 bg-white relative block w-full rounded-lg border-2 border-dashed border-gray-300 p-12 text-center hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <img class="mx-auto h-24 text-gray-400"
                        loading="lazy"
                            src="{{ get_site_logo() }}" />

                        <span class="mt-2 block text-sm font-semibold text-gray-900">
                            {{ translate('Reikia konsultacijos? Susisiekite') }}
                        </span>
                    </a>

                </div>
            </div>
        </section>
    </main>
</div>
</div>

@endsection
