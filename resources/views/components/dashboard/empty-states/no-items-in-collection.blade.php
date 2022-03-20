<div class="text-center border-2 border-gray-300 border-dashed rounded-lg p-12">
    @if(!empty($icon))
        @svg($icon, ['class' => 'mx-auto h-12 w-12 text-gray-400'])
    @endif
    @if(!empty($title))
        <h3 class="mt-2 text-sm font-medium text-gray-900">{{ $title }}</h3>
    @endif

    @if(!empty($text))
        <p class="mt-1 text-sm text-gray-500">{{ $text }}</p>
    @endif
    
    @if(!empty($linkHrefRoute) && !empty($linkText))
        <div class="mt-6">
            <a href="{{ route($linkHrefRoute) }}" class="btn-primary">
                @svg('heroicon-o-plus', ['class' => 'h-4 h-4 mr-2'])
                <span>{{ $linkText }}</span>
            </a>
        </div>
    @endif
</div>
  