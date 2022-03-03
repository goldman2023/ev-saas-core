@push('head_scripts')
<script>
    $(function() {
        
    });
    </script>
@endpush
<div class="p-available-sections min-h-full w-full flex flex-col h-[calc(100vh_-_64px)]" 
        x-data="{
            swiper() {
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
            }
        }"
        @initAvailableSectionsPanel.window="this.swiper()"
        x-init="swiper()"
        wire:ignore
>
<div class="w-full bg-white px-4 py-3">
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
            @foreach($available_sections as $key => $theme)
                @php
                    $marketing = $theme['sections']['marketing'] ?? [];
                @endphp
                @foreach($marketing as $key => $group)
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
                                        @foreach($group['sections'] as $id => $section)
                                            <div class="swiper-slide rounded border flex flex-col cursor-pointer relative px-2 py-2">
                                                <div class="absolute inset-0 bg-cover bg-center z-1 rounded w-full h-full flex justify-center items-center bg-stone-800 opacity-0 hover:opacity-100 bg-opacity-80 duration-300">
                                                    <button type="button" class="cursor-pointer text-14 rounded text-white bg-sky-600 px-3 py-2"
                                                            @click="$wire.addSectionToPreview('{{ $section['id'] ?? '' }}')">
                                                        {{ translate('Add to page') }}
                                                    </button>
                                                </div>

                                                <img class="rounded h-[80px] object-cover mb-2" src="{{ $section['thumbnail'] ?? '' }}" />
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
            @endforeach
        @endif
    </div>
</div>
    
</div>