<div x-data="searchForm()" class="bg-transparent border rounded-md dark:border-gray-700 focus-within:border-indigo-500 focus-within:ring focus-within:ring-indigo-600 dark:focus-within:border-indigo-500 focus-within:ring-opacity-40">
    <div class="relative" @click.outside="showResult = false; showLoader = false;">
        <!-- Seach input form -->
        <form action="/search" class="flex flex-wrap justify-between md:flex-row">
            <input
                wire:model.debounce.500ms="query"
                type="search"
                name="query"
                x-ref="searchQuery"
                @input.debounce.500ms="checkSearchQuery('input')"
                @focus="checkSearchQuery('focus')"
                placeholder="Search Companies Example: Wood mills"
                required="required"
                class="flex-1 h-10 px-4 m-1 text-gray-700 placeholder-gray-400 bg-transparent border-none appearance-none lg:h-12 dark:text-gray-200 focus:outline-none focus:placeholder-transparent focus:ring-0">
            <button type="submit" class="flex items-center justify-center w-full p-2 m-1 text-white transition-colors duration-200 transform rounded-md lg:w-12 lg:h-12 lg:p-0 bg-indigo-600 hover:bg-indigo-300 focus:outline-none focus:bg-indigo-300">
                @svg('search', 'w-6 h-6')
            </button>
        </form>
        <!-- End Seach input form -->

        <!-- Seach result container -->
        <div :class="{ 'hidden': !showResult }" class="hidden absolute w-full shadow-xl bg-white rounded-[3px] min-h-[200px]">
            <!-- Dot loader -->
            <div class="flex justify-center">
                <div :class="{ 'hidden': !showLoader }" class="dot-loader hidden">
                    <div class="animate-loader w-[8px] h-[8px] bg-gray-400 rounded-full mx-[2px] inline-flex"></div>
                    <div class="animate-loader w-[8px] h-[8px] bg-gray-400 rounded-full mx-[2px] inline-flex"></div>
                    <div class="animate-loader w-[8px] h-[8px] bg-gray-400 rounded-full mx-[2px] inline-flex"></div>
                </div>
            </div>
            <!-- End Dot loader -->

            <!-- Empty text -->
            <div :class="{ 'hidden': !showEmpty }" class="search-nothing p-3 text-center text-gray-500">
                {{ translate('Sorry, nothing found for ') }} <strong>{{ '"' . $query . '"'}}</strong>
            </div>
            <!-- End Empty text -->

            <!-- Seach result list -->
            <div id="search-content" class="text-left">
                <div class="">
                    @if (sizeof($keywords) > 0)
                        <div class="px-2 py-1 uppercase text-[10px] text-right text-gray-400 bg-gray-200">{{translate('Popular Suggestions')}}</div>
                        <ul class="list-group list-group-raw">
                            @foreach ($keywords as $key => $keyword)
                                <li class="list-group-item py-1 px-3">
                                    <a class="text-[14px]" href="{{ route('suggestion.search', $keyword) }}">{{ $keyword }}</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <div class="">
                    @if (count($categories) > 0)
                        <div class="px-2 py-1 uppercase text-[10px] text-right text-gray-400 bg-gray-200">{{translate('Category Suggestions')}}</div>
                        <ul class="list-group list-group-raw">
                            @foreach ($categories as $key => $category)
                                <li class="list-group-item py-1 px-3">
                                    <a class="text-[14px]" href="{{ route('category.products.index', $category->slug) }}">{{ $category->getTranslation('name') }}</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <div class="">
                    @if (count($products) > 0)
                        <div class="px-2 py-1 uppercase text-[10px] text-right text-gray-400 bg-gray-200">{{translate('Products')}}</div>
                        <ul class="list-group list-group-raw">
                            @foreach ($products as $key => $product)
                                <li class="list-group-item py-3 px-5">
                                    <a class="text-[14px]" href="{{ $product->getPermalink() }}">
                                        <div class="flex search-product align-items-center">
                                            <div class="mr-3">
                                                <img class="w-[40px] h-[40px] rounded-full" src="{{ uploaded_asset($product->thumbnail_img) }}">
                                            </div>
                                            <div class="flex-grow overflow--hidden min-w-0">
                                                <div class="product-name text-truncate text-[14px] mb-5px">
                                                    {{  $product->getTranslation('name')  }}
                                                </div>
                                                <div class="">
                                                    @if($product->getBasePrice() != $product->getTotalPrice())
                                                        <del class="opacity-60 text-[15px]">{{ $product->getBasePrice(true) }}</del>
                                                    @endif
                                                    <span class="font-semibold text-[16px] text-primary">{{ $product->getTotalPrice(true) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <div class="">
                    @if (count($events) > 0)
                        <div class="px-2 py-1 uppercase text-[10px] text-right text-gray-400 bg-gray-200">{{translate('Events')}}</div>
                        <ul class="list-group list-group-raw">
                            @foreach ($events as $key => $event)
                                <li class="list-group-item py-3 px-5">
                                    <a class="text-[14px]" href="{{ route('event.visit', $event->slug) }}">
                                        <div class="flex search-product align-items-center">
                                            <div class="mr-3">
                                                <img class="w-[40px] h-[40px] rounded-full" src="{{ uploaded_asset($event->upload_id) }}">
                                            </div>
                                            <div class="flex-grow overflow--hidden min-w-0">
                                                <div class="product-name text-truncate text-[14px] mb-5px">
                                                    {{  $event->getTranslation('title')  }}
                                                </div>
                                                <div class="">
                                                    @if (strlen($event->getTranslation('description'))>60)
                                                        {{substr($event->getTranslation('description'), 0, 58)."..."}}
                                                    @else
                                                        {{$event->getTranslation('description')}}
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <div class="">
                    @if (count($shops) > 0)
                        <div class="px-2 py-1 uppercase text-[10px] text-right text-gray-400 bg-gray-200">{{translate('Shops')}}</div>
                        <ul class="list-group list-group-raw">
                            @foreach ($shops as $key => $shop)
                                <li class="list-group-item py-3 px-5">
                                    <a class="text-[14px]" href="{{ route('shop.visit', $shop->slug) }}">
                                        <div class="flex search-product align-items-center">
                                            <div class="mr-3">
                                                <img class="w-[40px] h-[40px] rounded-full" src="{{ uploaded_asset($shop->logo) }}">
                                            </div>
                                            <div class="flex-grow overflow--hidden">
                                                <div class="product-name text-truncate text-[14px] mb-5px">
                                                    {{ $shop->name }}
                                                </div>
                                                <div class="text-opacity-60">
                                                    {{ $shop->address }}
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
            <!-- End Seach result list -->
        </div>
        <!-- End Seach result container -->
    </div>
</div>

<script>
    function searchForm() {
        return {
            showEmpty: @entangle('isEmpty').defer,
            showResult: @entangle('isOpen').defer,
            showLoader: @entangle('isLoader').defer,
            checkSearchQuery(action) {
                if (this.$refs.searchQuery.value.trim().length > 0) {
                    this.showResult = true;
                    this.showLoader = true;
                    if (action == 'focus') {
                        @this.search();
                    }
                }
            }
        };
    }
</script>
