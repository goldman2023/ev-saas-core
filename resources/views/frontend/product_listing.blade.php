@extends('frontend.layouts.' . $globalLayout)

@if (!empty($selected_category))
@php
$meta_title = $selected_category->meta_title;
$meta_description = $selected_category->meta_description;
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
<div class="bg-dark mb-3" style="margin-top:-130px;">
    <div class="container">
        <div class="row space-1 space-top-3">
            <div class="col-sm-8">
                <h1 class="text-white mt-3">
                    {{ translate('Shop') }}
                </h1>
                <div class="d-flex justify-content-between">
                    <ul class="breadcrumb bg-transparent p-0 text-white">
                        <li class="breadcrumb-item opacity-50">
                            <a class="" href="{{ route('home') }}">{{ translate('Home') }}</a>
                        </li>
                        <li class="breadcrumb-item {{ !empty($selected_category) ? 'fw-600':'opacity-50' }} ">
                            <a class="{{ !empty($selected_category) ? '':'text-white' }}"
                                href="{{ route('search') }}">{{ translate('All Categories') }}</a>
                        </li>
                        @if (!empty($selected_category))
                        <li class="text-dark fw-600 breadcrumb-item">
                            <a class="text-white" href="{{ route('products.category', $selected_category->slug) }}">
                                {{ $selected_category->getTranslation('name') }}</a>
                        </li>
                        @endif
                    </ul>


                </div>
            </div>
            <div class="col-sm-4">
                <form action="{{ route('search') }}" method="GET" class="mt-3 stop-propagation mb-0">
                    <div class="d-flex position-relative">
                        <div class="d-none" data-toggle="class-toggle" data-target=".front-header-search">
                            <button class="btn px-2" type="button" aria-label="search-button">
                                <i class="la la-2x la-long-arrow-left"></i></button>
                        </div>
                        <div class="input-group d-flex align-items-stretch">
                            <input type="text" class="border-0 border-lg form-control h-100" id="search" name="q"
                                value="{{ $query }}" placeholder="{{ translate('Search query...') }}"
                                autocomplete="off">
                            <div class="input-group-append d-block">
                                <button class="btn btn-primary" type="submit">
                                    <x-heroicon-s-search class="ev-icon__small" />
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


</div>
<section class="mb-4 pt-3">
    <div class="container sm-px-0">

        <form class="" id="search-form" action="" method="GET">
            <input type="hidden" name="content" value="{{$content}}" />
            <div class="row">
                <div class="col-xl-3">
                    <div class="aiz-filter-sidebar collapse-sidebar-wrap sidebar-xl sidebar-right z-1035">
                        <div class="overlay overlay-fixed dark c-pointer" data-toggle="class-toggle"
                            data-target=".aiz-filter-sidebar" data-same=".filter-sidebar-thumb"></div>
                        <div class="collapse-sidebar c-scrollbar-light text-left">
                            <div class="d-flex d-xl-none justify-content-between align-items-center pl-3 border-bottom">
                                <h3 class="h6 mb-0 fw-600">{{ translate('Filters') }}</h3>
                                <button type="button" class="btn btn-sm p-2 filter-sidebar-thumb"
                                    data-toggle="class-toggle" data-target=".aiz-filter-sidebar">
                                    <i class="las la-times la-2x"></i>
                                </button>
                            </div>
                            <div class="">
                                <x-default.categories.category-list :selectedCategory="$selected_category"
                                    style="category-list-sidebar"></x-default.categories.category-list>

                            </div>

                            @if($content != null)
                            <x-company.company-attributes :items="$attributes" :selected="$filters">
                            </x-company.company-attributes>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-xl-9">

                    @if ($content == 'product' || $content == null)
                    <div>
                        <div class="text-left">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h1 class="h3 fw-600">
                                        @if (!empty($selected_category))
                                        {{ translate('Products - ') }}
                                        {{ $selected_category->getTranslation('name') }}
                                        @elseif(isset($query))
                                        {{ translate('Products found matched ') }}"{{ $query }}"{{ ' : ' .
                                        $product->count() }}
                                        @else
                                        {{ translate('All Products') }}
                                        @endif
                                    </h1>
                                </div>
                                @if ($products->count() > 0 && $content == null && !empty($selected_category))
                                <div class="ml-auto text-right">
                                    <a class="font-weight-bold"
                                        href="{{ route('search', ['q' => $query, 'content' => 'product']) }}">
                                        {{ translate('View all ') }}
                                        <i class="las la-angle-right la-sm ml-1"></i>
                                    </a>
                                </div>
                                @endif
                                <div class="d-xl-none ml-auto ml-xl-3 mr-0 form-group align-self-end">
                                    <button type="button" class="btn btn-icon p-0" data-toggle="class-toggle"
                                        data-target=".aiz-filter-sidebar">
                                        <i class="la la-filter la-2x"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        {{-- Sub Categories Display --}}
                        @if(!empty($selected_category))
                        <x-default.categories.sub-category-cards :categories="$selected_category">
                        </x-default.categories.sub-category-cards>
                        @endif
                        {{-- END Sub Categories Display --}}
                        @if ($products->count() > 0)

                        <div class="row gutters-5 mt-2">
                            @foreach ($products as $key => $product)
                            <div class="col-sm-4 mb-3">
                                <x-default.products.cards.product-card :product="$product" class="product-card">
                                </x-default.products.cards.product-card>
                            </div>
                            @endforeach
                        </div>
                        @if ($content == 'product' || !empty($selected_category))
                        <hr />
                        <div class="d-flex ev-pagination justify-content-center mt-3">
                            {{ $products->links() }}
                        </div>
                        @endif
                        @else
                        <p class="text-center mt-2">{{ translate('Nothing found') }}</p>
                        @endif
                    </div>
                    @endif


                </div>


                <div class="col-xl-3">

                    <!--<div class="aiz-filter-sidebar collapse-sidebar-wrap sidebar-xl sidebar-right z-1035">
                        <div class="overlay overlay-fixed dark c-pointer" data-toggle="class-toggle"
                            data-target=".aiz-filter-sidebar" data-same=".filter-sidebar-thumb"></div>
                        <div class="collapse-sidebar c-scrollbar-light text-left">
                            <div class="d-flex d-xl-none justify-content-between align-items-center pl-3 border-bottom">
                                <h3 class="h6 mb-0 fw-600">{{ translate('Filters') }}</h3>
                                <button type="button" class="btn btn-sm p-2 filter-sidebar-thumb"
                                    data-toggle="class-toggle" data-target=".aiz-filter-sidebar">
                                    <i class="las la-times la-2x"></i>
                                </button>
                            </div>
                            <div class="bg-white shadow-sm rounded mb-3">
                                <div class="fs-15 fw-600 p-3 border-bottom">
                                    {{ translate('Categories') }}
                                </div>
                                <div class="p-3">
                                    <ul class="list-unstyled">

                                    </ul>
                                </div>
                            </div>

                            @if($content != null)
                                <x-company.company-attributes :items="$attributes" :selected="$filters">
                                </x-company.company-attributes>
                            @endif
                        </div>
                    </div>-->
                </div>
            </div>
        </form>
    </div>
</section>

@endsection

@push('footer_scripts')
<script src="{{ static_asset('vendor/hs.select2.js', false, true) }}"></script>
<script src="{{ static_asset('vendor/hs.daterangepicker.js', false, true) }}"></script>
<script src="{{ static_asset('vendor/hs.ion-range-slider.js', false, true) }}"></script>
<script>
    // INITIALIZATION OF SELECT PICKER
            // =======================================================
            $('.js-custom-select').each(function () {
                var select2 = $.HSCore.components.HSSelect2.init($(this));
            });
            // INITIALIZATION OF ION RANGE SLIDER
            // =======================================================
            $('.js-ion-range-slider').each(function () {
                $.HSCore.components.HSIonRangeSlider.init($(this));
            });
            // INITIALIZATION OF DATERANGEPICKER
            // =======================================================
            $.HSCore.components.HSDaterangepicker.init($('.js-daterangepicker-times'));

            $('.js-daterangepicker-times').on('apply.daterangepicker', function(ev, picker) {
                filter();
            });
            $('.js-daterangepicker-times').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                filter();
            });
</script>
@endpush

<script type="text/javascript">
    function filter() {
        $('#search-form').submit();
    }
</script>
