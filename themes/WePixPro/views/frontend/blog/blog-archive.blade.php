@extends('frontend.layouts.app')
@section('meta_title')
@isset($category)
{{ $category->name }} | {{ get_site_name() }}@stop

@else
{{ translate('Pixpro photogrammetry blog') }} | {{ get_site_name() }}@stop


@endisset

@section('meta_description')
{{ translate('Our photogrammetry blog dives into photogrammetric 3D scanning techniques, photo capturing nuances, comparisons and explores new use cases') }}
@stop
@section('meta')
<meta property="og:title" content="{{ translate('Pixpro photogrammetry blog') }} | {{ get_site_name() }}" />
<meta property="og:type" content="article" />
<meta property="og:locale" content="en_US" />
<meta property="og:image" content="{{ get_tenant_setting('og_image') }}" />
<meta property="og:description" content="{{ translate('Our photogrammetry blog dives into photogrammetric 3D scanning techniques, photo capturing nuances, comparisons and explores new use cases') }}" />
<meta property="og:site_name" content="{{ get_site_name() }}" />
@endsection
@section('content')

<section class="overflow-hidden relative z-[2]  mt-[-90px] lg:pt-[110px]  lg:pb-[60px]  sm:pt-[110px]  sm:pb-[40px]  pt-[120px]  pb-[40px]  bg-[#f5f5f5]">
    <div class="absolute top-0 bottom-0 left-0 right-0 flex justify-end z-[-1]">
        @include('svg.bkgs.hero-shapes')
    </div>

    <div class="mx-auto max-w-7xl px-4">
        <div class="text-center">
            <div we-slot="" name="title_slot" we-title="Section Title" class="w-full mb-4">
                <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl ">
                @isset($category)
                {{ $category->name }}

                @else
                {{ translate('Pixpro Blog') }}
                @endisset
            </h1>

            </div>
            @isset($category)
            <div we-slot="" name="text_slot" we-title="Section Text" class="w-full ">
                <span class="block mt-3 max-w-md mx-auto text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl ">
                   {!! $category->description !!}
                </span>
            </div>
            @endisset
        </div>
    </div>
</section>
@empty($category)
    @php
        $category = null;
    @endphp
@endempty
<x-blog.categories-list :category="$category"></x-blog.categories-list>

<section class="relative bg-white py-16  lg:pt-[80px]  lg:pb-[80px]  sm:pt-[60px]  sm:pb-[60px]  pt-[40px]  pb-[40px]">
    <div class="mx-auto max-w-md px-4 text-center sm:max-w-3xl sm:px-6 lg:max-w-7xl lg:px-8">
        <div class="grid gap-8 grid-cols-1 md:grid-cols-2 lg:grid-cols-3 @if($blog_posts->hasPages()) mb-8 @endif">
            @if($blog_posts->isNotEmpty())
                @foreach($blog_posts as $blog_post)
                    <x-tailwind-ui.blog.blog-post-card :blog-post="$blog_post" />
                @endforeach
            @endif
        </div>

        @if($blog_posts->hasPages())
            <div class="w-full">
                {{ $blog_posts->onEachSide(3)->links('pagination::tailwind') }}
            </div>
        @endif
    </div>
</section>

@include('components.custom.full-width-cta')

@endsection

