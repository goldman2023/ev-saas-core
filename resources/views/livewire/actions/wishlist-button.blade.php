<div class="relative w-0 flex-1 inline-flex items-center justify-center text-sm text-gray-700 font-medium border border-transparent rounded-br-lg hover:text-gray-500">

    <div wire:click="addToWishlist()">

        <button
            class="relative w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-br-lg hover:text-gray-500">
            @if($added)
            {{ svg($action['icon_success'], ['class'=> 'w-5 h-5']) }}
            {{ $action['action_success']  }}

            @else
            {{ svg($action['icon'], ['class'=> 'max-w-[16px] text-gray-900 mr-2']) }}
            {{ $action['action'] }}

            @endif
        </button>
    </div>

</div>
