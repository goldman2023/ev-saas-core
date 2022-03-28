<div>
    <div wire:click="addToWishlist()">
        <button>
            @if($added)
            {{ svg('heroicon-s-heart', ['class'=> 'ev-icon__xs text-white mr-2']) }}

            @else
            {{ svg('heroicon-o-heart', ['class'=> 'ev-icon__xs text-black mr-2']) }}

            @endif
        </button>
    </div>
</div>
