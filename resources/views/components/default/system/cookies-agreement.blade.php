@if (get_setting('show_cookies_agreement') == 'on')
    <!-- Cookie Alert -->
    <div class="position-fixed bottom-0 left-1 z-index-4 c-coockies-agreement">
        <div class="alert bg-white w-lg-80 border shadow mx-auto" role="alert">
            <h5 class="text-dark">{{ translate('Cookies agreement') }}</h5>
            <p class="small text-dark">
                @php
                    echo get_setting('cookies_agreement_text');
                @endphp
            </p>

            <div class="row align-items-sm-center">
                <div class="col-sm-8 mb-3 mb-sm-0">
                    <button type="button" class="btn btn-sm btn-primary transition-3d-hover" data-dismiss="alert"
                        aria-label="Close">
                        {{ translate('Ok. I Understood') }}
                    </button>
                </div>

                <div class="col-sm-4 text-sm-left">

                </div>
            </div>
        </div>
    </div>
    <!-- End Cookie Alert -->
@endif
