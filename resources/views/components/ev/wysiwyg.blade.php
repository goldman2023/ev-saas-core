@if(!empty($content))
    <div class="w-full {{ $class }}" @if(!empty($id)) id="{{ $id }}" @endif>
        {!! $content !!}
    </div>
@endif
