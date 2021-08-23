<div x-data="{}"
     @add-to-cart.window="$wire.addToCart($event.detail)"
     @remove-from-cart.window="$wire.removeFromCart($event.detail)">
</div>
