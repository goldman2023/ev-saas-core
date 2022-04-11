<div class="bg-white">
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">{{ translate('Products, courses, consulting')
            }}</h1>
        <p class="mt-4 max-w-xl text-sm text-gray-700">
            {{ translate('Browse all products, courses, and services from our members') }}
        </p>
    </div>

    <!-- Filters -->
    <section aria-labelledby="filter-heading" class="overflow-hidden relative z-10 border-t border-b border-gray-200 grid items-center"
        x-data="{
        open: false,
        active_filters_count: 0,
    }">
        <h2 id="filter-heading" class="sr-only">{{ translate('Categories Selected') }}</h2>
        <div class="relative col-start-1 row-start-1 py-4">
            <div class="max-w-7xl mx-auto flex space-x-6 divide-x divide-gray-200 text-sm px-4 sm:px-6 lg:px-8">
                <div>
                    <button @click="open = !open" type="button"
                        class="group text-gray-700 font-medium flex items-center" aria-controls="disclosure-1"
                        aria-expanded="false">
                        @svg('heroicon-s-filter', ['class' => 'flex-none w-5 h-5 mr-2 text-gray-400
                        group-hover:text-gray-500'])
                        <span x-text="active_filters_count == 0 ? 'All' : active_filters_count"></span><span class="pl-1">
                            {{ translate(' Categories') }}
                        </span>
                    </button>
                </div>
                <div class="pl-6">
                    <button type="button" class="text-gray-500">{{ translate('Clear all') }}</button>
                </div>
            </div>
        </div>
        <div class="border-t border-gray-200 py-6 w-full" style="overflow:scroll" id="disclosure-1" x-show="open" x-cloak>
            <div class="max-w-7xl mx-auto flex overflow-scroll gap-x-4 px-4 text-sm sm:px-6 md:gap-x-6 lg:px-8">
                @foreach(Category::getAll() as $category)
                <div class="-m-1 flex flex-wrap items-center">
                    <span
                    {{-- :wire:click="add_filter_category($category->id)" --}}
                        class="whitespace-nowrap min-w-[50px] nowrap m-1 inline-flex rounded-full border border-gray-200 items-center py-1.5 pl-3 pr-2 text-sm font-medium bg-white text-gray-900">
                        <span>{{ $category->name }}</span>
                        <button type="button"
                            class="flex-shrink-0 ml-1 h-4 w-4 p-1 rounded-full inline-flex text-gray-400 hover:bg-gray-200 hover:text-gray-500">
                            <span class="sr-only">Remove filter for Objects</span>
                            <svg class="h-2 w-2" stroke="currentColor" fill="none" viewBox="0 0 8 8">
                                <path stroke-linecap="round" stroke-width="1.5" d="M1 1l6 6m0-6L1 7"></path>
                            </svg>
                        </button>
                    </span>

                </div>

                @endforeach
                {{-- <div class="grid grid-cols-1 gap-y-10 auto-rows-min md:grid-cols-2 md:gap-x-6">
                    <fieldset>
                        <legend class="block font-medium">Price</legend>
                        <div class="pt-6 space-y-6 sm:pt-4 sm:space-y-4">
                            <div class="flex items-center text-base sm:text-sm">
                                <input id="price-0" name="price[]" value="0" type="checkbox"
                                    class="flex-shrink-0 h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                <label for="price-0" class="ml-3 min-w-0 flex-1 text-gray-600"> $0 - $25 </label>
                            </div>

                            <div class="flex items-center text-base sm:text-sm">
                                <input id="price-1" name="price[]" value="25" type="checkbox"
                                    class="flex-shrink-0 h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                <label for="price-1" class="ml-3 min-w-0 flex-1 text-gray-600"> $25 - $50 </label>
                            </div>

                            <div class="flex items-center text-base sm:text-sm">
                                <input id="price-2" name="price[]" value="50" type="checkbox"
                                    class="flex-shrink-0 h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                <label for="price-2" class="ml-3 min-w-0 flex-1 text-gray-600"> $50 - $75 </label>
                            </div>

                            <div class="flex items-center text-base sm:text-sm">
                                <input id="price-3" name="price[]" value="75" type="checkbox"
                                    class="flex-shrink-0 h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                <label for="price-3" class="ml-3 min-w-0 flex-1 text-gray-600"> $75+ </label>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend class="block font-medium">Color</legend>
                        <div class="pt-6 space-y-6 sm:pt-4 sm:space-y-4">
                            <div class="flex items-center text-base sm:text-sm">
                                <input id="color-0" name="color[]" value="white" type="checkbox"
                                    class="flex-shrink-0 h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                <label for="color-0" class="ml-3 min-w-0 flex-1 text-gray-600"> White </label>
                            </div>

                            <div class="flex items-center text-base sm:text-sm">
                                <input id="color-1" name="color[]" value="beige" type="checkbox"
                                    class="flex-shrink-0 h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                <label for="color-1" class="ml-3 min-w-0 flex-1 text-gray-600"> Beige </label>
                            </div>

                            <div class="flex items-center text-base sm:text-sm">
                                <input id="color-2" name="color[]" value="blue" type="checkbox"
                                    class="flex-shrink-0 h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500"
                                    checked>
                                <label for="color-2" class="ml-3 min-w-0 flex-1 text-gray-600"> Blue </label>
                            </div>

                            <div class="flex items-center text-base sm:text-sm">
                                <input id="color-3" name="color[]" value="brown" type="checkbox"
                                    class="flex-shrink-0 h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                <label for="color-3" class="ml-3 min-w-0 flex-1 text-gray-600"> Brown </label>
                            </div>

                            <div class="flex items-center text-base sm:text-sm">
                                <input id="color-4" name="color[]" value="green" type="checkbox"
                                    class="flex-shrink-0 h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                <label for="color-4" class="ml-3 min-w-0 flex-1 text-gray-600"> Green </label>
                            </div>

                            <div class="flex items-center text-base sm:text-sm">
                                <input id="color-5" name="color[]" value="purple" type="checkbox"
                                    class="flex-shrink-0 h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                <label for="color-5" class="ml-3 min-w-0 flex-1 text-gray-600"> Purple </label>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="grid grid-cols-1 gap-y-10 auto-rows-min md:grid-cols-2 md:gap-x-6">
                    <fieldset>
                        <legend class="block font-medium">Size</legend>
                        <div class="pt-6 space-y-6 sm:pt-4 sm:space-y-4">
                            <div class="flex items-center text-base sm:text-sm">
                                <input id="size-0" name="size[]" value="xs" type="checkbox"
                                    class="flex-shrink-0 h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                <label for="size-0" class="ml-3 min-w-0 flex-1 text-gray-600"> XS </label>
                            </div>

                            <div class="flex items-center text-base sm:text-sm">
                                <input id="size-1" name="size[]" value="s" type="checkbox"
                                    class="flex-shrink-0 h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500"
                                    checked>
                                <label for="size-1" class="ml-3 min-w-0 flex-1 text-gray-600"> S </label>
                            </div>

                            <div class="flex items-center text-base sm:text-sm">
                                <input id="size-2" name="size[]" value="m" type="checkbox"
                                    class="flex-shrink-0 h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                <label for="size-2" class="ml-3 min-w-0 flex-1 text-gray-600"> M </label>
                            </div>

                            <div class="flex items-center text-base sm:text-sm">
                                <input id="size-3" name="size[]" value="l" type="checkbox"
                                    class="flex-shrink-0 h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                <label for="size-3" class="ml-3 min-w-0 flex-1 text-gray-600"> L </label>
                            </div>

                            <div class="flex items-center text-base sm:text-sm">
                                <input id="size-4" name="size[]" value="xl" type="checkbox"
                                    class="flex-shrink-0 h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                <label for="size-4" class="ml-3 min-w-0 flex-1 text-gray-600"> XL </label>
                            </div>

                            <div class="flex items-center text-base sm:text-sm">
                                <input id="size-5" name="size[]" value="2xl" type="checkbox"
                                    class="flex-shrink-0 h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                <label for="size-5" class="ml-3 min-w-0 flex-1 text-gray-600"> 2XL </label>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend class="block font-medium">Category</legend>
                        <div class="pt-6 space-y-6 sm:pt-4 sm:space-y-4">
                            <div class="flex items-center text-base sm:text-sm">
                                <input id="category-0" name="category[]" value="all-new-arrivals" type="checkbox"
                                    class="flex-shrink-0 h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                <label for="category-0" class="ml-3 min-w-0 flex-1 text-gray-600"> All New Arrivals
                                </label>
                            </div>

                            <div class="flex items-center text-base sm:text-sm">
                                <input id="category-1" name="category[]" value="tees" type="checkbox"
                                    class="flex-shrink-0 h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                <label for="category-1" class="ml-3 min-w-0 flex-1 text-gray-600"> Tees </label>
                            </div>

                            <div class="flex items-center text-base sm:text-sm">
                                <input id="category-2" name="category[]" value="objects" type="checkbox"
                                    class="flex-shrink-0 h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                <label for="category-2" class="ml-3 min-w-0 flex-1 text-gray-600"> Objects </label>
                            </div>

                            <div class="flex items-center text-base sm:text-sm">
                                <input id="category-3" name="category[]" value="sweatshirts" type="checkbox"
                                    class="flex-shrink-0 h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                <label for="category-3" class="ml-3 min-w-0 flex-1 text-gray-600"> Sweatshirts </label>
                            </div>

                            <div class="flex items-center text-base sm:text-sm">
                                <input id="category-4" name="category[]" value="pants-and-shorts" type="checkbox"
                                    class="flex-shrink-0 h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                <label for="category-4" class="ml-3 min-w-0 flex-1 text-gray-600"> Pants &amp; Shorts
                                </label>
                            </div>
                        </div>
                    </fieldset>
                </div> --}}
            </div>
        </div>
        <div class="col-start-1 row-start-1 py-4">
            <div class="flex justify-end max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" x-data="{
            open: false,
            active: 'newest',
        }" x-init="
            $watch('active', () => {
                $wire.emit('sortArchive', active);
            });
        " @click.outside="open = false">
                <div class="relative inline-block">
                    <div class="flex">
                        <button @click="open = !open" type="button"
                            class="group inline-flex justify-center text-sm font-medium text-gray-700 hover:text-gray-900"
                            id="menu-button" aria-expanded="false" aria-haspopup="true">
                            {{ translate('Sort') }}
                            @svg('heroicon-s-chevron-down', ['class' => 'flex-shrink-0 -mr-1 ml-1 h-5 w-5 text-gray-400
                            group-hover:text-gray-500'])
                        </button>
                    </div>

                    <div class="origin-top-right absolute right-0 mt-2 w-40 rounded-md shadow-2xl bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                        x-show="open" x-cloak x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
                        <div class="py-1" role="none">
                            <a href="#" @click="active = 'price'"
                                :class="{'font-medium text-gray-900': active == 'price', 'text-gray-500': active != 'price'}"
                                class="block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-0"> {{
                                translate('By Price') }} </a>
                            <a href="#" @click="active = 'discount'"
                                :class="{'font-medium text-gray-900': active == 'discount', 'text-gray-500': active != 'discount'}"
                                class="block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-0"> {{
                                translate('By Dicount') }} </a>
                            <a href="#" @click="active = 'most_popular'"
                                :class="{'font-medium text-gray-900': active == 'most_popular', 'text-gray-500': active != 'most_popular'}"
                                class="block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-0"> {{
                                translate('By Most Popular') }} </a>
                            {{-- <a href="#" @click="active = 'best_rating'"
                                :class="{'font-medium text-gray-900': active == 'best_rating', 'text-gray-500': active != 'best_rating'}"
                                class="block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-1"> Best
                                Rating </a> --}}
                            <a href="#" @click="active = 'newest'"
                                :class="{'font-medium text-gray-900': active == 'newest', 'text-gray-500': active != 'newest'}"
                                class="block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-2"> {{
                                translate('By Newest') }} </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
