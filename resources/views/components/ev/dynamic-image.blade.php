@guest
    @isset($href->value)
        <a href="{{ $href->value }}">
    @endisset
        <x-tenant.system.image :image="$src->value" :dataSrcSet="$dataSrcSet" ></x-tenant.system.image>
    @isset($href->value)
        </a>
    @endisset

@else

    @livewire('dynamic-image', [
    'src' => $src,
    'href' => $href
    ])

    <x-tenant.system.image :image="$src->value" :dataSrcSet="$dataSrcSet" ></x-tenant.system.image>

@endif
