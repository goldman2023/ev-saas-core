<!-- Component name: Category List - Sidebar-->
<!-- Component used: front/snippets/sidebar-examples.html#component-7 -->
<div class="c-category-list-sidebar w-100">
    <div class="row w-100">
        <div class="navbar-expand-lg navbar-expand-lg-collapse-block w-100">
            <div class="d-flex d-md-none mb-5 mb-lg-3 w-100">
                <!-- Responsive Toggle Button -->
                <button type="button" class="navbar-toggler btn btn-block border py-3"
                        aria-label="Toggle navigation"
                        aria-expanded="false"
                        aria-controls="categoryListSidebar"
                        data-toggle="collapse"
                        data-target="#categoryListSidebar">
                      <span class="d-flex justify-content-between align-items-center">
                        <span class="h5 mb-0">{{ translate('View all categories') }}</span>
                        <span class="navbar-toggler-default">
                          <svg width="14" height="14" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                            <path fill="currentColor" d="M17.4,6.2H0.6C0.3,6.2,0,5.9,0,5.5V4.1c0-0.4,0.3-0.7,0.6-0.7h16.9c0.3,0,0.6,0.3,0.6,0.7v1.4C18,5.9,17.7,6.2,17.4,6.2z M17.4,14.1H0.6c-0.3,0-0.6-0.3-0.6-0.7V12c0-0.4,0.3-0.7,0.6-0.7h16.9c0.3,0,0.6,0.3,0.6,0.7v1.4C18,13.7,17.7,14.1,17.4,14.1z"/>
                          </svg>
                        </span>
                        <span class="navbar-toggler-toggled">
                          <svg width="14" height="14" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                            <path fill="currentColor" d="M11.5,9.5l5-5c0.2-0.2,0.2-0.6-0.1-0.9l-1-1c-0.3-0.3-0.7-0.3-0.9-0.1l-5,5l-5-5C4.3,2.3,3.9,2.4,3.6,2.6l-1,1 C2.4,3.9,2.3,4.3,2.5,4.5l5,5l-5,5c-0.2,0.2-0.2,0.6,0.1,0.9l1,1c0.3,0.3,0.7,0.3,0.9,0.1l5-5l5,5c0.2,0.2,0.6,0.2,0.9-0.1l1-1 c0.3-0.3,0.3-0.7,0.1-0.9L11.5,9.5z"/>
                          </svg>
                        </span>
                      </span>
                </button>
                <!-- End Responsive Toggle Button -->
            </div>

            <div class="w-100 card card-bordered px-4 py-2 pt-3">
                <div id="categoryListSidebar" class=" collapse navbar-collapse show">
                    <div class="d-none d-md-flex w-100 pb-1 mb-3 border-bottom">
                        <span class="h4 mb-0">{{ translate('Categories') }}</span>
                    </div>

                    @if($categories->isNotEmpty())
                        @foreach($categories as $category)
                            <div class="mb-2 mt-lg-0">
                                @php
                                    $show = ($selectedCategory->id ?? null) === $category->id || Str::startsWith($selectedCategory->slug_path ?? null, $category->slug_path);
                                    $is_collapsed = $show ? '':'collapsed';
                                @endphp
                                <h3 class="c-category-list-sidebar__top-item h5 fw-500 d-flex justify-content-between align-items-center px-0 mb-1 {{ $is_collapsed }}"
                                    data-toggle="collapse" href="#{{ 'collapse-section-'.$category->slug_path }}" role="button" aria-expanded="false" aria-controls="{{ 'collapse-section-'.$category->slug_path }}"
                                >
                                    <a class="text-inherit" href="{{ route('category.products.index', $category->slug) }}">{{ $category->getTranslation('name') ?? '' }}</a>

                                    @if(!empty($category->children) && $category->children->isNotEmpty())
                                        @svg('heroicon-o-chevron-down', ['class' => 'ev-icon ev-icon__xs'])
                                    @endif
                                </h3>

                                @php echo recursiveTemplate($category->children, $category, $selectedCategory, $show); @endphp
                            </div>
                        @endforeach
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

@php
function recursiveTemplate($children, $parent, $selectedCategory, $show = false) {
    if(!empty($children) && $children->isNotEmpty()) {
@endphp
<div class="c-category-list-sidebar__submenu collapse {{ $show ? 'show':'' }}" id="{{ 'collapse-section-'.$parent->slug_path }}">
@php
        foreach($children as $category) {
@endphp
    <a class="c-category-list-sidebar__submenu-item dropdown-item d-flex justify-content-between align-items-center px-0
        @if(Str::startsWith($selectedCategory->slug_path ?? null, $category->slug_path)) active @endif
    " href="{{ route('category.products.index', $category->slug) }}">
        <span class="pr-1 flex-text-ellipsis">{{ $category->getTranslation('name') }}</span>
        <span class="badge border badge-pill">{{ $category->products_count ?? '' }}</span>
    </a>
@php
        }
@endphp
</div>
@php
    }
}
@endphp
