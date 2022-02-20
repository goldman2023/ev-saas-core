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
                {{ Breadcrumbs::render('category', $selected_category) }}
            </div>
            <div class="col-sm-4">

            </div>
        </div>
    </div>
</div>

<section class="mb-4 pt-3">
    <div class="container sm-px-0">

        <form class="" id="search-form" action="" method="GET">
            {{-- <input type="hidden" name="content" value="{{$content}}" />--}}
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

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9">

                    @if($products->isNotEmpty())
                    <div class="row gutters-5 mt-2">
                        @foreach ($products as $key => $product)
                        <div class="col-sm-4 col-12 mb-3">
                            <x-default.products.cards.product-card :product="$product" class="product-card">
                            </x-default.products.cards.product-card>
                        </div>
                        @endforeach
                    </div>
                    @endif

                </div>


                <div class="col-xl-3">
                </div>
            </div>
        </form>
    </div>
</section>
@endsection
