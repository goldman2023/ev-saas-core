<div>
    <ul class="list-unstyled categories no-scrollbar py-2 mb-0 text-left">
        @foreach ($categories as $key => $category)
            <li class="category-nav-element" data-id="{{ $category['id'] }}" data-sub="{{ json_encode($category['children']) }}">
                <a href="{{ route('products.category', $category['slug']) }}" class="text-truncate text-reset py-2 px-3 d-block">
                    {{-- <img
                        class="cat-image mr-2 opacity-60"
                        src="{{ uploaded_asset($category->icon) }}"
                        width="32"
                        alt="{{ $category->getTranslation('name') }}"
                    > --}}  
                    <span class="cat-name">{{ $category['name'] }}</span>
                </a>
                @if(count($category['children'])>0)
                    <div class="sub-cat-menu c-scrollbar-light rounded shadow-lg p-4">
                        <div class="c-preloader text-center absolute-center">
                            <i class="las la-spinner la-spin la-3x opacity-70"></i>
                        </div>
                    </div>
                @endif
            </li>
        @endforeach
    </ul>
</div>