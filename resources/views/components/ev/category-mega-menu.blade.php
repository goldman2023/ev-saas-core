<div class="">
    <div class="position-static d-none d-lg-block">
        <div class="aiz-category-menu bg-white rounded  shadow-sm">
            <div class="p-3 bg-soft-primary d-none d-lg-block rounded-top all-category position-relative text-left">
                <span class="fw-600 fs-16 mr-3">

                    {{ translate('Categories') }}

                </span>
            </div>
            <ul class="list-unstyled categories no-scrollbar py-2 mb-0 text-left">
                @foreach ($categories as $key => $category)
                    <li class="category-nav-element" data-id="{{ $category->id }}"
                        data-sub="{{ json_encode($category->children) }}">
                        <a href="{{ $category->getPermalink() }}"
                            class="text-truncate text-reset py-2 px-3 d-block">

                            @if(!empty($category->getUpload('icon')))
                                <img class="cat-image mr-2 opacity-60" src="{{ $category->getUpload('icon', ['w'=>100]) }}" width="32">
                            @endif
                            <span class="cat-name">{{ $category->name }}</span>
                        </a>

                        {{-- TODO: Categories dropdown menu updates --}}
                        {{-- @if (count($category['children']) > 0)
                            <div class="sub-cat-menu c-scrollbar-light rounded shadow-lg p-4">
                                <div class="c-preloader text-center absolute-center">
                                    <i class="las la-spinner la-spin la-3x opacity-70"></i>
                                </div>
                            </div>
                        @endif --}}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
