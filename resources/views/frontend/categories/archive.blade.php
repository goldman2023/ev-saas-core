@extends('frontend.layouts.' . $globalLayout)

@if (!empty($selected_category))
    @php
        $meta_title = $selected_category->meta_title;
        $meta_description = $selected_category->meta_description;
    @endphp
@else
    @php
        $meta_title = get_setting('website_name') . translate(' Products');
        $meta_description = get_setting('site_motto');
    @endphp
@endif

@section('meta_description'){{ $meta_description }}@stop

@section('meta')
    <meta name="robots" content="index, follow" />
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
    <div class="bg-dark mb-3" style="">
        <div class="container">
            <div class="row py-3">
                <div class="col-sm-8">

                    <div class="d-flex justify-content-between">
                        <ul class="breadcrumb bg-transparent p-0 text-white my-0">
                            <li class="breadcrumb-item opacity-50">
                                <a class="text-white" href="{{ route('home') }}">{{ translate('Home') }}</a>
                            </li>

                            <li class="breadcrumb-item {{ !empty($selected_category) ? 'fw-400':'opacity-50' }} ">
                                <a class="text-white"
                                   href="{{ route('search') }}">{{ translate('All Categories') }}</a>
                            </li>

                            @if (!empty($selected_category->parent))
                                <li class="text-dark fw-400 opacity-50 breadcrumb-item">
                                    <a class="text-white" href="{{ route('category.index', $selected_category->parent->slug) }}">
                                        {{ $selected_category->parent->getTranslation('name') }}</a>
                                </li>
                            @endif

                            @if (!empty($selected_category))
                                <li class="text-dark fw-600 breadcrumb-item">
                                    <a class="text-primary" href="{{ route('category.index', $selected_category->slug) }}">
                                        {{ $selected_category->getTranslation('name') }}</a>
                                </li>
                            @endif
                        </ul>


                    </div>
                </div>
                <div class="col-sm-4">

                </div>
            </div>
        </div>


    </div>
    <section class="mb-4 pt-3">
        <div class="container sm-px-0">

            <form class="" id="search-form" action="" method="GET">
{{--                <input type="hidden" name="content" value="{{$content}}" />--}}
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
                                <div class="d-none d-sm-block">
                                    <x-default.categories.category-list :selectedCategory="$selected_category"
                                                                        class="category-list-sidebar">

                                    </x-default.categories.category-list>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-9">



                    </div>


                    <div class="col-xl-3">
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
