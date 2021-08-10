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
        $meta_title         = get_setting('meta_title');
        $meta_description   = get_setting('meta_description');
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

    <section class="mb-4 pt-3">
        <div class="container sm-px-0">
            <form class="" id="search-form" action="" method="GET">
                <div class="row">
                    <div class="col-xl-3">
                        <div class="aiz-filter-sidebar collapse-sidebar-wrap sidebar-xl sidebar-right z-1035">
                            <div class="overlay overlay-fixed dark c-pointer" data-toggle="class-toggle" data-target=".aiz-filter-sidebar" data-same=".filter-sidebar-thumb"></div>
                            <div class="collapse-sidebar c-scrollbar-light text-left">
                                <div class="d-flex d-xl-none justify-content-between align-items-center pl-3 border-bottom">
                                    <h3 class="h6 mb-0 fw-600">{{ translate('Filters') }}</h3>
                                    <button type="button" class="btn btn-sm p-2 filter-sidebar-thumb" data-toggle="class-toggle" data-target=".aiz-filter-sidebar" >
                                        <i class="las la-times la-2x"></i>
                                    </button>
                                </div>
                                <div class="bg-white shadow-sm rounded mb-3">
                                    <div class="fs-15 fw-600 p-3 border-bottom">
                                        {{ translate('Categories')}}
                                    </div>
                                    <div class="p-3">
                                        <ul class="list-unstyled">
                                            @if (!isset($category_id))
                                                @foreach (\App\Models\Category::where('level', 0)->get() as $category)
                                                    <li class="mb-2 ml-2">
                                                        <a class="text-reset fs-14" href="{{ route('products.category', $category->slug) }}">{{ $category->getTranslation('name') }}</a>
                                                    </li>
                                                @endforeach
                                            @else
                                                <li class="mb-2">
                                                    <a class="text-reset fs-14 fw-600" href="{{ route('search') }}">
                                                        <i class="las la-angle-left"></i>
                                                        {{ translate('All Industries')}}
                                                    </a>
                                                </li>
                                                @if (\App\Models\Category::find($category_id)->parent_id != 0)
                                                    <li class="mb-2">
                                                        <a class="text-reset fs-14 fw-600" href="{{ route('products.category', \App\Models\Category::find(\App\Models\Category::find($category_id)->parent_id)->slug) }}">
                                                            <i class="las la-angle-left"></i>
                                                            {{ \App\Models\Category::find(\App\Models\Category::find($category_id)->parent_id)->getTranslation('name') }}
                                                        </a>
                                                    </li>
                                                @endif
                                                <li class="mb-2">
                                                    <a class="text-reset fs-14 fw-600" href="{{ route('products.category', \App\Models\Category::find($category_id)->slug) }}">
                                                        <i class="las la-angle-left"></i>
                                                        {{ \App\Models\Category::find($category_id)->getTranslation('name') }}
                                                    </a>
                                                </li>
                                                @foreach (\App\Utility\CategoryUtility::get_immediate_children_ids($category_id) as $key => $id)
                                                    <li class="ml-4 mb-2">
                                                        <a class="text-reset fs-14" href="{{ route('products.category', \App\Models\Category::find($id)->slug) }}">{{ \App\Models\Category::find($id)->getTranslation('name') }}</a>
                                                    </li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-9">
                        <div class="d-flex justify-content-between mb-3">
                            <ul class="breadcrumb bg-transparent p-0">
                                <li class="breadcrumb-item opacity-50">
                                    <a class="text-reset" href="{{ route('home') }}">{{ translate('Home')}}</a>
                                </li>
                                @if(!isset($category_id))
                                    <li class="breadcrumb-item fw-600  text-dark">
                                        <a class="text-reset" href="{{ route('search') }}">"{{ translate('All Categories')}}"</a>
                                    </li>
                                @else
                                    <li class="breadcrumb-item opacity-50">
                                        <a class="text-reset" href="{{ route('search') }}">{{ translate('All Categories')}}</a>
                                    </li>
                                @endif
                                @if(isset($category_id))
                                    <li class="text-dark fw-600 breadcrumb-item">
                                        <a class="text-reset" href="{{ route('products.category', \App\Models\Category::find($category_id)->slug) }}">"{{ \App\Models\Category::find($category_id)->getTranslation('name') }}"</a>
                                    </li>
                                @endif
                            </ul>

                            <div class="card py-1 px-2 mb-0">
                                <form action="{{ route('search') }}" method="GET" class="stop-propagation mb-0">
                                    <div class="d-flex position-relative">
                                        <div class="d-none" data-toggle="class-toggle" data-target=".front-header-search">
                                            <button class="btn px-2" type="button" aria-label="search-button"><i
                                                    class="la la-2x la-long-arrow-left"></i></button>
                                        </div>
                                        <div class="input-group">
                                            <input type="text" 
                                                class="border-0 border-lg form-control" id="search" name="q"
                                                value="{{ $query }}"
                                                placeholder="{{ translate('Search query...') }}"
                                                autocomplete="off">
                                            <div class="input-group-append d-block">
                                                <button class="btn btn-success" type="submit">
                                                    <i class="la la-search text-white la-flip-horizontal fs-18"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        @if($content == 'product' || $content == null)
                            <div>
                                <div class="text-left">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <h1 class="h6 fw-600 text-body">
                                                @if(isset($category_id))
                                                    {{ translate('Products - ') }}{{ \App\Models\Category::find($category_id)->getTranslation('name') }}
                                                @elseif(isset($query))
                                                    {{ translate('Products found matched ') }}"{{ $query }}"{{ ' : ' . $product_count }}
                                                @else
                                                    {{ translate('All Products') }}
                                                @endif
                                            </h1>
                                        </div>
                                        @if($product_count > 0 && $content == null && !isset($category_id))
                                            <div class="ml-auto text-right">
                                                <a class="font-weight-bold" href="{{ route('search', ['q' => $query, 'content' => 'product']) }}">{{ translate('View all ') }}<i
                                                        class="las la-angle-right la-sm ml-1"></i></a>                                    
                                            </div>
                                        @endif
                                        <div class="d-xl-none ml-auto ml-xl-3 mr-0 form-group align-self-end">
                                            <button type="button" class="btn btn-icon p-0" data-toggle="class-toggle" data-target=".aiz-filter-sidebar">
                                                <i class="la la-filter la-2x"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @if($product_count > 0)
                                    <div class="row gutters-5 row-cols-xxl-4 row-cols-xl-3 row-cols-lg-4 row-cols-md-3 row-cols-2 mt-2">
                                        @foreach ($products as $key => $product)
                                            <x-search.product-card :product="$product"></x-search.product-card>
                                        @endforeach           
                                    </div>
                                    @if ($content == 'product' || isset($category_id))
                                        <div class="aiz-pagination aiz-pagination-center d-flex justify-content-center mt-4">
                                            {{ $products->links() }}
                                        </div>
                                    @endif
                                @else
                                    <p class="text-center mt-2">{{ translate('Nothing found') }}</p>
                                @endif
                            </div>
                        @endif

                        @if($content == 'event' || $content == null)
                            <div class="mt-3">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <h1 class="h6 fw-600 text-body">
                                            @if(isset($category_id))
                                                {{ translate('Events - ') }} {{ \App\Models\Category::find($category_id)->getTranslation('name') }}
                                            @elseif(isset($query))
                                                {{ translate('Events found matched ') }}"{{ $query }}"{{ ' : ' . $event_count }}
                                            @else
                                                {{ translate('All Companies') }}
                                            @endif
                                        </h1>
                                    </div>
                                    @if($event_count > 0 && $content == null && !isset($category_id))
                                        <div class="ml-auto text-right">
                                            <a class="font-weight-bold" href="{{ route('search', ['q' => $query, 'content' => 'event']) }}">{{ translate('View all ') }}<i
                                                    class="las la-angle-right la-sm ml-1"></i></a>                                    
                                        </div>
                                    @endif
                                    <div class="d-xl-none ml-auto ml-xl-3 mr-0 form-group align-self-end">
                                        <button type="button" class="btn btn-icon p-0" data-toggle="class-toggle" data-target=".aiz-filter-sidebar">
                                            <i class="la la-filter la-2x"></i>
                                        </button>
                                    </div>
                                </div>
                                @if($event_count > 0)
                                    <div class="mt-2 row">
                                        @foreach ($events as $key => $event)
                                            <x-event-card :event="$event" :items="$attributes"></x-event-card>
                                        @endforeach
                                    </div>
                                    @if ($content == 'event' || isset($category_id))
                                        <div class="aiz-pagination aiz-pagination-center d-flex justify-content-center mt-4">
                                            {{ $shops->links() }}
                                        </div>
                                    @endif
                                @else
                                    <p class="text-center mt-2">{{ translate('Nothing found') }}</p>
                                @endif
                            </div>
                        @endif

                        @if($content == 'company' || $content == null)
                            <div class="mt-3">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <h1 class="h6 fw-600 text-body">
                                            @if(isset($category_id))
                                                {{ translate('Companies - ') }} {{ \App\Models\Category::find($category_id)->getTranslation('name') }}
                                            @elseif(isset($query))
                                                {{ translate('Companies found matched ') }}"{{ $query }}"{{ ' : ' . $company_count }}
                                            @else
                                                {{ translate('All Companies') }}
                                            @endif
                                        </h1>
                                    </div>
                                    @if($company_count > 0 && $content == null && !isset($category_id))
                                        <div class="ml-auto text-right">
                                            <a class="font-weight-bold" href="{{ route('search', ['q' => $query, 'content' => 'company']) }}">{{ translate('View all ') }}<i
                                                    class="las la-angle-right la-sm ml-1"></i></a>                                    
                                        </div>
                                    @endif
                                    <div class="d-xl-none ml-auto ml-xl-3 mr-0 form-group align-self-end">
                                        <button type="button" class="btn btn-icon p-0" data-toggle="class-toggle" data-target=".aiz-filter-sidebar">
                                            <i class="la la-filter la-2x"></i>
                                        </button>
                                    </div>
                                </div>
                                @if($company_count > 0)
                                    <div class="mt-2">
                                        @foreach ($shops as $key => $shop)
                                            <x-company-card :company="$shop"></x-company-card>
                                        @endforeach
                                    </div>
                                    @if ($content == 'company' || isset($category_id))
                                        <div class="aiz-pagination aiz-pagination-center d-flex justify-content-center mt-4">
                                            {{ $shops->links() }}
                                        </div>
                                    @endif
                                @else
                                    <p class="text-center mt-2">{{ translate('Nothing found') }}</p>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </section>

@endsection
