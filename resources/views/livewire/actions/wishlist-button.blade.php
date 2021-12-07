<div>
    <button type="button" class="btn btn-xs p-1 btn-icon btn-danger rounded-circle " wire:click="addToWishlist()"
        title="{{ translate('Add To Wishlist') }}">

        @if($added)
        {{ svg('heroicon-o-heart', ['class'=> 'ev-icon__xs text-white']) }}
        @else
        {{ svg('heroicon-s-heart', ['class'=> 'ev-icon__xs text-black']) }}
        @endif

    </button>
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
</div>
