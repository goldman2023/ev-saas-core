@if ($label)

<{{ $tag }} {{ $attributes }} class="{{ $class }}">
    {!! $label?->value ?? $label !!}
</{{ $tag }}>


@endif
