<div {{ $attributes }}>
    <!-- Walk as if you are kissing the Earth with your feet. - Thich Nhat Hanh -->

    @if ($label)


        @guest
            {!! $label->value !!}
        @else
            {{-- TODO: Implement roles and check for owner only for this to be availabel --}}
            @livewire('dynamic-label', ['label' => $label])

        @endguest

    @else

    @endif







</div>
