<!--
  Tailwind CSS v2.0+
  Title: Mini Cart
  Description: Used as a popover when cart icon is clicked in header or similar. https://tailwindui.com/components/ecommerce/components/shopping-carts#component-56a0d26d9a686945295c127e43711f61
  Dependency: @tailwindcss/forms
  Events/Listeners:
  1. @toggle-mini-cart.window - Dispatching the toggle-mini-cart event from any element(trigger) will toggle MINI CART open/close logic!
  *Important: Use this component inside relative wrapper
-->
<div class="absolute top-16 inset-x-0 mt-px pb-6 bg-white shadow-lg sm:px-2 lg:top-full lg:left-auto lg:right-0 lg:mt-3 lg:-mr-1.5 lg:w-80 lg:rounded-lg lg:ring-1 lg:ring-black lg:ring-opacity-5 {{ $class }}"
     x-data="{open:false}"
     x-show="open"
     x-ref="mini_cart"
     @toggle-mini-cart.window="open = !open"
     @click.away="open = false"
     x-transition:enter="ease-out duration-200"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="duration-150 ease-in"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">

    <h2 class="sr-only">Shopping Cart</h2>

    <form class="max-w-2xl mx-auto px-4">
        <ul role="list" class="divide-y divide-gray-200">
            <li class="py-6 flex items-center">
                <img src="https://tailwindui.com/img/ecommerce-images/shopping-cart-page-04-product-01.jpg" alt="Salmon orange fabric pouch with match zipper, gray zipper pull, and adjustable hip belt." class="flex-none w-16 h-16 rounded-md border border-gray-200">
                <div class="ml-4 flex-auto">
                    <h3 class="font-medium text-gray-900">
                        <a href="#">Throwback Hip Bag</a>
                    </h3>
                    <p class="text-gray-500">Salmon</p>
                </div>
            </li>

            <li class="py-6 flex items-center">
                <img src="https://tailwindui.com/img/ecommerce-images/shopping-cart-page-04-product-02.jpg" alt="Front of satchel with blue canvas body, black straps and handle, drawstring top, and front zipper pouch." class="flex-none w-16 h-16 rounded-md border border-gray-200">
                <div class="ml-4 flex-auto">
                    <h3 class="font-medium text-gray-900">
                        <a href="#">Medium Stuff Satchel</a>
                    </h3>
                    <p class="text-gray-500">Blue</p>
                </div>
            </li>

            <!-- More products... -->
        </ul>

        <button type="submit" class="w-full bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-indigo-500">Checkout</button>

        <p class="mt-6 text-center">
            <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">View Shopping Bag</a>
        </p>
    </form>
</div>
