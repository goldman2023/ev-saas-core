@error($field)
    <div class="{{ $class }}">
        <div class="invalid-feedback d-block py-2 rounded bg-danger text-white px-3">{{ $message }}</div>
    </div>
@enderror
