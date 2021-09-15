<div class="flex-grow-1 front-header-search d-flex align-items-center bg-white">
    <div class="position-relative flex-grow-1">
        <form action="#" method="GET" class="stop-propagation mb-0">
            <div class="d-flex position-relative align-items-center">
                <div class="d-none" data-toggle="class-toggle" data-target=".front-header-search">
                    <button class="btn px-2" type="button" aria-label="search-button">
                        @svg('heroicon-o-search')
                        </button>
                </div>
                <div class="input-group">
                    <input type="text" class="border-0 border-lg form-control" id="search" name="q"
                        placeholder="{{ translate('Search Products, Companies or News') }}"
                        autocomplete="off">
                    <div class="input-group-append d-block">

                        <button class="btn btn-primary" type="submit">
                            <span class="d-block" style="min-width: 30px;">
                            {{ svg('heroicon-o-search') }}
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
        </div>
    </div>
</div>
