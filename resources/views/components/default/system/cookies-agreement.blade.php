@if (get_setting('show_cookies_agreement') == 'on')
<div class="aiz-cookie-alert shadow-xl">
    <div class="p-3 bg-dark rounded">
        <div class="text-white mb-3">
            @php
                echo get_setting('cookies_agreement_text');
            @endphp
        </div>
        <button class="btn btn-primary aiz-cookie-accepet">
            {{ translate('Ok. I Understood') }}
        </button>
    </div>
</div>
@endif
