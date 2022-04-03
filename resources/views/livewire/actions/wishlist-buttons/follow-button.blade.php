<div wire:click="addToWishlist()">
    @if($added)

    <button type="button"
    class="inline-flex items-center px-3 py-0.5 rounded-full bg-indigo-50 text-sm font-medium text-indigo-700 hover:bg-indigo-100">
    {{ svg($action['icon_success'], ['class'=> 'h-5 w-5 text-indigo-400 max-w-[16px] mr-2']) }}

    <span>
        {{ $action['action_success'] }}
    </span>
</button>
    @else
    <button type="button"
        class="inline-flex items-center px-3 py-0.5 rounded-full bg-indigo-600 text-sm font-medium text-white hover:bg-indigo-300">
        {{ svg($action['icon'], ['class'=> 'max-w-[16px] text-indigo-100 mr-3 -ml-1 mr-0.5 h-5 w-5']) }}
        <span>
            {{ $action['action'] }}
        </span>
    </button>
    @endif

</div>
