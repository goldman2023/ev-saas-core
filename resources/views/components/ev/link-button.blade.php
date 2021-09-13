@if ($label)

    @guest
        <a {{ $attributes }} href="{{ $href->value }}">

            {{ $label->value }}

        </a>

    @else
    <a {{ $attributes }} href="{{ $href->value }}">

        {{ $label->value }}

    </a>    
    
    {{-- TODO: Implement roles and check for owner only for this to be availabel --}}
        @livewire('dynamic-button',[
        'href' => $href,
        'label' => $label,
        'target' => $target
        ])

    @endguest

@else
@endif
