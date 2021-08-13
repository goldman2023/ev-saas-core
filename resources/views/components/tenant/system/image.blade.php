<img
    class="rounded-lg lazyload "
    style="width: 100%;"
    src="{{ static_asset('img/placeholder.jpg') }}"
    data-src="{{ uploaded_asset($image) }}"
    onerror="this.onerror=null;this.src='{{ static_asset('img/placeholder.jpg') }}';"
>
