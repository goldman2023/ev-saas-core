
@if ($label)

    @guest
        <a {{ $attributes }} href="{{ $href->value }}">

            {{ $label->value }}

        </a>

    @else
    <span class="position-relative">
    <a {{ $attributes }} href="{{ $href->value }}">

        {{ $label->value }}

    </a>

    {{-- TODO: Implement roles and check for owner only for this to be availabel --}}
        @livewire('dynamic-button',[
        'href' => $href,
        'label' => $label,
        'target' => $target
        ])
    </span>
    @endguest

@else
@endif
