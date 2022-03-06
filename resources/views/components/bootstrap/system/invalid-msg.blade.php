@error($field)
    <div class="error-msg {{ $class }}">
        @if($type === 'bold')
            <div class="invalid-feedback d-block py-2 rounded bg-danger text-white px-3">{{ $message }}</div>
        @elseif($type === 'slim')
            <div class="invalid-feedback d-block text-primary text-12">{{ $message }}</div>
        @endif
    </div>
@enderror
