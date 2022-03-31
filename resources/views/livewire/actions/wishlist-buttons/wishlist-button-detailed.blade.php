<div>
    <div wire:click="addToWishlist()">
        <button class="w-full mt-4 flex items-center">
            @if($added)
                {{ svg('heroicon-s-heart', ['class'=> 'text-danger w-5 h-5']) }}
                <span class="ml-3 leading-none block mt-1">{{ translate('Remove from wishlist')}}</span>
            @else
                {{ svg('heroicon-o-heart', ['class'=> 'w-5 h-5']) }}
                <span class="ml-3 leading-none block mt-1">{{ translate('Add to wishlist')}}</span>
            @endif

        </button>
    </div>
</div>
