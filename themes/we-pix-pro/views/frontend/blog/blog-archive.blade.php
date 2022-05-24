@extends('frontend.layouts.app')

@section('content')
<section class="relative  lg:pt-[120px]  lg:pb-[120px]  sm:pt-[90px]  sm:pb-[90px]  pt-[50px]  pb-[50px]   bg-[#f5f5f5]   ">
    <div class="mx-auto max-w-7xl px-4">
        <div class="text-center">
            <div we-slot="" name="title_slot" we-title="Section Title" class="w-full mb-4">
                <h1 we-name="section_title" we-title="Title" class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl ">
                    {{ translate('Pix-Pro Blogs') }}
                </h1>
            </div>
            
            <div we-slot="" name="text_slot" we-title="Section Text" class="w-full ">
                <p we-name="section_text" we-title="Text" class="block mt-3 max-w-md mx-auto text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl ">
                    {{ translate('Nam libero tempore, cum soluta nobis est option cumque nihil ') }}
                </p>
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
