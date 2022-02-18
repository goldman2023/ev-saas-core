@extends('frontend.layouts.app')

@section('content')

<section class="mb-4">
    <div class="bg-dark text-white">
        <x-default.blog.newsletter-hero></x-default.blog.newsletter-hero>

    </div>
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
    {{-- <x-affiliate-banner></x-affiliate-banner>--}}
</div>

<section class="pb-4">
    <div class="container">
        <div class="row mb-5">
            <div class="col-6">
                <h2 class="h3 mb-0">{{ translate('Latest news') }}</h2>
            </div>
            <div class="col-6 text-right">

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

                <div class="aiz-pagination aiz-pagination-center mt-4">
                    {{ $blogs->links() }}
                </div>
            </div>

            <div class="col-lg-4">
                <div id="stickyBlockStartPoint" style=""></div>
                <div class="js-sticky-block" data-hs-sticky-block-options="{
                    &quot;parentSelector&quot;: &quot;#stickyBlockStartPoint&quot;,
                    &quot;breakpoint&quot;: &quot;lg&quot;,
                    &quot;startPoint&quot;: &quot;#stickyBlockStartPoint&quot;,
                    &quot;endPoint&quot;: &quot;#stickyBlockEndPoint&quot;,
                    &quot;stickyOffsetTop&quot;: 24,
                    &quot;stickyOffsetBottom&quot;: 24
                  }" style="">
                    <div class="mb-7">
                        <div class="mb-3">
                            <h3>{{ translate('Recently Viewed Products') }}</h3>
                        </div>

                        <x-default.products.recently-viewed-products style="list" columns="12"></x-default.products.recently-viewed-products>

                    </div>

                    <div class="mb-7">
                        <div class="mb-3">
                            <h3>Tags</h3>
                        </div>

                        <a class="btn btn-xs btn-soft-secondary mb-1" href="#">Business</a>
                        <a class="btn btn-xs btn-soft-secondary mb-1" href="#">Adventure</a>
                        <a class="btn btn-xs btn-soft-secondary mb-1" href="#">Community</a>
                        <a class="btn btn-xs btn-soft-secondary mb-1" href="#">Announcements</a>
                        <a class="btn btn-xs btn-soft-secondary mb-1" href="#">Tutorials</a>
                        <a class="btn btn-xs btn-soft-secondary mb-1" href="#">Resources</a>
                        <a class="btn btn-xs btn-soft-secondary mb-1" href="#">Classic</a>
                        <a class="btn btn-xs btn-soft-secondary mb-1" href="#">Photography</a>
                        <a class="btn btn-xs btn-soft-secondary mb-1" href="#">Interview</a>
                    </div>
                </div>
            </div>
        </div>




    </div>


</section>
@endsection
