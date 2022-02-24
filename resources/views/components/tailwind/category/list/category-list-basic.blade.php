<div class="relative col-span-full lg:col-span-2 grid grid-cols-1 gap-3 justify-between">
    <div
        class="cat-mobile-carousel overflow-hidden cat-mobile-carousel-6bb600e5 combined_block_category swiper-container-initialized swiper-container-horizontal">
        <div id="cat-mobile-carousel" class="col-span-full lg:col-span-2 grid grid-cols-1 gap-3 justify-between h-full">

            @foreach ($categories as $category)
            <a class="category_block_item flex justify-between items-center bg-gray-200 rounded-md px-3 md:px3.5 lg:px-3 xl:px-2.5 2xl:px-3.5 py-2 md:py-3 lg:py-2 xl:py-3 2xl:py-2.5 3xl:py-3.5 transition hover:bg-gray-100"
                href="{{ $category->getPermalink() }}">
                <div class="flex items-center">
                    <div
                        class="bg-gray-300 inline-flex items-center flex-shrink-0 rounded-full 2xl:w-12 2xl:h-12 3xl:w-auto 3xl:h-auto">
                        @php
                        $category_product_image = $category
                        ->products()
                        ->latest('id')
                        ->first();
                        @endphp

                        @if($category_product_image)
                        <x-tenant.system.image
                            class="w-14 md:w-16 lg:w-12 2xl:w-16 transition-opacity duration-500"
                            :image="$category_product_image->getThumbnail()">
                        </x-tenant.system.image>
                        @else
                        <x-tenant.system.image
                            class="w-14 md:w-16 lg:w-12 2xl:w-16 transition-opacity duration-500"
                            :image="$category->getThumbnail()">
                        </x-tenant.system.image>


                        @endif

                    </div>
                    <h3
                        class="category_name font-normal mb-0 text-sm md:text-base 2xl:text-sm 3xl:text-base text-heading capitalize pl-2.5 md:pl-4 2xl:pl-3 3xl:pl-4">
                        {{ $category->getTranslation('name') }}
                    </h3>
                </div>
                <div class="flex items-center">
                    <div
                        class="text-xs font-medium w-5 h-5 flex flex-shrink-0 justify-center items-center bg-gray-350 rounded mr-2">
                        {{ $category->products()->count() }}
                    </div>

                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512"
                        class="text-sm text-heading" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M294.1 256L167 129c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.3 34 0L345 239c9.1 9.1 9.3 23.7.7 33.1L201.1 417c-4.7 4.7-10.9 7-17 7s-12.3-2.3-17-7c-9.4-9.4-9.4-24.6 0-33.9l127-127.1z">
                        </path>
                    </svg>
                </div>
            </a>

            @endforeach

        </div>
    </div>
</div>
