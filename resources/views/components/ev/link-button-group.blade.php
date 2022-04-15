<div class="{{ $class }}">
    @if(!empty($buttonGroup))
        @foreach($buttonGroup as $index => $button)
            <div class="rounded-md shadow {{ $index > 0 ? 'sm:ml-3':'' }}">
                <a href="{{ $button['href'] }}" 
                    class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary hover:bg-primary md:py-4 md:text-lg md:px-10 {{ $button['class'] }}"
                    target="{{ $button['target'] }}"> 
                    {{ $button?->label?->value ?? $button['label'] }}
                </a>
            </div>
        @endforeach
    @endif
</div>