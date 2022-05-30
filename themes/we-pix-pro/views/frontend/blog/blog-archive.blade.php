@extends('frontend.layouts.app')

@section('content')
<section class="relative z-[2] mt-[-90px] lg:pt-[210px]  lg:pb-[120px]  sm:pt-[170px]  sm:pb-[80px]  pt-[130px]  pb-[50px]   bg-[#f5f5f5]   ">
    <div class="absolute top-0 bottom-0 left-0 right-0 flex justify-end z-[-1]">
        @include('svg.bkgs.hero-shapes')
    </div>

    <div class="mx-auto max-w-7xl px-4">
        <div class="text-center">
            <div we-slot="" name="title_slot" we-title="Section Title" class="w-full mb-4">
                <h1 we-name="section_title" we-title="Title" class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl ">
                    {{ translate('Pix-Pro Blogs') }}
                </h1>
            </div>
            <div we-slot="" name="text_slot" we-title="Section Text" class="w-full ">
                <span we-name="section_text" we-title="Text" class="block mt-3 max-w-md mx-auto text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl ">
                    {{ translate('Nam libero tempore, cum soluta nobis est option cumque nihil ') }}
                </span>
            </div>
        </div>
    </div>
</section>

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

