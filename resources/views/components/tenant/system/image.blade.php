<img
    {{ $attributes->merge(['class' => 'lazyload ']) }}
    src="{{ $image }}"
    data-src="{{ $image }}"
    loading="lazy"
    data-srcset="{{ $dataSrcSet }}"
    onerror="this.onerror=null;this.src='{{ \IMG::getPlaceholder() }}';"
    class="lazyload"
    style="@if($fit) object-fit:{{ $fit }}; @endif"
>
