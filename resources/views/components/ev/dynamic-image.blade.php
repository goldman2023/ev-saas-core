@guest
@isset($href->value)
<a href="{{ $href->value }}">
    @endisset
    <x-tenant.system.image :image="$src->value" :dataSrcSet="$dataSrcSet"></x-tenant.system.image>
    @isset($href->value)
</a>
@endisset

@else
@if (auth()->user()->isAdmin())
@livewire('dynamic-image', [
'src' => $src,
'href' => $href
])

@else
<x-tenant.system.image :image="$src->value" :dataSrcSet="$dataSrcSet"></x-tenant.system.image>

@endif


@endif
