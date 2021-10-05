<!-- Toast -->
<!-- TODO: Add toast placement functionality to the component -->
<div @if($id) id="{{ $id }}" @endif class="toast {{ $class }}" role="alert" aria-live="assertive" aria-atomic="true" style="position: fixed; top: 20px; right: 30px; z-index: 9999;">
    @if($title)
        <div class="toast-header">
            @if($icon)
                @svg($icon, ['class' => 'avatar avatar-sm avatar-circle mr-2'])
            @endif

            <h5 class="mb-0 toast-title">{{ $title }}</h5>

            @if($close)
                <button type="button" class="close ml-3" data-dismiss="toast" aria-label="Close">
                    <i class="tio-clear" aria-hidden="true"></i>
                </button>
            @endif
        </div>
    @endif
    <div class="toast-body">
        {{ $content }}
    </div>
</div>
<!-- End Toast -->
