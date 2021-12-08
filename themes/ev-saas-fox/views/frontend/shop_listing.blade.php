@extends('frontend.layouts.app')

@section('content')
    <section id="archive-hero">
        <!-- Hero Section -->
<div class="bg-img-hero-center bg-primary" style="background-image: url(https://htmlstream.com/preview/front-v3.1.1/assets/img/1920x800/img8.jpg);">
    <div class="container space-1 space-lg-1">
      <div class="w-md-65 w-lg-35">
        <div class="mb-4">
          <h2 class="h1 text-white">Wear your pride</h2>
          <p class="text-white">Outdo the sun and refresh your workout with greys, whites and dark brights.</p>
        </div>
        <a class="btn btn-light btn-pill transition-3d-hover px-5" href="#">Shop the Collection</a>
      </div>
    </div>
  </div>
  <!-- End Hero Section -->
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
                            <a class="text-reset" href="{{ route('search') }}">"{{ translate('All Categories') }}"</a>
                        </li>
                    @else
                        <li class="breadcrumb-item opacity-50">
                            <a class="text-reset" href="{{ route('search') }}">{{ translate('All Categories') }}</a>
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

                                <x-company.company-attributes :items="$attributes" :selected="$filters"></x-company.company-attributes>

                                <div class="mb-3 mt-3">
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-xl-9">
                        <div class="mb-3">
                        </div>
                        @if (count($shops) > 0)
                        <div class="row">
                            @foreach ($shops as $key => $shop)
                            <div class="col-4">
                                <x-company.company-card :company="$shop"></x-company.company-card>

                            </div>
                        @endforeach
                        </div>

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


