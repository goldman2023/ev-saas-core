@extends('frontend.layouts.app')

@section('content')

    <section class="pt-4 mb-4">
        <div class="container text-center">
            <div class="row">
                <div class="col-lg-12 text-center text-lg-left">
                    <!-- Title -->
                    <div class="w-md-80 w-lg-50 text-center mx-md-auto mb-5 mb-md-9 mt-10">
                        <x-ev.label tag="h2" class="h1" :label="ev_dynamic_translate('Blog Title')"></x-ev.label>
                        <p>
                            <x-ev.label :label="ev_dynamic_translate('Blog Description')"></x-ev.label>
                        </p>
                    </div>
                    <!-- End Title -->
                </div>
                <div class="col-lg-12 d-none">
                    <ul class="breadcrumb bg-transparent p-0 justify-content-center justify-content-lg-end">
                        <li class="breadcrumb-item opacity-50">
                            <a class="text-reset" href="{{ route('home') }}">
                                {{ translate('Home') }}
                            </a>
                        </li>
                        <li class="text-dark fw-600 breadcrumb-item">
                            <a class="text-reset" href="{{ route('news') }}">
                                "{{ translate('Blog') }}"
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <div class="text-center">
        {{--      <x-affiliate-banner></x-affiliate-banner>--}}
    </div>

    <section class="pb-4">
        <div class="container">
            <div class="row mb-5">
                <div class="col-6">
                    <h2 class="h3 mb-0">{{ translate('Latest news') }}</h2>
                </div>
                <div class="col-6 text-right">
                    <a class="font-weight-bold" href="{{ route('news') }}">{{ translate('View all ') }}<i
                            class="las la-angle-right la-sm ml-1"></i></a>
                </div>
            </div>
            <div class="row justify-content-lg-between">
                <div class="col-lg-8">
                @foreach ($blogs as $item)
                    <div class="col-sm-12 mb-3">
                        {{-- <x-news-card :item="$item"></x-news-card> --}}
                        <x-default.blog.single.card :item="$item"></x-default.blog.single.card>
                    </div>
                @endforeach
                </div>
            </div>

            <div class="aiz-pagination aiz-pagination-center mt-4">
                {{ $blogs->links() }}
            </div>


        </div>


    </section>
@endsection
