<section class="relative z-[2]  mt-[-90px] lg:pt-[110px]  lg:pb-[60px]  sm:pt-[110px]  sm:pb-[40px]  pt-[60px]  pb-[30px]   bg-[#f5f5f5]   ">
    <div class="absolute z-[-1] top-0 bottom-0 left-0 right-0 flex justify-end overflow-y-hidden">
        @include('svg.bkgs.hero-shapes')
    </div>

    <div class="mx-auto max-w-7xl px-4">
        <div class="text-center">
            <div we-slot="" name="title_slot" we-title="Section Title" class="w-full mb-4">
                <h1 we-name="section_title" we-title="Title" class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl ">
                    {{ $header_title ?? '' }}
                </h1>
            </div>
            @if(!empty($header_subtitle ?? null))
                <div we-slot="" name="text_slot" we-title="Section Text" class="w-full ">
                    <span we-name="section_text" we-title="Text" class="block mt-3 max-w-md mx-auto text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl ">
                        {{ $header_subtitle ?? '' }}
                    </span>
                </div>
            @endif
        </div>
    </div>
</section>
