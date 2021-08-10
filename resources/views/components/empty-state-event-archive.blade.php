<div class="row align-items-sm-center py-sm-10">
    <div class="col-sm-6">
        <div class="text-center text-sm-right mr-sm-4 mb-5 mb-sm-0">
            <img class="w-60 w-sm-100 mx-auto" src="{{ asset('assets/svg/illustrations/think.svg') }}"
                alt="B2BWood Nothing Found" style="max-width: 15rem;">
        </div>
    </div>

    <div class="col-sm-6 col-md-4 text-center text-sm-left">
        <h2 class="h3 display-4 mb-2">{{ translate('No Events Matched your Criteria') }}</h1>
            <p class="lead">
                {{ translate('We could not find events according to requirements. You can recommend a event you know.') }}
            </p>


            <a class="btn btn-secondary btn-sm"  onclick="window.history.back()" href="#back">
                <i class="la la-angle-left "></i>
                {{ translate('Back') }}
            </a>

            <span class="text-muted text-small">
                {{ translate(' - or - ') }}
            </span>

            @guest
                <x-join-button></x-join-button>
            @else
                <a class="btn btn-success btn-sm text-white" href="https://mailchi.mp/51a85d872d3f/b2bwood-club-recommend-a-company" target="_blank">
                    {{ translate('Recommend A Event') }}
                    <i class="la la-angle-right "></i>
                </a>
            @endguest
    </div>
</div>
