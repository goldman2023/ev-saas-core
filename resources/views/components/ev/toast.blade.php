<!-- Toast -->
<div @if($id) id="{{ $id }}" @endif class="toast {{ $position }} {{ $class }}" role="alert" aria-live="assertive" aria-atomic="true">
    @if($title)
        <div class="toast-header">
            @if($icon)
                @svg($icon, ['class' => 'avatar avatar-sm avatar-circle mr-2'])
            @endif

            <h5 class="mb-0 toast-title {{ $titleClass }}">{{ $title }}</h5>

            @if($close)
                <button type="button" class="close ml-3" data-dismiss="toast" aria-label="Close">
                    <i class="tio-clear" aria-hidden="true"></i>
                </button>
            @endif
        </div>
    @endif
    @if($content)
        <div class="toast-body">
            {{ $content }}
        </div>
    @endif
</div>
<!-- End Toast -->
