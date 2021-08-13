<img
    {{ $attributes->merge(['class' => 'rounded-lg lazyload ']) }}
    src="{{ static_asset('img/placeholder.jpg') }}"
    data-src="{{ uploaded_asset($image) }}"
    onerror="this.onerror=null;this.src='{{ static_asset('img/placeholder.jpg') }}';"
>
