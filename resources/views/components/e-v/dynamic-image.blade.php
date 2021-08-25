@guest

    @if ($href->value)
        <a href="{{ $href->value }}">
    @endif

    <x-tenant.system.image :image="$src->value"></x-tenant.system.image>

    @if ($href->value)
        </a>
    @endif

@else

    @livewire('dynamic-image', [
    'src' => $src,
    'href' => $href
    ])

    <img {{ $attributes->merge(['class' => 'lazyload ']) }} src="{{ $src->value }}"
        onerror="this.onerror=null;this.src='{{ static_asset('img/placeholder.jpg') }}';">


    @endif
