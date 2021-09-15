@if ($label)

    @guest
        <{{ $tag }} {{ $attributes }} class="{{ $class }}">
            {!! $label->value !!}
            </{{ $tag }}>
    @else
        <{{ $tag }} {{ $attributes }} class="{{ $class }}">
            {{-- TODO: Implement roles and check for owner only for this to be availabel --}}
            @livewire('dynamic-label', ['label' => $label])
            </{{ $tag }}>
    @endguest

@else

@endif
