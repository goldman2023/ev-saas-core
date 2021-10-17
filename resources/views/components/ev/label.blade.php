@if ($label)

    @guest
        <{{ $tag }} {{ $attributes }} class="{{ $class }}">
            {!! $label->value !!}
            </{{ $tag }}>
        @else

            @if (auth()->user()->isAdmin())
                <{{ $tag }} {{ $attributes }} class="{{ $class }}">
                    {{-- TODO: Implement roles and check for owner only for this to be availabel --}}
                    @livewire('dynamic-label', ['label' => $label])
                    </{{ $tag }}>
                @else
                {{-- TODO: this is not good, need to create specific directives for admin only --}}
                    <{{ $tag }} {{ $attributes }} class="{{ $class }}">
                        {!! $label->value !!}
                        </{{ $tag }}>
            @endif


        @endguest

    @else

@endif
