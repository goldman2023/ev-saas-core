@php
    if($type === 'warning') {
        $bg_color = 'bg-yellow-50';
        $title_color = 'text-yellow-800';
        $text_color = 'text-yellow-700';
        $buttons_class = 'bg-yellow-50 hover:bg-yellow-100 text-yellow-800';
    } elseif($type === 'danger') {
        $bg_color = 'bg-red-50';
        $title_color = 'text-red-800';
        $text_color = 'text-red-700';
        $buttons_class = 'bg-red-50 hover:bg-red-100 text-red-800';
    } elseif($type === 'info') {
        $bg_color = 'bg-blue-50';
        $title_color = 'text-blue-800';
        $text_color = 'text-blue-700';
        $buttons_class = 'bg-blue-50 hover:bg-blue-100 text-blue-800';
    } elseif($type === 'success') {
        $bg_color = 'bg-green-50';
        $title_color = 'text-green-800';
        $text_color = 'text-green-700';
        $buttons_class = 'bg-green-50 hover:bg-green-100 text-green-800';
    }
@endphp

<div class="rounded-md {{ $bg_color }} p-4">
    <div class="flex">
      <div class="flex-shrink-0">
            @if($type === 'warning')
                @svg('heroicon-s-exclamation-circle', ['class' => 'w-5 h-5 text-yellow-400'])
            @elseif($type === 'danger')
                @svg('heroicon-o-x-mark-circle', ['class' => 'w-5 h-5 text-red-400'])
            @elseif($type === 'info')
                @svg('heroicon-s-information-circle', ['class' => 'w-5 h-5 text-blue-400'])
            @elseif($type === 'success')
                @svg('heroicon-s-check-circle', ['class' => 'w-5 h-5 text-green-400'])
            @endif
      </div>
      <div class="ml-3">
            @if(!$onlyText)
                <h3 class="text-sm font-medium {{ $title_color }}">{{ $title }}</h3>
            @endif
            
            <div class="@if(!$onlyText) mt-2 @endif text-sm {{ $text_color }}">
                <p>{!! $text !!}</p>
            </div>

            @if(!empty($buttons))
                <div class="mt-4">
                    <div class="-mx-2 -my-1.5 flex">
                        @foreach($buttons as $button)
                            <a href="{{ $button['href'] ?? '#' }}" target="{{ $button['target'] ?? '_parent' }}" class="{{ $buttons_class }} px-2 py-1.5 rounded-md text-sm font-medium">
                                {{ $button['label'] ?? '' }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
      </div>
    </div>
  </div>