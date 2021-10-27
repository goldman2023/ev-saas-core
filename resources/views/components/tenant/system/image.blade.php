<img
    {{ $attributes->merge(['class' => 'lazyload ']) }}
    src="{{ $image }}"
    data-src="{{ $image }}"
    data-srcset="{{ $dataSrcSet }}"
    onerror="this.onerror=null;this.src='{{ \IMG::getPlaceholder() }}';"
    class="lazyload"
    style="@if($fit) object-fit:{{ $fit }}; @endif"
>
<!-- With a request we send what proportion image was requested. We show original (webp converted maybe) version
and add job to queue to generate such version.

Image size can be different for mobile,desktop/etc, different in different components.
-->

