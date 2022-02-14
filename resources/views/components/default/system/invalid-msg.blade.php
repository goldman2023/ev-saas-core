@error($field)
    <div class="error-msg {{ $class }}">
        @if($framework === 'tailwind')
            <div class="block text-red-600 text-12">{{ $message }}</div>
        @else
            @if($type === 'bold')
                <div class="invalid-feedback d-block py-2 rounded bg-danger text-white px-3">{{ $message }}</div>
            @elseif($type === 'slim')
                <div class="invalid-feedback d-block text-primary text-12">{{ $message }}</div>
            @endif
        @endif
    </div>
@enderror
