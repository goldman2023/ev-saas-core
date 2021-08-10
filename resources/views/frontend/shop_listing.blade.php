@extends('frontend.layouts.app')

@php
$banner1 = App\Models\AffiliateBanner::find(1);
$banner2 = App\Models\AffiliateBanner::find(4);
$banner3 = App\Models\AffiliateBanner::find(3);

if (empty($banner2->refer_url)) {
    $banner2 = $banner1;
}

if (empty($banner3->refer_url)) {
    $banner3 = $banner1;
}

@endphp

@section('content')
    <section id="archive-hero">
        <x-companies-archive-hero :categoryId="$category_id"></x-companies-archive-hero>
    </section>
    <section>
        <div class="container">


            {{-- Filtering mobile end --}}
            <div class="col-lg-12">
                <ul class="breadcrumb bg-transparent p-0 justify-content-start justify-content-lg-end">
                    <li class="breadcrumb-item opacity-50">
                        <a class="text-reset" href="{{ route('home') }}">
                            {{ translate('Home') }}
                        </a>
                    </li>
                    @if (!isset($category_id))
                        <li class="breadcrumb-item fw-600  text-dark">
                            <a class="text-reset" href="{{ route('search') }}">"{{ translate('All Industries') }}"</a>
                        </li>
                    @else
                        <li class="breadcrumb-item opacity-50">
                            <a class="text-reset" href="{{ route('search') }}">{{ translate('All Industries') }}</a>
                        </li>
                    @endif
                    @if (isset($category_id))
                        <li class="text-dark fw-600 breadcrumb-item">
                            <a class="text-reset"
                                href="{{ route('products.category', \App\Models\Category::find($category_id)->slug) }}">"{{ \App\Models\Category::find($category_id)->getTranslation('name') }}"</a>
                        </li>
                    @endif
                </ul>
            </div>

    </section>
    <section class="mb-2">
        <div class="container">
            <form class="" id="search-form" action="" method="GET">
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

                                <x-categories-sidebar :categoryId="$category_id" type="companies"></x-categories-sidebar>

                                <x-company-attributes :items="$attributes" :selected="$filters"></x-company-attributes>

                                <div class="mb-3 mt-3">
                                    {{-- <x-affiliate-single-banner :banner="$banner2"> </x-affiliate-single-banner> --}}
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-xl-9">
                        <div class="mb-3">
                            <x-affiliate-single-banner :banner="$banner1"> </x-affiliate-single-banner>
                        </div>
                        @if (count($shops) > 0)
                            @foreach ($shops as $key => $shop)
                                @if ($key === 5)
                                    <div class="row mb-3">

                                        <div class="col-sm-4">
                                            <x-affiliate-single-banner :banner="$banner1"></x-affiliate-single-banner>

                                        </div>

                                        <div class="col-sm-4">
                                            <x-affiliate-single-banner :banner="$banner2"></x-affiliate-single-banner>
                                        </div>
                                        <div class="col-sm-4">
                                            <x-affiliate-single-banner :banner="$banner3"></x-affiliate-single-banner>

                                        </div>
                                    </div>

                                @endif
                                <x-company-card :company="$shop"></x-company-card>
                            @endforeach
                        @else
                            <x-empty-state-company-archive> </x-empty-state-company-archive>
                        @endif

                        <div class="aiz-pagination aiz-pagination-center d-flex justify-content-center my-4">
                            {{ $shops->links() }}
                        </div>

                        {{-- <x-affiliate-banner></x-affiliate-banner> --}}
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

<script type="text/javascript">
    function filter() {
        $('#search-form').submit();
    }

    function rangefilter(arg, element) {
        var attribute_id = element.getAttribute("data-attribute-id");
        $('input[name="attribute_' + attribute_id + '[]"]').first().val(arg[0]);
        $('input[name="attribute_' + attribute_id + '[]"]').last().val(arg[1]);
        filter();
    }

</script>
