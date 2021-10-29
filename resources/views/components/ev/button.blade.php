<button type="{{ $type }}" class="{{ $class }}"
        @if(!empty($onclick))
            onclick="{!! $onclick !!}"
        @endif
        {!! $attributes !!}
>
        {!! $slot !!}
</button>
