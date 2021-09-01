<img
    {{ $attributes->merge(['class' => 'lazyload ']) }}
    src="{{ uploaded_asset($image) }}"
    data-src="{{ uploaded_asset($image) }}"
    data-srcset="{{ $dataSrcSet }}"
    onerror="this.onerror=null;this.src='{{ static_asset('img/placeholder.jpg') }}';"
    class="lazyload"
>
<!-- With a request we send what proportion image was requested. We show original (webp converted maybe) version
and add job to queue to generate such version.

Image size can be different for mobile,desktop/etc, different in different components.
-->

