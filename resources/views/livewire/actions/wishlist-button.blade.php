<div wire:click="addToWishlist()">
    <button type="button"
            class="btn btn-xs p-1 btn-icon rounded-circle {{ $added ? 'btn-primary':'btn-dark' }}"
            title="{{ translate('Add To Wishlist') }}"
            wire:loading.class="opacity-6 prevent-pointer-events"
            wire:target="addToWishlist">

        @if($added)
            {{ svg('heroicon-s-heart', ['class'=> 'ev-icon__xs text-white']) }}
        @else
            {{ svg('heroicon-o-heart', ['class'=> 'ev-icon__xs text-black']) }}
        @endif

    </button>
</div>
