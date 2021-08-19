<div x-data="{ 
        open: @entangle('isEmpty').defer,
        isStart: false,
        checkSearchQuery() {
            if ($refs.searchQuery.value.length > 0) {
                $('.typed-search-box').removeClass('hidden');
            }else{
                $('.typed-search-box').addClass('hidden');
            }
        }
    }" 
    class="my-6 ml-8 bg-transparent border rounded-md dark:border-gray-700 lg:w-2/3 focus-within:border-indigo-500 focus-within:ring focus-within:ring-indigo-600 dark:focus-within:border-indigo-500 focus-within:ring-opacity-40">
    <div class="relative">
        <form action="/search" class="flex flex-wrap justify-between md:flex-row">
            <input 
                wire:model="query"
                type="search" 
                name="query"
                x-ref="searchQuery"
                @keyup="checkSearchQuery()"
                @focus="checkSearchQuery()"             
                placeholder="Search Companies Example: Wood mills" 
                required="required" 
                class="flex-1 h-10 px-4 m-1 text-gray-700 placeholder-gray-400 bg-transparent border-none appearance-none lg:h-12 dark:text-gray-200 focus:outline-none focus:placeholder-transparent focus:ring-0">
            <button type="submit" class="flex items-center justify-center w-full p-2 m-1 text-white transition-colors duration-200 transform rounded-md lg:w-12 lg:h-12 lg:p-0 bg-indigo-600 hover:bg-indigo-300 focus:outline-none focus:bg-indigo-300">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </button>
        </form>    
        <div class="typed-search-box stop-propagation absolute w-full shadow-xl bg-white rounded-[3px] hidden min-h-[200px]">    
            <div :class="{ 'hidden': false }" class="flex justify-center">
                <div class="dot-loader">
                    <div class="animate-loader w-[8px] h-[8px] bg-gray-400 rounded-full mx-[2px] inline-flex"></div>
                    <div class="animate-loader w-[8px] h-[8px] bg-gray-400 rounded-full mx-[2px] inline-flex"></div>
                    <div class="animate-loader w-[8px] h-[8px] bg-gray-400 rounded-full mx-[2px] inline-flex"></div>
                </div>
            </div>        
            <div :class="{ 'hidden': ![open] }" class="search-nothing p-3 text-center text-gray-500">
                {{ translate('Sorry, nothing found for ') }} <strong>{{ '"' . $query . '"'}}</strong>
            </div>
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
                                    <a class="text-[14px]" href="{{ route('products.category', $category->slug) }}">{{ $category->getTranslation('name') }}</a>
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
                                    <a class="text-[14px]" href="{{ route('product', $product->slug) }}">
                                        <div class="flex search-product align-items-center">
                                            <div class="mr-3">
                                                <img class="w-[40px] h-[40px] rounded-full" src="{{ uploaded_asset($product->thumbnail_img) }}">
                                            </div>
                                            <div class="flex-grow overflow--hidden min-w-0">
                                                <div class="product-name text-truncate text-[14px] mb-5px">
                                                    {{  $product->getTranslation('name')  }}
                                                </div>
                                                <div class="">
                                                    @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                                                        <del class="opacity-60 text-[15px]">{{ home_base_price($product->id) }}</del>
                                                    @endif
                                                    <span class="font-semibold text-[16px] text-primary">{{ home_discounted_base_price($product->id) }}</span>
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
        </div>
    </div>	
</div>