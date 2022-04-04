{{-- <!-- Toast -->
<div @if($id) id="{{ $id }}" @endif class="toast {{ $position }} {{ $class }} " role="alert"
    @if($isX)
        
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
                    @svg('heroicon-o-x', ['class' => 'w-[18px] h-[18px]'])
                </button>
            @endif
        </div>
    @endif

    <div class="toast-body text-center" @if($isX) x-html="content" @endif>
        {{ $content }}
    </div>
</div>
<!-- End Toast --> --}}


<div class="fixed rounded-md  p-4  top-24 left-1/2 translate-x-[-50%] {{ $position }} {{ $class }}" 
        x-data="{
            show: false,
            content: '{{ $content }}',
            type: '{{ $type }}'
        }"
        x-show="show"
        x-init="$watch('show', function(value) { value ? setTimeout(() => show = false, {{ $timeout }}) : ''; })"
        :class="{ 'opacity-100': show, 'bg-green-100': type === 'success', 'bg-red-100': type === 'danger' }"
        @toastit.window="
            if(event.detail.id === '{{ $id }}') {
                content = event.detail.content;
                type = event.detail.type;
                show = true;
            }
        "
>
    <div class="flex">
      <div class="flex-shrink-0">
        <template x-if="type === 'success'">
            @svg('heroicon-s-check-circle', ['class' => 'h-5 w-5 text-green-400', ":class=\"{'text-green-400': type === 'success', 'text-red-400': type === 'danger' }\""])
        </template>
      </div>
      <div class="ml-3">
        <h3 class="text-sm font-medium text-green-800" 
                :class="{'text-green-800': type === 'success', 'text-red-800': type === 'danger' }" 
                x-text="content"></h3>
        {{-- <div class="mt-2 text-sm text-green-700">
          <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquid pariatur, ipsum similique veniam.</p>
        </div>
        <div class="mt-4">
          <div class="-mx-2 -my-1.5 flex">
            <button type="button" class="bg-green-50 px-2 py-1.5 rounded-md text-sm font-medium text-green-800 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-green-50 focus:ring-green-600">View status</button>
            <button type="button" class="ml-3 bg-green-50 px-2 py-1.5 rounded-md text-sm font-medium text-green-800 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-green-50 focus:ring-green-600">Dismiss</button>
          </div>
        </div> --}}
      </div>
    </div>
  </div>
  