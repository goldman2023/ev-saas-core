<div>
    <div wire:click="addToWishlist()">

        <button
            class="btn btn-secondary @if($added) btn-danger @endif align-items-center d-flex justify-content-center align-items-center">
            @if($added)
            {{ svg('heroicon-s-heart', ['class'=> 'ev-icon__xs text-white mr-2']) }}
            {{ $available_actions[$action] }}

            @else
            {{-- {{ svg('heroicon-o-heart', ['class'=> 'ev-icon__xs text-black mr-2']) }} --}}
            {{ $action }}

            @endif
        </button>
    </div>

</div>
