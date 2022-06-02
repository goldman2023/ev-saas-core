<div x-data="{}"
     wire:key="{{rand()}}"
     @add-to-cart.window="$wire.addToCart($event.detail)"
     @remove-from-cart.window="$wire.removeFromCart($event.detail)">
</div>
