@push('head_scripts')
<script>
    $(function() {
        const swiper = new Swiper('.p-available-sections .swiper', {
            // Optional parameters
            direction: 'horizontal',
            loop: false,
            pagination: false,
            scrollbar: false,
            slidesPerView: 2.2,
            spaceBetween: 15,
    
            // Navigation arrows
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    });
    </script>
@endpush
<div class="p-available-sections min-h-full w-full flex flex-col bg-white px-4 py-3">
    <div class="w-full">
        <div class="mt-1 relative flex items-center">
          <input type="text" name="search" id="search" placeholder="Search for a section" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full pr-12 sm:text-sm border-gray-300 rounded-md">
          <div class="absolute inset-y-0 right-0 flex py-1.5 pr-1.5">
            <kbd class="inline-flex items-center border border-gray-200 rounded px-2 text-sm font-sans font-medium text-gray-400 cursor-pointer">
                @svg('lineawesome-search-solid', ['class' => 'w-[20px] h-[20px]'])
            </kbd>
          </div>
        </div>
    </div>

    <div class="w-full mt-4">
        @if(!empty($available_sections)) 
            @foreach($available_sections as $group)
                <div class="w-100 mb-4">
                    <div class="flex justify-between items-center">
                        <strong>{{ $group['title'] }}</strong>
                        <span class="text-12 hover:underline hover:text-gray-600 cursor-pointer">{{ translate('See all') }}</span>
                    </div>

                    <div class="w-full mt-3">
                        <!-- Slider main container -->
                        <div class="swiper h-[130px]">
                            <!-- Additional required wrapper -->
                            <div class="swiper-wrapper">
                                <!-- Slides -->
                                @if(!empty($group['sections'])) 
                                    @foreach($group['sections'] as $section)
                                        <div class="swiper-slide flex flex-col cursor-pointer">
                                            <img class="rounded max-h-[100px] object-cover mb-2" src="{{ $section['thumbnail'] ?? '' }}" />
                                            <span class="text-14 line-clamp-1">{{ $section['title'] ?? '' }}</span>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        
                            <!-- If we need navigation buttons -->
                            <div class="swiper-button-prev g-transparent h-full top-0 mt-0 left-0"></div>
                            <div class="swiper-button-next bg-transparent h-full top-0 mt-0 right-0"></div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>