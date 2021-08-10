<div class="container b2b-category-list">
    <div class="row mb-7">
        <div class="col-lg-12 mb-5 mb-lg-0">
            <!-- Tags -->
            <div class="d-sm-flex align-items-sm-center text-center text-sm-left">
                <span class="d-block mr-sm-3 mb-2 mb-sm-1">{{ translate('Top Industries:') }}</span>
                @php
                    $categoriesSorted = Cache::remember('top_industries_homepage', 86400, function () use ($categories) {
                        $items = // Category ordering by relationship count
                            $categoriesSorted = $categories->sortBy(function ($category) {
                                return $category->companies->count() * -1;
                            })->take(6);

                        return $items;
                    });



                @endphp

                @foreach ($categoriesSorted as $category)
                    <a class="b2b-category-list__link btn btn-xs btn-soft-secondary btn-pill mx-sm-1 mb-1"
                       href="{{ route('companies.category', $category->slug) }}">
                        {{-- <img
                            class="cat-image mr-2 opacity-60"
                            src="{{ uploaded_asset($category->icon) }}"
                            width="32"
                            alt="{{ $category->getTranslation('name') }}"
                        > --}}
                        {{ $category->name }} ({{ $category->companies->count() }})
                    </a>
                @endforeach
            </div>
            <div class="text-right">
                <a href='{{ route('categories.all') }}'>
                    {{ translate('View All Industries') }} <i class="la la-angle-right "></i>
                </a>
            </div>
            <!-- End Tags -->
        </div>

        <div class="col-lg-4 offset-lg-1 d-none">
            <!-- Input -->
            <form class="input-group input-group-sm input-group-merge input-group-flush">
                <input type="search" class="form-control" placeholder="{{ translate('Search articles') }}"
                       aria-label="Search articles" aria-describedby="searchLabel">
                <div class="input-group-append">
                    <div class="input-group-text" id="searchLabel">
                        <i class="fas fa-search"></i>
                    </div>
                </div>
            </form>
            <!-- End Input -->
        </div>
    </div>
</div>
