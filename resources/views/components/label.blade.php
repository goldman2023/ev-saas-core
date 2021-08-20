<div {{ $attributes }}>
    <!-- Walk as if you are kissing the Earth with your feet. - Thich Nhat Hanh -->

    @if ($label)
        {!! $label->value !!}

        <livewire:dynamic-label />
    @else

     {{ $slot }}
    @endif


</div>
