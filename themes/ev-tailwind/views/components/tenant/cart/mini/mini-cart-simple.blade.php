<?php
/**
 * Tailwind CSS v2.0+
 * Title: Mini Cart Simple
 * Description: Used as a popover when cart icon is clicked in header or similar. https://tailwindui.com/components/ecommerce/components/shopping-carts#component-56a0d26d9a686945295c127e43711f61
 * Dependency: @tailwindcss/forms
 * Events/Listeners:
 * 1. @toggle-mini-cart.window - Dispatching the toggle-mini-cart event from any element(trigger) will toggle MINI CART open/close logic!
 * Important: Use this component inside relative wrapper
 */
?>

<div wire:key="{{rand()}}" class="absolute top-16 inset-x-0 mt-px pb-6 bg-white shadow-lg sm:px-2 lg:top-full lg:left-auto lg:right-0 lg:-mr-1.5 lg:w-80 lg:rounded-lg lg:ring-1 lg:ring-black lg:ring-opacity-5 z-40 {{ $class }}"
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

    <h2 class="sr-only">{{ translate('Shopping Cart') }}</h2>

    <form class="max-w-2xl mx-auto px-4">
        <ul role="list" class="divide-y divide-gray-200">
            @if($items->isNotEmpty())
                @foreach ($items as $item)
                    <li class="py-6 flex items-center">
                        <img src="{{ $item['images']['thumbnail']['url'] ?? '' }}" alt="{{ $item['name'] }}" class="flex-none w-16 h-16 rounded-md border border-gray-200">
                        <div class="ml-4 flex-auto">
                            <h3 class="font-medium text-gray-900">
                                <a href="{{ $item['permalink'] }}">{{ $item['name'] }}</a>
                            </h3>
                            @if(!empty($item['variant']))
                                <p class="text-gray-500"> {{ $item['variant'] }}</p>
                            @endif
                            <div class="flex">
                                <button type="button" class="font-medium text-indigo-600 hover:text-indigo-500"
                                        @click="$dispatch('remove-from-cart', {{ $item['id'] }})"
                                >Remove</button>
                            </div>
                        </div>
                    </li>
                @endforeach
            @else
                <div class="pt-7 pb-5 px-4 text-center font-semibold text-16">
                    <x-ev.label :label="ev_dynamic_translate('No items in cart.', true)">
                    </x-ev.label>
                </div>
            @endif

        </ul>

        <a href="{{ route('checkout.shipping_info') }}" class="block w-full text-center bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-indigo-500">
            {{ translate('Checkout') }}
        </a>

        <p class="mt-6 text-center">
            <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                {{ translate('View Shopping Bag') }}
            </a>
        </p>
    </form>
</div>
