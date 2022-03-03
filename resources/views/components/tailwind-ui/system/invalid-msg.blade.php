@error($field)
    <div class="error-msg {{ $class }}">
        @if($type === 'bold')
            <div class="block text-red-600 text-12">{{ $message }}</div>
        @elseif($type === 'slim')
            <div class="block text-red-600 text-12">{{ $message }}</div>
        @endif
    </div>
@enderror
