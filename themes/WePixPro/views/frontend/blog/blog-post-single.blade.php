@extends('frontend.layouts.' . $globalLayout)

@section('meta_title'){{ $blog_post->getPageMeta()['title'] }} | {{ get_site_name() }}@stop

@section('meta_description'){{ $blog_post->getPageMeta()['description'] }}@stop
@section('meta')
<meta property="og:title" content="{{ $blog_post->getPageMeta()['title'] }}" />
<meta property="og:type" content="article" />
<meta property="og:locale" content="en_US" />
<meta property="og:url" content="{{  url()->current() }}"/>
<meta property="og:article:author" content="article" />
<meta property="og:article:published_time" content="{{ $blog_post->created_at }}" />
<meta property="og:article:modified_time" content="{{ $blog_post->updated_at }}" />
<meta property="og:image" content="{{ $blog_post->getPageMeta()['image'] }}" />
<meta property="og:description" content="{{ $blog_post->getPageMeta()['description'] }}" />
<meta property="og:site_name" content="{{ get_site_name() }}" />
@endsection

@push('head_scripts')
    <link rel="preload" as="image" href="{{ $blog_post->getThumbnail(['w' => 1000]) }}" />

@endpush

@push('footer_scripts')
<link href="{{ static_asset('/bp-assets/vendor/image-compare-viewer.min.css') }}" rel="stylesheet" />
<link href="{{ static_asset('/bp-assets/vendor/fancybox/fancybox.css') }}" rel="stylesheet" />
<script src="{{ static_asset('/bp-assets/vendor/image-compare-viewer.min.js') }}" defer></script>
<script src="{{ static_asset('/bp-assets/vendor/fancybox/fancybox.js') }}" defer async></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {

        const viewers = document.querySelectorAll(".icgb-compare-block");

        viewers.forEach((element) => {
        let view = new ImageCompare(element).mount();


    });
}, false);
</script>
@endpush

@section('content')
{{-- {{ Breadcrumbs::render('blog', $blog_post) }} --}}

<section
    class="relative  lg:pt-[60px]  lg:pb-[30px]  sm:pt-[60px]  sm:pb-[60px]  pt-[40px]  pb-[40px]   bg-[#f5f5f5]   ">

    <div class="mx-auto max-w-4xl px-8 sm:px-4">
        <div class="text-center">
            <div we-slot="" name="title_slot" we-title="Section Title" class="w-full mb-6">
                <h1 we-name="section_title" we-title="Title"
                    class="text-4xl tracking-tight font-extrabold text-typ-1 sm:text-[32px]] ">
                    {{ $blog_post->name }}
                </h1>
            </div>

            <div class="w-full flex flex-col sm:flex-row justify-center items-center mb-6">
                @if(!empty($authors?->first()))
                <div class="flex items-center mb-3 sm:mb-0 mr-0 sm:mr-10">
                    <img src="{{ $authors?->first()?->getThumbnail(['w' => 100]) ?? '' }}"
                    alt="{{ get_site_name() }} Team"
                        class="border-full border-gray-200 rounded-full object-cover w-8 h-8 mr-2.5" />
                    <span class="text-14 text-700 line-clamp-1 text-typ-2">{{ ($authors?->first()?->name ?? '').'
                        '.($authors->first()?->surname ?? '') }}</span>
                </div>
                @endif
                <div class="flex items-center justify-end md:justify-center text-typ-2">
                    @svg('heroicon-o-calendar', ['class' => 'w-4 h-4 mr-2'])
                    <span class="text-14">{{ $blog_post->created_at->format('M d, Y') }}</span>
                </div>


            </div>
        </div>
    </div>
</section>

<section class="relative  lg:pt-[80px]  lg:pb-[80px]  sm:pt-[50px]  sm:pb-[50px]  pt-[30px]  pb-[30px]  bg-white   ">
    <div class="mx-auto max-w-6xl px-8 sm:px-4">

        <div class="grid grid-cols-12 sm:gap-8">
            <div class="col-span-12 flex flex-col">
                <div class="w-full aspect-square inline-flex items-center justify-center rounded-md mb-10">
                    <img width="1000px" height="375px" src="{{ $blog_post->getThumbnail(['w' => 1000]) }}" alt="{{ $blog_post->name }} article image" class="w-full object-contain">
                </div>

                <div id="blog_post_single_content" class="w-full block pb-5 mb-[15px]">
                    {{-- {!! $blog_post->content !!} --}}
                    {{-- TODO: Add replaced img tags and optimized html structure --}}
                    {!! $html !!}
                </div>

                <x-blog.social-sharing-buttons> </x-blog.social-sharing-buttons>

                @if(!empty($authors?->first()))
                {{-- <div class="w-full block pb-5">
                    <strong class="block text-24 font-bold mb-[24px] text-typ-2">{{ translate('About the author')
                        }}</strong>

                    <div class="w-full border-lg border-primary bg-primary-light p-6 sm:p-[30px]">
                        <div class="w-full flex items-start">
                            <img src="{{ $authors?->first()?->getThumbnail(['w' => 100]) ?? '' }}" alt=""
                                class="w-[100px] h-[100px] object-cover rounded-full mr-[30px] sm:mr-6">

                            <div class="w-full flex-col">
                                <strong class="text-18 sm:text-20 text-typ-2">
                                    {{ ($authors?->first()?->name ?? '').' '.($authors->first()?->surname ?? '') }}
                                </strong>

                                <p class="text-16 text-typ-3">
                                    {{ $authors?->first()?->getUserMeta('short_about_me') ?? '' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div> --}}
                @endif

            </div>
            {{-- <div class="col-span-4">
                <div class="w-full">

                </div>
            </div> --}}
        </div>
    </div>
</section>


<section class="bg-[#F5F5F5] py-[40px] sm:py-[50px] md:py-[80px]">
    <div class="container !max-w-[90%]">
        <div class=" text-center">
            <div we-slot="" name="tagline_slot" we-title="Tagline" class="w-full">
                <h3 we-name="tagline" we-title="Title"
                    class="text-18 font-semibold tracking-wider text-primary uppercase mb-2">
                    {{ translate('Releted Blog Posts') }}
                </h3>
            </div>
            <h2 class="text-28 md:text-[48px] font-black leading-[28px] md:leading-[48px] text-gray-900 mb-3">{{
                translate('Our Related Posts') }}</h2>
            <p class="text-18 text-gray-600">{{ translate('All of our tools and technologies are designed, modified and
                updated keeping your needs in mind') }}</p>
        </div>
        <div class="client-content pt-10 grid grid-cols-1 lg:grid-cols-3 gap-7">
            @if($related_blog_posts->isNotEmpty())
            @foreach($related_blog_posts as $blog_post)
            <x-tailwind-ui.blog.blog-post-card :blog-post="$blog_post" />
            @endforeach
            @endif
        </div>
    </div>
</section>

@include('components.custom.full-width-cta')


@endsection
