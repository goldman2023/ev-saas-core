@extends('frontend.layouts.user_panel')

@section('page_title', translate('All Products'))

@section('panel_content')

<div class="min-h-full">

    <main class="pb-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:max-w-7xl lg:px-0">
            <h1 class="sr-only">Profile</h1>
            <!-- Main 3 column grid -->
            <div class="grid grid-cols-1 gap-4 items-start lg:grid-cols-3 lg:gap-8">
                <!-- Left column -->
                <div class="grid grid-cols-1 gap-4 lg:col-span-2">
                    <!-- Welcome panel -->
                    <section aria-labelledby="profile-overview-title">
                        <div class="rounded-lg bg-white overflow-hidden shadow">
                            <h2 class="sr-only" id="profile-overview-title">Profile Overview</h2>
                            <div class="bg-white p-6">
                                <div class="sm:flex sm:items-center sm:justify-between">
                                    <div class="sm:flex sm:space-x-5">
                                        <div class="flex-shrink-0">
                                            <img class="object-contain bg-white mx-auto h-20 w-20 rounded-full"
                                                src="{{ $product->getThumbnail() }}" alt="{{ $product->name }} image">
                                        </div>
                                        <div class="mt-4 text-center sm:mt-0 sm:pt-1 sm:text-left">
                                            <p class="text-xl font-bold text-gray-900 sm:text-2xl mb-3">
                                                {{ $product->name }}
                                            </p>
                                            <p class="text-sm font-medium text-gray-600">
                                                @foreach($product->categories()->get() as $category)
                                                <a
                                                target="_blank"
                                                href="{{ $category->getPermalink() }}"
                                                    class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                                    {{ $category->name }}
                                            </a>
                                                @endforeach
                                            </p>
                                        </div>
                                    </div>
                                    <div class="mt-5 flex justify-center sm:mt-0">
                                        <a href="{{ $product->getPermalink() }}" target="_blank"
                                            class="flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                            {{ translate('View') }} {{ translate('product') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="border-t border-gray-200 bg-gray-50 grid grid-cols-1 divide-y divide-gray-200 sm:grid-cols-3 sm:divide-y-0 sm:divide-x">
                                <div class="px-6 py-5 text-sm font-medium text-center">
                                    <span class="text-gray-900">
                                        {{ $product->public_view_count() }}
                                    </span>
                                    <span class="text-gray-600">
                                        {{ translate('Total views') }}
                                    </span>
                                </div>

                                <div class="px-6 py-5 text-sm font-medium text-center">
                                    <span class="text-gray-900">
                                        {{ $product->getBasePrice(true) }}
                                    </span>
                                    <span class="text-gray-600">{{ translate('Price') }}</span>
                                </div>

                                <div class="px-6 py-5 text-sm font-medium text-center">
                                    <span class="text-gray-900">{{ $product->getCurrentStockAttribute() }}</span>
                                    <span class="text-gray-600">{{ translate('Current Stock') }}</span>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Actions panel -->
                    <section aria-labelledby="quick-links-title">
                        <div
                            class="rounded-lg bg-gray-200 overflow-hidden shadow divide-y divide-gray-200 sm:divide-y-0 sm:grid sm:grid-cols-2 sm:gap-px">
                            <h2 class="sr-only" id="quick-links-title">Quick links</h2>

                            <div
                                class="rounded-tl-lg rounded-tr-lg sm:rounded-tr-none relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-cyan-500">
                                <div>
                                    <span class="rounded-lg inline-flex p-3 bg-teal-50 text-teal-700 ring-4 ring-white">
                                        <!-- Heroicon name: outline/clock -->
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="mt-8">
                                    <h3 class="text-lg font-medium">

                                        <a href="#" class="focus:outline-none">
                                            <!-- Extend touch target to entire panel -->
                                            <span class="absolute inset-0" aria-hidden="true"></span>
                                            Request time off
                                        </a>
                                    </h3>
                                    <p class="mt-2 text-sm text-gray-500">Doloribus dolores nostrum quia qui natus
                                        officia quod et dolorem. Sit repellendus qui ut at blanditiis et quo et
                                        molestiae.</p>
                                </div>
                                <span
                                    class="pointer-events-none absolute top-6 right-6 text-gray-300 group-hover:text-gray-400"
                                    aria-hidden="true">
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z" />
                                    </svg>
                                </span>
                            </div>
                            <div
                                class="rounded-tl-lg rounded-tr-lg sm:rounded-tr-none relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-cyan-500">
                                <a class="btn btn-soft-info btn-circle btn-xs d-inline-flex align-items-center"
                                    href="{{ route('product.single', $product->slug) }}" target="_blank">
                                    @svg('heroicon-o-eye', ['style' => 'height: 16px;', 'class' => 'mr-2'])
                                    {{ translate('Preview') }}
                                </a>

                                <a class="btn btn-soft-info btn-circle btn-xs d-inline-flex align-items-center"
                                    href="{{ route('product.edit.stocks', $product->slug) }}">
                                    @svg('heroicon-o-archive', ['style' => 'height: 16px;', 'class' => 'mr-2'])
                                    {{ translate('Stock Management') }}
                                </a>

                                @if($product->useVariations())
                                <a class="btn btn-soft-info btn-circle btn-xs d-inline-flex align-items-center"
                                    href="{{ route('product.edit.variations', $product->slug) }}">
                                    @svg('heroicon-o-variable', ['style' => 'height: 16px;', 'class' => 'mr-2'])
                                    {{ translate('Variations') }}
                                </a>
                                @endif

                                <a class="btn btn-soft-info btn-circle btn-xs d-inline-flex align-items-center"
                                    href="{{ route('product.edit', $product->slug) }}">
                                    {{ translate('Edit') }} @svg('heroicon-o-pencil-alt', ['style' => 'height: 16px;',
                                    'class' => 'ml-2'])
                                </a>

                                <a class="btn btn-soft-info btn-circle btn-xs d-inline-flex align-items-center"
                                    href="{{ route('product.activity', $product->slug) }}">
                                    {{ translate('Activity') }} @svg('heroicon-o-pencil-alt', ['style' => 'height:
                                    16px;', 'class' => 'ml-2'])
                                </a>

                                <a class="btn btn-soft-danger btn-circle btn-xs d-inline-flex align-items-center confirm-delete "
                                    href="javascript:void(0)">
                                    {{ translate('Delete') }} @svg('heroicon-o-trash', ['style' => 'height: 16px;',
                                    'class' => 'ml-2'])
                                </a>
                            </div>

                        </div>
                    </section>
                </div>

                <!-- Right column -->
                <div class="grid grid-cols-1 gap-4">
                    <!-- Announcements -->
                    <section aria-labelledby="announcements-title">
                        <div class="rounded-lg bg-white overflow-hidden shadow">
                            <div class="p-6">
                                <h2 class="text-base font-medium text-gray-900" id="announcements-title">
                                    {{ translate('Social eCommerce Channels') }}
                                </h2>
                                <div class="flow-root mt-6">
                                    <ul role="list" class="-my-5 divide-y divide-gray-200">
                                        <li class="py-5">
                                            <div class="relative focus-within:ring-2 focus-within:ring-cyan-500">
                                                <h3 class="text-sm font-semibold text-gray-800">
                                                    <a href="#" class="hover:underline focus:outline-none">
                                                        <!-- Extend touch target to entire panel -->
                                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                                        Stripe
                                                    </a>
                                                </h3>
                                                <p class="mt-1 text-sm text-gray-600 line-clamp-2">Cum qui rem deleniti.
                                                    Suscipit in dolor veritatis sequi aut. Vero ut earum quis deleniti.
                                                    Ut a sunt eum cum ut repudiandae possimus. Nihil ex tempora neque
                                                    cum consectetur dolores.</p>
                                            </div>
                                        </li>
                                        <li class="py-5">
                                            <div class="relative focus-within:ring-2 focus-within:ring-cyan-500">
                                                <h3 class="text-sm font-semibold text-gray-800">
                                                    <a href="#" class="hover:underline focus:outline-none">
                                                        <!-- Extend touch target to entire panel -->
                                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                                        Facebook Business Manager
                                                    </a>
                                                </h3>
                                                <p class="mt-1 text-sm text-gray-600 line-clamp-2">Cum qui rem deleniti.
                                                    Suscipit in dolor veritatis sequi aut. Vero ut earum quis deleniti.
                                                    Ut a sunt eum cum ut repudiandae possimus. Nihil ex tempora neque
                                                    cum consectetur dolores.</p>
                                            </div>
                                        </li>



                                        <li class="py-5">
                                            <div class="relative focus-within:ring-2 focus-within:ring-cyan-500">
                                                <h3 class="text-sm font-semibold text-gray-800">
                                                    <a href="#" class="hover:underline focus:outline-none">
                                                        <!-- Extend touch target to entire panel -->
                                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                                        Instagram Shop
                                                    </a>
                                                </h3>
                                                <p class="mt-1 text-sm text-gray-600 line-clamp-2">Tenetur libero
                                                    voluptatem rerum occaecati qui est molestiae exercitationem.
                                                    Voluptate quisquam iure assumenda consequatur ex et recusandae.
                                                    Alias consectetur voluptatibus. Accusamus a ab dicta et. Consequatur
                                                    quis dignissimos voluptatem nisi.</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="mt-6">
                                    <a href="#"
                                        class="w-full flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                        View all </a>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Recent Hires -->
                    <section aria-labelledby="recent-hires-title">
                        <div class="rounded-lg bg-white overflow-hidden shadow">
                            <div class="p-6">
                                <h2 class="text-base font-medium text-gray-900" id="recent-hires-title">
                                    {{ translate('Recent orders') }}
                                </h2>
                                <div class="flow-root mt-6">
                                    <ul role="list" class="-my-5 divide-y divide-gray-200">
                                        <li class="py-4">
                                            <div class="flex items-center space-x-4">
                                                <div class="flex-shrink-0">
                                                    <img class="h-8 w-8 rounded-full"
                                                        src="https://images.unsplash.com/photo-1519345182560-3f2917c472ef?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                                        alt="">
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-gray-900 truncate">Leonard
                                                        Krasner</p>
                                                    <p class="text-sm text-gray-500 truncate">via Stripe</p>
                                                </div>
                                                <div>
                                                    <a href="#"
                                                        class="inline-flex items-center shadow-sm px-2.5 py-0.5 border border-gray-300 text-sm leading-5 font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50">
                                                        View </a>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="mt-6">
                                    <a href="#"
                                        class="w-full flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                        View all </a>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </main>

</div>


<div class="grid grid-cols-3 gap-5">
    <div>
        {{-- TODO: Create product preview for tailwind --}}
        <x-default.products.cards.product-card :product="$product">
        </x-default.products.cards.product-card>
    </div>

    <div>
        <div class="card">
            <h3>{{ translate('Product Activity') }} </h3>
            <livewire:product-activity :product="$product" />
        </div>

    </div>

    <div>
        <!--Categories Card -->
        <div class="card h-100">
            <div class="card-body">
                <h6 class="font-weight-normal mb-1">{{ translate('Product Categories') }}:</h6>
                <h4 class="card-title">
                    @foreach($product->categories()->get() as $category)
                    <span class="badge badge-soft-primary p-2 mb-2">
                        {{ $category->name }}
                    </span>
                    @endforeach
                    {{-- Assign Categories button --}}
                    <div class="mt-3">
                        <small>
                            <a href="{{ route('product.edit', $product->slug) }}" target="_blank">
                                {{ translate('+ Assign Categories') }} </a>
                        </small>
                    </div>
                </h4>
            </div>
        </div>
        <!-- End Card -->
    </div>
</div>



@endsection

@push('footer_scripts')

@endpush
