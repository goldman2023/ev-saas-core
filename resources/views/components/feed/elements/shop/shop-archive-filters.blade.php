<div class="bg-white">

    <div x-data="{ open: false }" @keydown.window.escape="open = false" class="bg-white">
        <!-- Mobile filter dialog -->

        <div x-show="open" class="fixed inset-0 flex z-40 sm:hidden"
            x-description="Off-canvas filters for mobile, show/hide based on off-canvas filters state." x-ref="dialog"
            aria-modal="true" style="display: none;">

            <div x-show="open" x-transition:enter="transition-opacity ease-linear duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                x-description="Off-canvas menu overlay, show/hide based on off-canvas menu state."
                class="fixed inset-0 bg-black bg-opacity-25" @click="open = false" aria-hidden="true"
                style="display: none;">
            </div>


            <div x-show="open" x-transition:enter="transition ease-in-out duration-300 transform"
                x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in-out duration-300 transform"
                x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                x-description="Off-canvas menu, show/hide based on off-canvas menu state."
                class="ml-auto relative max-w-xs w-full h-full bg-white shadow-xl py-4 pb-12 flex flex-col overflow-y-auto"
                style="display: none;">
                <div class="px-4 flex items-center justify-between">
                    <h2 class="text-lg font-medium text-gray-900">Filters</h2>
                    <button type="button"
                        class="-mr-2 w-10 h-10 bg-white p-2 rounded-md flex items-center justify-center text-gray-400"
                        @click="open = false">
                        <span class="sr-only">Close menu</span>
                        <svg class="h-6 w-6" x-description="Heroicon name: outline/x" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Filters -->
                <form class="mt-4">

                    <div x-data="{ open: false }" class="border-t border-gray-200 px-4 py-6">
                        <h3 class="-mx-2 -my-3 flow-root">
                            <button type="button" x-description="Expand/collapse section button"
                                class="px-2 py-3 bg-white w-full flex items-center justify-between text-sm text-gray-400"
                                aria-controls="filter-section-0" @click="open = !open" aria-expanded="false"
                                x-bind:aria-expanded="open.toString()">
                                <span class="font-medium text-gray-900">
                                    Category
                                </span>
                                <span class="ml-6 flex items-center">
                                    <svg class="rotate-0 h-5 w-5 transform" x-description="Expand/collapse icon, toggle classes based on section open state.

  Heroicon name: solid/chevron-down" x-state:on="Open" x-state:off="Closed"
                                        :class="{ '-rotate-180': open, 'rotate-0': !(open) }"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </span>
                            </button>
                        </h3>
                        <div class="pt-6" x-description="Filter section, show/hide based on section state."
                            id="filter-section-0" x-show="open" style="display: none;">
                            <div class="space-y-6">

                                <div class="flex items-center">
                                    <input id="filter-mobile-category-0" name="category[]" value="new-arrivals"
                                        type="checkbox"
                                        class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                    <label for="filter-mobile-category-0" class="ml-3 text-sm text-gray-500">
                                        All New Arrivals
                                    </label>
                                </div>

                                <div class="flex items-center">
                                    <input id="filter-mobile-category-1" name="category[]" value="tees" type="checkbox"
                                        class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                    <label for="filter-mobile-category-1" class="ml-3 text-sm text-gray-500">
                                        Tees
                                    </label>
                                </div>

                                <div class="flex items-center">
                                    <input id="filter-mobile-category-2" name="category[]" value="objects"
                                        type="checkbox" checked=""
                                        class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                    <label for="filter-mobile-category-2" class="ml-3 text-sm text-gray-500">
                                        Objects
                                    </label>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div x-data="{ open: false }" class="border-t border-gray-200 px-4 py-6">
                        <h3 class="-mx-2 -my-3 flow-root">
                            <button type="button" x-description="Expand/collapse section button"
                                class="px-2 py-3 bg-white w-full flex items-center justify-between text-sm text-gray-400"
                                aria-controls="filter-section-1" @click="open = !open" aria-expanded="false"
                                x-bind:aria-expanded="open.toString()">
                                <span class="font-medium text-gray-900">
                                    Color
                                </span>
                                <span class="ml-6 flex items-center">
                                    <svg class="rotate-0 h-5 w-5 transform" x-description="Expand/collapse icon, toggle classes based on section open state.

  Heroicon name: solid/chevron-down" x-state:on="Open" x-state:off="Closed"
                                        :class="{ '-rotate-180': open, 'rotate-0': !(open) }"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </span>
                            </button>
                        </h3>
                        <div class="pt-6" x-description="Filter section, show/hide based on section state."
                            id="filter-section-1" x-show="open" style="display: none;">
                            <div class="space-y-6">

                                <div class="flex items-center">
                                    <input id="filter-mobile-color-0" name="color[]" value="white" type="checkbox"
                                        class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                    <label for="filter-mobile-color-0" class="ml-3 text-sm text-gray-500">
                                        White
                                    </label>
                                </div>

                                <div class="flex items-center">
                                    <input id="filter-mobile-color-1" name="color[]" value="beige" type="checkbox"
                                        class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                    <label for="filter-mobile-color-1" class="ml-3 text-sm text-gray-500">
                                        Beige
                                    </label>
                                </div>

                                <div class="flex items-center">
                                    <input id="filter-mobile-color-2" name="color[]" value="blue" type="checkbox"
                                        class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                    <label for="filter-mobile-color-2" class="ml-3 text-sm text-gray-500">
                                        Blue
                                    </label>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div x-data="{ open: false }" class="border-t border-gray-200 px-4 py-6">
                        <h3 class="-mx-2 -my-3 flow-root">
                            <button type="button" x-description="Expand/collapse section button"
                                class="px-2 py-3 bg-white w-full flex items-center justify-between text-sm text-gray-400"
                                aria-controls="filter-section-2" @click="open = !open" aria-expanded="false"
                                x-bind:aria-expanded="open.toString()">
                                <span class="font-medium text-gray-900">
                                    Sizes
                                </span>
                                <span class="ml-6 flex items-center">
                                    <svg class="rotate-0 h-5 w-5 transform" x-description="Expand/collapse icon, toggle classes based on section open state.

  Heroicon name: solid/chevron-down" x-state:on="Open" x-state:off="Closed"
                                        :class="{ '-rotate-180': open, 'rotate-0': !(open) }"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </span>
                            </button>
                        </h3>
                        <div class="pt-6" x-description="Filter section, show/hide based on section state."
                            id="filter-section-2" x-show="open" style="display: none;">
                            <div class="space-y-6">

                                <div class="flex items-center">
                                    <input id="filter-mobile-sizes-0" name="sizes[]" value="s" type="checkbox"
                                        class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                    <label for="filter-mobile-sizes-0" class="ml-3 text-sm text-gray-500">
                                        S
                                    </label>
                                </div>

                                <div class="flex items-center">
                                    <input id="filter-mobile-sizes-1" name="sizes[]" value="m" type="checkbox"
                                        class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                    <label for="filter-mobile-sizes-1" class="ml-3 text-sm text-gray-500">
                                        M
                                    </label>
                                </div>

                                <div class="flex items-center">
                                    <input id="filter-mobile-sizes-2" name="sizes[]" value="l" type="checkbox"
                                        class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                    <label for="filter-mobile-sizes-2" class="ml-3 text-sm text-gray-500">
                                        L
                                    </label>
                                </div>

                            </div>
                        </div>
                    </div>

                </form>
            </div>

        </div>


        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">
                {{ translate('Discover') }} {{ get_site_name() }} {{ translate('shops') }}
            </h1>
            <p class="mt-4 max-w-xl text-sm text-gray-700">
                {{ translate('Exploe the community of verified')}} {{ get_site_name() }} {{ translate('Members') }}
            </p>
        </div>

        <!-- Filters -->
        <section aria-labelledby="filter-heading">
            <h2 id="filter-heading" class="sr-only">Filters</h2>

            <div class="relative z-10 bg-white border-b border-gray-200 pb-4">
                <div class="max-w-7xl mx-auto px-4 flex items-center justify-between sm:px-6 lg:px-8">
                    <div x-data="Components.menu({ open: false })" x-init="init()"
                        @keydown.escape.stop="open = false; focusButton()" @click.away="onClickAway($event)"
                        class="relative inline-block text-left">
                        <div>
                            <button type="button"
                                class="group inline-flex justify-center text-sm font-medium text-gray-700 hover:text-gray-900"
                                id="menu-button" x-ref="button" @click="onButtonClick()"
                                @keyup.space.prevent="onButtonEnter()" @keydown.enter.prevent="onButtonEnter()"
                                aria-expanded="false" aria-haspopup="true" x-bind:aria-expanded="open.toString()"
                                @keydown.arrow-up.prevent="onArrowUp()" @keydown.arrow-down.prevent="onArrowDown()">
                                Sort
                                <svg class="flex-shrink-0 -mr-1 ml-1 h-5 w-5 text-gray-400 group-hover:text-gray-500"
                                    x-description="Heroicon name: solid/chevron-down" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>


                        <div x-show="open" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="origin-top-left absolute left-0 mt-2 w-40 rounded-md shadow-2xl bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                            x-ref="menu-items" x-description="Dropdown menu, show/hide based on menu state."
                            x-bind:aria-activedescendant="activeDescendant" role="menu" aria-orientation="vertical"
                            aria-labelledby="menu-button" tabindex="-1" @keydown.arrow-up.prevent="onArrowUp()"
                            @keydown.arrow-down.prevent="onArrowDown()" @keydown.tab="open = false"
                            @keydown.enter.prevent="open = false; focusButton()"
                            @keyup.space.prevent="open = false; focusButton()" style="display: none;">
                            <div class="py-1" role="none">

                                <a href="#" class="font-medium text-gray-900 block px-4 py-2 text-sm"
                                    x-state:on="Active" x-state:off="Not Active" x-state:on:option.current="Selected"
                                    x-state:off:option.current="Not Selected"
                                    x-state-description="Selected: &quot;font-medium text-gray-900&quot;, Not Selected: &quot;text-gray-500&quot;"
                                    :class="{ 'bg-gray-100': activeIndex === 0 }" role="menuitem" tabindex="-1"
                                    id="menu-item-0" @mouseenter="activeIndex = 0" @mouseleave="activeIndex = -1"
                                    @click="open = false; focusButton()">
                                    Most Popular
                                </a>

                                <a href="#" class="text-gray-500 block px-4 py-2 text-sm"
                                    x-state-description="undefined: &quot;font-medium text-gray-900&quot;, undefined: &quot;text-gray-500&quot;"
                                    :class="{ 'bg-gray-100': activeIndex === 1 }" role="menuitem" tabindex="-1"
                                    id="menu-item-1" @mouseenter="activeIndex = 1" @mouseleave="activeIndex = -1"
                                    @click="open = false; focusButton()">
                                    Best Rating
                                </a>

                                <a href="#" class="text-gray-500 block px-4 py-2 text-sm"
                                    x-state-description="undefined: &quot;font-medium text-gray-900&quot;, undefined: &quot;text-gray-500&quot;"
                                    :class="{ 'bg-gray-100': activeIndex === 2 }" role="menuitem" tabindex="-1"
                                    id="menu-item-2" @mouseenter="activeIndex = 2" @mouseleave="activeIndex = -1"
                                    @click="open = false; focusButton()">
                                    Newest
                                </a>

                            </div>
                        </div>

                    </div>

                    <button type="button"
                        x-description="Mobile filter dialog toggle, controls the 'mobileFiltersOpen' state."
                        class="inline-block text-sm font-medium text-gray-700 hover:text-gray-900 sm:hidden"
                        @click="open = true">
                        Filters
                    </button>

                    <div class="hidden sm:block">
                        <div class="flow-root">
                            <div class="-mx-4 flex items-center divide-x divide-gray-200"
                                x-data="Components.popoverGroup()" x-init="init()">

                                <div class="px-4 relative inline-block text-left"
                                    x-data="Components.popover({ open: false, focus: false })" x-init="init()"
                                    @keydown.escape="onEscape" @close-popover-group.window="onClosePopoverGroup">
                                    <button type="button"
                                        class="group inline-flex justify-center text-sm font-medium text-gray-700 hover:text-gray-900"
                                        @click="toggle" @mousedown="if (open) $event.preventDefault()"
                                        aria-expanded="false" :aria-expanded="open.toString()">
                                        <span>Category</span>

                                        <span
                                            class="ml-1.5 rounded py-0.5 px-1.5 bg-gray-200 text-xs font-semibold text-gray-700 tabular-nums">1</span>
                                        <svg class="flex-shrink-0 -mr-1 ml-1 h-5 w-5 text-gray-400 group-hover:text-gray-500"
                                            x-description="Heroicon name: solid/chevron-down"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                            aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </button>


                                    <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                        x-transition:enter-start="transform opacity-0 scale-95"
                                        x-transition:enter-end="transform opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-75"
                                        x-transition:leave-start="transform opacity-100 scale-100"
                                        x-transition:leave-end="transform opacity-0 scale-95"
                                        class="origin-top-right absolute right-0 mt-2 bg-white rounded-md shadow-2xl p-4 ring-1 ring-black ring-opacity-5 focus:outline-none"
                                        x-description="'Category' dropdown, show/hide based on dropdown state."
                                        x-ref="panel" @click.away="open = false" style="display: none;">
                                        <form class="space-y-4">

                                            <div class="flex items-center">
                                                <input id="filter-category-0" name="category[]" value="new-arrivals"
                                                    type="checkbox"
                                                    class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                                <label for="filter-category-0"
                                                    class="ml-3 pr-6 text-sm font-medium text-gray-900 whitespace-nowrap">
                                                    All New Arrivals
                                                </label>
                                            </div>

                                            <div class="flex items-center">
                                                <input id="filter-category-1" name="category[]" value="tees"
                                                    type="checkbox"
                                                    class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                                <label for="filter-category-1"
                                                    class="ml-3 pr-6 text-sm font-medium text-gray-900 whitespace-nowrap">
                                                    Tees
                                                </label>
                                            </div>

                                            <div class="flex items-center">
                                                <input id="filter-category-2" name="category[]" value="objects"
                                                    type="checkbox" checked=""
                                                    class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                                <label for="filter-category-2"
                                                    class="ml-3 pr-6 text-sm font-medium text-gray-900 whitespace-nowrap">
                                                    Objects
                                                </label>
                                            </div>

                                        </form>
                                    </div>

                                </div>

                                <div class="px-4 relative inline-block text-left"
                                    x-data="Components.popover({ open: false, focus: false })" x-init="init()"
                                    @keydown.escape="onEscape" @close-popover-group.window="onClosePopoverGroup">
                                    <button type="button"
                                        class="group inline-flex justify-center text-sm font-medium text-gray-700 hover:text-gray-900"
                                        @click="toggle" @mousedown="if (open) $event.preventDefault()"
                                        aria-expanded="false" :aria-expanded="open.toString()">
                                        <span>Color</span>
                                        <svg class="flex-shrink-0 -mr-1 ml-1 h-5 w-5 text-gray-400 group-hover:text-gray-500"
                                            x-description="Heroicon name: solid/chevron-down"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                            aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </button>


                                    <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                        x-transition:enter-start="transform opacity-0 scale-95"
                                        x-transition:enter-end="transform opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-75"
                                        x-transition:leave-start="transform opacity-100 scale-100"
                                        x-transition:leave-end="transform opacity-0 scale-95"
                                        class="origin-top-right absolute right-0 mt-2 bg-white rounded-md shadow-2xl p-4 ring-1 ring-black ring-opacity-5 focus:outline-none"
                                        x-description="'Color' dropdown, show/hide based on dropdown state."
                                        x-ref="panel" @click.away="open = false" style="display: none;">
                                        <form class="space-y-4">

                                            <div class="flex items-center">
                                                <input id="filter-color-0" name="color[]" value="white" type="checkbox"
                                                    class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                                <label for="filter-color-0"
                                                    class="ml-3 pr-6 text-sm font-medium text-gray-900 whitespace-nowrap">
                                                    White
                                                </label>
                                            </div>

                                            <div class="flex items-center">
                                                <input id="filter-color-1" name="color[]" value="beige" type="checkbox"
                                                    class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                                <label for="filter-color-1"
                                                    class="ml-3 pr-6 text-sm font-medium text-gray-900 whitespace-nowrap">
                                                    Beige
                                                </label>
                                            </div>

                                            <div class="flex items-center">
                                                <input id="filter-color-2" name="color[]" value="blue" type="checkbox"
                                                    class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                                <label for="filter-color-2"
                                                    class="ml-3 pr-6 text-sm font-medium text-gray-900 whitespace-nowrap">
                                                    Blue
                                                </label>
                                            </div>

                                        </form>
                                    </div>

                                </div>

                                <div class="px-4 relative inline-block text-left"
                                    x-data="Components.popover({ open: false, focus: false })" x-init="init()"
                                    @keydown.escape="onEscape" @close-popover-group.window="onClosePopoverGroup">
                                    <button type="button"
                                        class="group inline-flex justify-center text-sm font-medium text-gray-700 hover:text-gray-900"
                                        @click="toggle" @mousedown="if (open) $event.preventDefault()"
                                        aria-expanded="false" :aria-expanded="open.toString()">
                                        <span>Sizes</span>
                                        <svg class="flex-shrink-0 -mr-1 ml-1 h-5 w-5 text-gray-400 group-hover:text-gray-500"
                                            x-description="Heroicon name: solid/chevron-down"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                            aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </button>


                                    <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                        x-transition:enter-start="transform opacity-0 scale-95"
                                        x-transition:enter-end="transform opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-75"
                                        x-transition:leave-start="transform opacity-100 scale-100"
                                        x-transition:leave-end="transform opacity-0 scale-95"
                                        class="origin-top-right absolute right-0 mt-2 bg-white rounded-md shadow-2xl p-4 ring-1 ring-black ring-opacity-5 focus:outline-none"
                                        x-description="'Sizes' dropdown, show/hide based on dropdown state."
                                        x-ref="panel" @click.away="open = false" style="display: none;">
                                        <form class="space-y-4">

                                            <div class="flex items-center">
                                                <input id="filter-sizes-0" name="sizes[]" value="s" type="checkbox"
                                                    class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                                <label for="filter-sizes-0"
                                                    class="ml-3 pr-6 text-sm font-medium text-gray-900 whitespace-nowrap">
                                                    S
                                                </label>
                                            </div>

                                            <div class="flex items-center">
                                                <input id="filter-sizes-1" name="sizes[]" value="m" type="checkbox"
                                                    class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                                <label for="filter-sizes-1"
                                                    class="ml-3 pr-6 text-sm font-medium text-gray-900 whitespace-nowrap">
                                                    M
                                                </label>
                                            </div>

                                            <div class="flex items-center">
                                                <input id="filter-sizes-2" name="sizes[]" value="l" type="checkbox"
                                                    class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                                <label for="filter-sizes-2"
                                                    class="ml-3 pr-6 text-sm font-medium text-gray-900 whitespace-nowrap">
                                                    L
                                                </label>
                                            </div>

                                        </form>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active filters -->
            <div class="bg-gray-100">
                <div class="max-w-7xl mx-auto py-3 px-4 sm:flex sm:items-center sm:px-6 lg:px-8">
                    <h3 class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                        Filters
                        <span class="sr-only">, active</span>
                    </h3>

                    <div aria-hidden="true" class="hidden w-px h-5 bg-gray-300 sm:block sm:ml-4"></div>

                    <div class="mt-2 sm:mt-0 sm:ml-4">
                        <div class="-m-1 flex flex-wrap items-center">

                            <span
                                class="m-1 inline-flex rounded-full border border-gray-200 items-center py-1.5 pl-3 pr-2 text-sm font-medium bg-white text-gray-900">
                                <span>Objects</span>
                                <button type="button"
                                    class="flex-shrink-0 ml-1 h-4 w-4 p-1 rounded-full inline-flex text-gray-400 hover:bg-gray-200 hover:text-gray-500">
                                    <span class="sr-only">Remove filter for Objects</span>
                                    <svg class="h-2 w-2" stroke="currentColor" fill="none" viewBox="0 0 8 8">
                                        <path stroke-linecap="round" stroke-width="1.5" d="M1 1l6 6m0-6L1 7"></path>
                                    </svg>
                                </button>
                            </span>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

</div>
