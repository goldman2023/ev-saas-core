<div class="relative w-0 flex-1 inline-flex items-center justify-center text-sm text-gray-700 font-medium border border-transparent rounded-br-lg hover:text-gray-500">

    <div wire:click="addToWishlist()">

        <button
            class="relative w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-br-lg hover:text-gray-500">
            @if($added)
            {{ svg($iconActive, ['class'=> 'max-w-[16px] text-gray-900 mr-2']) }}
            {{ $available_actions[$action] }}

            @else
            {{ svg($iconDefault, ['class'=> 'max-w-[16px] text-gray-900 mr-2']) }}
            {{ $action }}

            @endif
        </button>
    </div>

</div>
