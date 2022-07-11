@extends('frontend.layouts.app')

@section('content')
<div class="min-h-full bg-gray-200">

    <!--
      When the mobile menu is open, add `overflow-hidden` to the `body` element to prevent double scrollbars

      Menu open: "fixed inset-0 z-40 overflow-y-auto", Menu closed: ""
    -->
    @isset($selected_category)
        <div>
            {{ Breadcrumbs::render('category', $selected_category) }}
        </div>
    @endisset
    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:max-w-7xl lg:px-8 lg:grid lg:grid-cols-12 lg:gap-8">
            <div class="hidden lg:block lg:col-span-2 xl:col-span-2">
                @foreach(Categories::getAll() as $category)
                <div class="-m-1 flex flex-wrap items-center">
                    <a
                    href="{{ route('category.index', [$category->slug]) }}"
                        class="cursor-pointer whitespace-nowrap min-w-[50px] nowrap m-1 inline-flex rounded-full border border-gray-200 items-center py-1.5 pl-3 pr-2 text-sm font-medium "
                        :class="{'bg-info text-white':selected_categories.indexOf({{ $category->id }}) !== -1, 'bg-white text-gray-900':selected_categories.indexOf({{ $category->id }}) === -1}">
                        <span>{{ $category->name }}</span>
                        <button type="button"
                            class="flex-shrink-0 ml-1 h-4 w-4 p-1 rounded-full inline-flex text-gray-400 hover:bg-gray-200 hover:text-gray-500">
                            <svg class="h-2 w-2" stroke="currentColor" fill="none" viewBox="0 0 8 8">
                                <path stroke-linecap="round" stroke-width="1.5" d="M1 1l6 6m0-6L1 7"></path>
                            </svg>
                        </button>
                    </a>

                </div>

                @endforeach
            </div>
            <main class="lg:col-span-9 xl:col-span-10">
                <div class="mt-4">
                    <div class="mb-5">
                        <div class="bg-white">
                            <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                                <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">
                                    {{ $selected_category->name }}
                                </h1>
                                <p class="mt-4 max-w-xl text-sm text-gray-700">
                                    {{ $selected_category->description }}
                                </p>
                            </div>
                        </div>
                        {{-- <livewire:feed.elements.shop.shop-archive-filters></livewire:feed.elements.shop.shop-archive-filters> --}}
                    </div>

                    <livewire:feed.archive :items="$products" :model_class="\App\Models\Product::class" :show-filters="true"></livewire:feed.archive>
                </div>
            </main>
            <aside class="xl:block col-span-4 xl:col-span-3">

            </aside>
        </div>
    </div>
</div>

@endsection
