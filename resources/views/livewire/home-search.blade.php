<div class="mt-[20px] bg-transparent border rounded-md dark:border-gray-700 lg:w-2/3 focus-within:border-teal-500 focus-within:ring focus-within:ring-primary dark:focus-within:border-teal-500 focus-within:ring-opacity-40">
	<form action="/search" class="flex flex-wrap justify-between md:flex-row">
		<input type="search" name="query" placeholder="Search Components" required="required" class="flex-1 h-10 px-4 m-1 text-gray-700 placeholder-gray-400 bg-transparent border-none appearance-none lg:h-12 dark:text-gray-200 focus:outline-none focus:placeholder-transparent focus:ring-0">
		<button type="submit" class="flex items-center justify-center w-full p-2 m-1 text-white transition-colors duration-200 transform rounded-md lg:w-12 lg:h-12 lg:p-0 bg-primary hover:bg-teal-300 focus:outline-none focus:bg-teal-300">
			<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
			</svg>
		</button>
	</form>
    <div class="typed-search-box stop-propagation document-click-d-none d-none bg-white rounded shadow-lg position-absolute left-0 top-100 w-100" style="min-height: 200px">
        <div class="search-preloader absolute-top-center">
            <div class="dot-loader">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
        <div class="search-nothing d-none p-3 text-center fs-16">
            Sorry, nothing found for <strong>"' + searchKey + '"</strong>
        </div>
        <div id="search-content" class="text-left">

            <div class="">
                @if (sizeof($keywords) > 0)
                    <div class="px-2 py-1 text-uppercase fs-10 text-right text-muted bg-soft-secondary">{{translate('Popular Suggestions')}}</div>
                    <ul class="list-group list-group-raw">
                        @foreach ($keywords as $key => $keyword)
                            <li class="list-group-item py-1">
                                <a class="text-reset hov-text-primary" href="{{ route('suggestion.search', $keyword) }}">{{ $keyword }}</a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
            <div class="">
                @if (count($categories) > 0)
                    <div class="px-2 py-1 text-uppercase fs-10 text-right text-muted bg-soft-secondary">{{translate('Category Suggestions')}}</div>
                    <ul class="list-group list-group-raw">
                        @foreach ($categories as $key => $category)
                            <li class="list-group-item py-1">
                                <a class="text-reset hov-text-primary" href="{{ route('products.category', $category->slug) }}">{{ $category->getTranslation('name') }}</a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
            <div class="">
                @if (count($products) > 0)
                    <div class="px-2 py-1 text-uppercase fs-10 text-right text-muted bg-soft-secondary">{{translate('Products')}}</div>
                    <ul class="list-group list-group-raw">
                        @foreach ($products as $key => $product)
                            <li class="list-group-item">
                                <a class="text-reset" href="{{ route('product', $product->slug) }}">
                                    <div class="d-flex search-product align-items-center">
                                        <div class="mr-3">
                                            <img class="size-40px img-fit rounded" src="{{ uploaded_asset($product->thumbnail_img) }}">
                                        </div>
                                        <div class="flex-grow-1 overflow--hidden minw-0">
                                            <div class="product-name text-truncate fs-14 mb-5px">
                                                {{  $product->getTranslation('name')  }}
                                            </div>
                                            <div class="">
                                                @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                                                    <del class="opacity-60 fs-15">{{ home_base_price($product->id) }}</del>
                                                @endif
                                                <span class="fw-600 fs-16 text-primary">{{ home_discounted_base_price($product->id) }}</span>
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
                    <div class="px-2 py-1 text-uppercase fs-10 text-right text-muted bg-soft-secondary">{{translate('Events')}}</div>
                    <ul class="list-group list-group-raw">
                        @foreach ($events as $key => $event)
                            <li class="list-group-item">
                                <a class="text-reset" href="{{ route('event.visit', $event->slug) }}">
                                    <div class="d-flex search-product align-items-center">
                                        <div class="mr-3">
                                            <img class="size-40px img-fit rounded" src="{{ uploaded_asset($event->upload_id) }}">
                                        </div>
                                        <div class="flex-grow-1 overflow--hidden minw-0">
                                            <div class="product-name text-truncate fs-14 mb-5px">
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
        </div>
    </div>
</div>