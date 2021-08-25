    <a {{ $attributes }} href="{{ $href }}">

        {{ $label->value }}

    </a>



    @if ($label)

        @guest
            {!! $label->value !!}
        @else
            {{-- TODO: Implement roles and check for owner only for this to be availabel --}}
            @livewire('dynamic-button', ['href' => $href, 'label' => $label])
            {{-- TODO: Make nice icon and general styling --}}
            <button wire:click.prevent="editLabel()" class="text-xs">
                {{ translate('Edit') }}
            </button>
        @endguest

    @else
    @endif
