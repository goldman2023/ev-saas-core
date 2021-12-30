<!-- Toast -->
<div @if($id) id="{{ $id }}" @endif class="toast {{ $position }} {{ $class }} " role="alert" aria-live="assertive" aria-atomic="true"
    @if($isX)
        x-data="{
            show: false,
            content: '{{ $content }}',
            type: '{{ $type }}'
        }"
        x-init="$watch('show', function(value) { value ? setTimeout(() => show = false, {{ $timeout }}) : ''; })"
        :class="{ 'opacity-10': show, 'bg-success border-success': type === 'success', 'bg-danger border-danger': type === 'danger' }"
        @toast.window="
            if(event.detail.id === '{{ $id }}') {
                content = event.detail.content;
                type = event.detail.type;
                show = true;
            }
        "
    @endif
    {{ $attributes }}
>
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

    <div class="toast-body text-center" @if($isX) x-html="content" @endif>
        {{ $content }}
    </div>
</div>
<!-- End Toast -->
