
@if ($label)
    @guest
        <a {{ $attributes }} href="{{ $href->value ?? $href }}">
            {{ $label->value ?? $label }}
        </a>
    @else
        @if (auth()->user()->isAdmin())
            <span class="position-relative">
                <a {{ $attributes }} href="{{ $href->value ?? $href  }}">

                    {{ $label->value ?? $label }}

                </a>

                {{-- TODO: Implement roles and check for owner only for this to be availabel --}}
                @livewire('dynamic-button',[
                    'href' => $href,
                    'label' => $label,
                    'target' => $target
                ])
            </span>
        @else
            <a {{ $attributes }} href="{{ $href->value ?? $href }}">
                {{ $label->value ?? $label }}
            </a>
        @endif
    @endguest
@else
@endif
