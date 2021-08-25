    <a {{ $attributes }} href="{{ $href->value }}">

        {{ $label->value }}

    </a>



    @if ($label)

        @guest
            {!! $label->value !!}
        @else
            {{-- TODO: Implement roles and check for owner only for this to be availabel --}}
            @livewire('dynamic-button',[
                'href' => $href,
                'label' => $label,
                'target' => $target
            ])

        @endguest

    @else
    @endif
