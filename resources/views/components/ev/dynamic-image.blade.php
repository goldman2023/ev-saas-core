@guest

<p>guest</p>
    @isset($href->value)
        <a href="{{ $href->value }}">
    @endisset

    {{$dataSrcSet}}
            <x-tenant.system.image :image="$src->value" :dataSrcSet="$dataSrcSet" ></x-tenant.system.image>
    @isset($href->value)
        </a>
    @endisset

@else

    @livewire('dynamic-image', [
    'src' => $src,
    'href' => $href
    ])

    <img {{ $attributes->merge(['class' => 'lazyload ']) }} data-srcset="{{ $dataSrcSet }}"
        data-src="{{ uploaded_asset($src->value) }}" class="lazyload" onerror="this.onerror=null;this.src='{{ static_asset('img/placeholder.jpg') }}';">
@endif