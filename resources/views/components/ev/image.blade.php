@if (!empty($src))
    
    @if(!empty($href))
        <a href="{{ $href }}" target="{{ $target }}" class="">
    @endif
            <img src="{{ IMG::get($src, IMG::mergeWithDefaultOptions($options, 'original')) }}" alt="{{ $altText }}" class="{{ $class }}" />
    @if(!empty($href))
        </a>
    @endif

@else

@endif
