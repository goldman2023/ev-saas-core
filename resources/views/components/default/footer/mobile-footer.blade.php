<div class="aiz-mobile-bottom-nav d-xl-none fixed-bottom bg-white shadow-lg border-top rounded-top" style="box-shadow: 0px -1px 10px rgb(0 0 0 / 15%)!important; ">
    <div class="row align-items-center gutters-5">
        <div class="col">
            <a href="/" class="text-reset d-block text-center pb-2 pt-3">
                @svg('heroicon-o-home')
                <span class="d-block fs-10 fw-600 opacity-60 opacity-100 fw-600">
                    {{ translate('Home') }}
                </span>
            </a>
        </div>
        <div class="col">
            <a href="/search/" class="text-reset d-block text-center pb-2 pt-3">
                @svg('heroicon-o-clipboard-list')
                <span class="d-block fs-10 fw-600 opacity-60 ">
                    {{ translate('Categories') }}
                </span>
            </a>
        </div>

        <div class="col">
            <a href="/page/contacts/" class="text-reset d-block text-center pb-2 pt-3">
                @svg('heroicon-s-phone')
                <span class="d-block fs-10 fw-600 opacity-60 ">
                    {{ translate('Contacts') }}
                </span>
            </a>
        </div>



    </div>
</div>
