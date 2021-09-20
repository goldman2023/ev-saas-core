@extends('frontend.layouts.app')

@if (isset($category_id))
    @php
        $meta_title = \App\Models\Category::find($category_id)->meta_title;
        $meta_description = \App\Models\Category::find($category_id)->meta_description;
    @endphp
@elseif (isset($brand_id))
    @php
        $meta_title = \App\Models\Brand::find($brand_id)->meta_title;
        $meta_description = \App\Models\Brand::find($brand_id)->meta_description;
    @endphp
@else
    @php
        $meta_title = get_setting('meta_title');
        $meta_description = get_setting('meta_description');
    @endphp
@endif

@section('meta_title'){{ $meta_title }}@stop
@section('meta_description'){{ $meta_description }}@stop

@section('meta')
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{ $meta_title }}">
    <meta itemprop="description" content="{{ $meta_description }}">

    <!-- Twitter Card data -->
    <meta name="twitter:title" content="{{ $meta_title }}">
    <meta name="twitter:description" content="{{ $meta_description }}">

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $meta_title }}" />
    <meta property="og:description" content="{{ $meta_description }}" />
@endsection

@section('content')
    <div class="container space-2 space-bottom-lg-3">
        <div class="row">
            <div class="col-lg-3 order-lg-2 mb-5 mb-lg-0">
                <!-- Navbar -->
                <div class="navbar-expand-lg navbar-expand-lg-collapse-block navbar-light">
                    <!-- Responsive Toggle Button -->
                    <button type="button" class="navbar-toggler btn btn-block btn-white" aria-label="Toggle navigation"
                        aria-expanded="false" aria-controls="sidebarNav" data-toggle="collapse" data-target="#sidebarNav">
                        <span class="d-flex justify-content-between align-items-center">
                            <span class="h5 mb-0">View all filters</span>
                            <span class="navbar-toggler-default">
                                <svg width="14" height="14" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                    <path fill="currentColor"
                                        d="M17.4,6.2H0.6C0.3,6.2,0,5.9,0,5.5V4.1c0-0.4,0.3-0.7,0.6-0.7h16.9c0.3,0,0.6,0.3,0.6,0.7v1.4C18,5.9,17.7,6.2,17.4,6.2z M17.4,14.1H0.6c-0.3,0-0.6-0.3-0.6-0.7V12c0-0.4,0.3-0.7,0.6-0.7h16.9c0.3,0,0.6,0.3,0.6,0.7v1.4C18,13.7,17.7,14.1,17.4,14.1z">
                                    </path>
                                </svg>
                            </span>
                            <span class="navbar-toggler-toggled">
                                <svg width="14" height="14" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                    <path fill="currentColor"
                                        d="M11.5,9.5l5-5c0.2-0.2,0.2-0.6-0.1-0.9l-1-1c-0.3-0.3-0.7-0.3-0.9-0.1l-5,5l-5-5C4.3,2.3,3.9,2.4,3.6,2.6l-1,1 C2.4,3.9,2.3,4.3,2.5,4.5l5,5l-5,5c-0.2,0.2-0.2,0.6,0.1,0.9l1,1c0.3,0.3,0.7,0.3,0.9,0.1l5-5l5,5c0.2,0.2,0.6,0.2,0.9-0.1l1-1 c0.3-0.3,0.3-0.7,0.1-0.9L11.5,9.5z">
                                    </path>
                                </svg>
                            </span>
                        </span>
                    </button>
                    <!-- End Responsive Toggle Button -->

                    <div id="sidebarNav" class="collapse navbar-collapse">
                        <div class="pt-4 pt-lg-0">
                            <!-- Filter Form -->
                            <h3 class="mb-3">{{ translate('Get in touch') }} </h3>
                            {{-- TODO: Add contacts component --}}
                                <x-default.widgets.contact-widget></x-default.widgets.contact-widget>

                            <!-- End Filter Form -->
                        </div>
                    </div>
                </div>
                <!-- End Navbar -->
            </div>

            <div class="col-lg-9">
                <!-- Title and Sort -->
                <div class="row align-items-sm-center">
                    <div class="col-sm mb-3 mb-sm-0">

                        <h3 class="mb-0">
                            @if (isset($category_id))
                                {{ translate('Products - ') }}{{ \App\Models\Category::find($category_id)->getTranslation('name') }}
                            @elseif(isset($query))
                                {{ translate('Products found matched ') }}"{{ $query }}"{{ ' : ' . $product_count }}
                            @else
                                {{ translate('All Products') }}
                            @endif

                        </h3>
                    </div>

                    <div class="col-sm-auto">
                        <div class="d-flex align-items-center">
                            <!-- Select -->

                            <!-- End Select -->
                        </div>
                    </div>
                </div>
                <!-- End Title and Sort -->

                <hr class="my-4">

                <!-- Listing -->
                <div class="row">
                    <!-- Card -->
                    @foreach ($products as $key => $product)
                        <div class="col-sm-6 mb-3">
                            <x-default.products.cards.product-card :product="$product" style="product-card-detailed-grid">
                            </x-default.products.cards.product-card>
                        </div>
                    @endforeach

                </div>
                <!-- End Listing -->

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-7">
                    {{ $products->links() }}
                </div>
                <!-- End Pagination -->


            </div>
        </div>
        <!-- End Row -->
    </div>

@endsection
