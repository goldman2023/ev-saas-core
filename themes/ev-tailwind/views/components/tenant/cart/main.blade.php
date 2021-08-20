<div x-data="{}"
     x-init="$wire.initCart(localStorage.getItem('user_cart')); $wire.on('addedToCart', ($ids) => { localStorage.setItem('user_cart', $ids); })"
     @add-to-cart.window="$wire.addToCart($event.detail)"
     @remove-from-cart.window="$wire.removeFromCart($event.detail)"
     @refresh-local-cart.window="localStorage.setItem('user_cart', $event.detail)">
</div>
