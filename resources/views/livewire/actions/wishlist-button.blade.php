<div>

    <div wire:click="addToWishlist()">

        <button
            class="btn btn-secondary @if($added) btn-danger @endif align-items-center d-flex justify-content-center align-items-center">
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
