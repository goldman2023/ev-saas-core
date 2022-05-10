@extends('frontend.layouts.' . $globalLayout)

@section('meta_title', $blog_post->name)

@section('meta')
{{-- <x-default.products.single.head-meta-tags :product="$product"></x-default.products.single.head-meta-tags> --}}
@endsection

@section('content')
<section class="relative  lg:pt-[120px]  lg:pb-[120px]  sm:pt-[90px]  sm:pb-[90px]  pt-[50px]  pb-[50px]   bg-[#f5f5f5]   ">
    <div class="mx-auto max-w-4xl px-8 sm:px-4">
        <div class="text-center">
            <div we-slot="" name="title_slot" we-title="Section Title" class="w-full mb-6">
                <h1 we-name="section_title" we-title="Title" class="text-4xl tracking-tight font-extrabold text-typ-1 sm:text-[32px]] ">
                    {{ $blog_post->name }}
                </h1>
            </div>
            
            <div class="w-full flex flex-col sm:flex-row justify-center items-center">
                <div class="flex items-center mb-3 sm:mb-0 mr-0 sm:mr-10">
                    <img src="{{ $authors->first()->getThumbnail(['w' => 100]) }}" class="rounded-full object-cover w-8 h-8 mr-2.5" />
                    <span class="text-14 text-700 line-clamp-1 text-typ-2">{{ $authors->first()->name.' '.$authors->first()->surname }}</span>
                </div>
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
        
        <div class="grid grid-cols-12 gap-8">
            <div class="col-span-8 flex flex-col">
                <div class="w-full aspect-square inline-flex items-center justify-center rounded-md mb-10">
                    <img src="{{ $blog_post->getThumbnail(['w' => 1000]) }}" alt="" class="w-full object-contain">
                </div>

                <div class="w-full block pb-5 mb-[30px] border-b border-gray-300">
                    {!! $blog_post->content !!}
                </div>

                <div class="w-full block pb-5">
                    <strong class="block text-24 font-bold mb-[24px] text-typ-2">{{ translate('About the author') }}</strong>

                    <div class="w-full border-lg border-primary bg-primary-light p-6 sm:p-[30px]">
                        <div class="w-full flex items-start">
                            <img src="{{ $authors->first()->getThumbnail(['w' => 200]) }}" alt="" class="w-[100px] h-[100px] object-cover rounded-full mr-[30px] sm:mr-6">

                            <div class="w-full flex-col">
                                <strong class="text-18 sm:text-20 text-typ-2">
                                    {{ $authors->first()->name.' '.$authors->first()->surname }}
                                </strong>

                                <p class="text-16 text-typ-3">
                                    {{ $authors->first()->getUserMeta('short_about_me') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-4">
                {{-- <div class="w-full">

                </div> --}}
            </div>
        </div>
    </div>
</section>


{{-- TODO: Create Related Blog Posts --}}
<section class="bg-[#F5F5F5] py-[40px] sm:py-[50px] md:py-[80px]">
    <div class="container !max-w-[90%]">
        <div class=" text-center">
          <div we-slot="" name="tagline_slot" we-title="Tagline" class="w-full">
              <h3 we-name="tagline" we-title="Title" class="text-18 font-semibold tracking-wider text-primary uppercase mb-2">
                  {{ translate('Releted Blog Posts') }}
              </h3>
          </div>
            <h2 class="text-28 md:text-[48px] font-black leading-[28px] md:leading-[48px] text-gray-900 mb-3">{{ translate('Our Related Posts') }}</h2>
            <p class="text-18 text-gray-600">{{ translate('All of our tools and technologies are designed, modiefied and updated keeping your needs in mind') }}</p>
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

<section class="relative  lg:pt-[70px]  lg:pb-[80px]  sm:pt-[50px]  sm:pb-[50px]  pt-[40px]  pb-[40px]   bg-[#8BC53F]   ">
    <div class="w-full">
        <div class="container !max-w-[90%] sm:!max-w-2xl">
            <div class="action-content text-center">  
                <div we-slot="" name="title_slot" we-title="Section Title" class="w-full mb-4">
                    <h2 we-name="section_title" we-title="Title" class="text-[48px] font-black leading-none mb-5 text-white">
                        {{ translate('Ready to get started with your project?') }}
                    </h2>
                </div>
        
                <div we-slot="" name="text_slot" we-title="Section Text" class="w-full mb-8">
                    <p we-name="section_text" we-title="Text" class="text-20 font-medium text-white">
                        {{ translate('Choose from our 3 different plans or ask for a custom solution where you can process as many photos as you can!') }}
                    </p>
                </div>
        
                <div we-slot="" name="button_group_slot" we-title="Buttons" class="w-full">
                    <div class="mb-5 max-w-md mx-auto sm:flex sm:justify-center md:mt-8 ">
                            <div class="rounded-md shadow ">
                                <a href="{{ route('custom-pages.show_custom_page', 'plans-pricing') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary hover:bg-primary md:py-4 md:text-lg md:px-10 !text-gray-900 !bg-white" target="_self"> 
                                    {{ translate('Get started free') }}
                                </a>
                            </div>
                    </div>            
                </div>
                
                <div we-slot="" name="info_slot" we-title="Section Info Text" class="w-full ">
                    <p we-name="section_info" we-title="Text" class="text-20 font-medium text-gray-900 text-white">
                        {{ translate('Start free 1 month trial now, cancel at any time') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
