<div class="c-main-search flex-grow-1 front-header-search d-flex align-items-center">
    <div class="position-relative flex-grow-1">
        <form action="{{route('search') }}" method="GET" class="stop-propagation mb-0">
            <div class="d-flex position-relative align-items-center">
                <div class="d-none" data-toggle="class-toggle" data-target=".front-header-search">
                    <button class="btn btn-sm px-2" type="button" aria-label="search-button">
                        @svg('heroicon-o-search', ['class' => 'ev-icon'])
                        </button>
                </div>
                <div class="search-overlay"></div>

                <div class="input-group bg-white" style="z-index: 99;">
                    <input type="text" class="border-0 border-lg form-control" id="search" name="q"
                        placeholder="{{ translate('Search Products, Companies or News') }}"
                        value="@isset($_GET['q']) {{ $_GET['q'] }} @endisset"
                        autocomplete="off">
                    <div class="input-group-append d-block">

                        <button class="btn btn-primary btn-sm h-100" type="submit">
                            <span >
                                @svg('heroicon-o-search', ['class' => 'ev-icon__xs'])

                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
        <div class="typed-search-box stop-propagation document-click-d-none d-none bg-white rounded shadow-lg position-absolute left-0 top-100 w-100"
            style="min-height: 200px">
            <div class="search-preloader absolute-top-center">
                <div class="dot-loader">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
            <div class="search-nothing d-none p-3 text-center fs-16">

            </div>
            <div id="search-content" class="text-left">

            </div>
            <div class="top-searches text-center">
                {{ translate('Try popular searches: ') }}

                @php
                    $topSearches = \App\Models\Search::orderBy("count", "desc")->take(10)->get();
                @endphp

                @foreach ($topSearches as $item)
                <a href="#" class="top-search-suggestion">{{ $item->query }}</a> /
                @endforeach
            </div>
        </div>
    </div>
</div>
