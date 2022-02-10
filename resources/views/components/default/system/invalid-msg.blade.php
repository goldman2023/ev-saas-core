@error($field)
    <div class="error-msg {{ $class }}">
        @if($framework === 'tailwind')
            <div class="block text-red-600 text-12">{{ $message }}</div>
        @else
            <div class="invalid-feedback d-block py-2 rounded bg-danger text-white px-3">{{ $message }}</div>
        @endif
    </div>
@enderror
