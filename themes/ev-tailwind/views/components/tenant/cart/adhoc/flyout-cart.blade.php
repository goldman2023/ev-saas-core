<?php
/**
 * Tailwind CSS v2.0+
 * Title: Flyout Cart
 * Description: https://tailwindui.com/components/ecommerce/components/shopping-carts#component-ee213165d75da7e921c0bf15f3ab054b
 * Dependency: @tailwindcss/forms
 * Events/Listeners:
 * 1. @toggle-cart.window - Dispatching the toggle-cart event from any element(trigger) will toggle flyout cart open/close logic!
 */
?>

<div class="fixed inset-0 overflow-hidden" aria-labelledby="slide-over-title" role="dialog" aria-modal="true"
    x-data="{open:false}"
    x-show="open"
    x-ref="cart"
    @toggle-cart.window="open = !open"
    @added-to-cart.window="open = true">

    <div class="absolute inset-0 overflow-hidden">
        <!--
          Background overlay, show/hide based on slide-over state.
        -->
        <div class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
             x-show="open"
             x-transition:enter="ease-out duration-500"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="duration-500 ease-in"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"></div>

        <div class="fixed inset-y-0 right-0 pl-10 max-w-full flex">
            <!--
              Slide-over panel, show/hide based on slide-over state.
            -->
            <div class="w-screen max-w-md"
                 x-show="open"
                 @click.away="open = false"
                 x-transition:enter="transform ease-in-out duration-500 sm:duration-700"
                 x-transition:enter-start="translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transform ease-in-out duration-500 sm:duration-700"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="translate-x-full">

                <div class="h-full flex flex-col bg-white shadow-xl overflow-y-scroll">
                    <div class="flex-1 py-6 overflow-y-auto px-4 sm:px-6">
                        <div class="flex items-start justify-between">
                            <x-label tag="h2" class="text-lg font-medium text-gray-900" id="slide-over-title" :label="ev_dynamic_translate('Shopping cart', true)"></x-label>
                            <div class="ml-3 h-7 flex items-center">
                                <button type="button" class="-m-2 p-2 text-gray-400 hover:text-gray-500"
                                    @click="open = false">
                                    <span class="sr-only">Close panel</span>
                                    <!-- Heroicon name: outline/x -->
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="mt-8">
                            <div class="flow-root">
                                <ul role="list" class="-my-6 divide-y divide-gray-200">
                                    @if($items->isNotEmpty())
                                        @foreach ($items as $item)
                                            @php
                                                $prices = home_discounted_base_price($item['id'], false, true);
                                            @endphp
                                            <li class="py-6 flex">
                                                <div class="flex-shrink-0 w-24 h-24 border border-gray-200 rounded-md overflow-hidden">
                                                    <img src="{{ $item['images']['thumbnail']['url'] ?? '' }}" alt="{{ $item['name'] }}" class="w-full h-full object-center object-cover">
                                                </div>

                                                <div class="ml-4 flex-1 flex flex-col">
                                                    <div>
                                                        <div class="flex justify-between text-base font-medium text-gray-900">
                                                            <h3>
                                                                <a href="{{ $item['permalink'] }}">
                                                                    {{ $item['name'] }}
                                                                </a>
                                                            </h3>
                                                            <p class="ml-4">
                                                                {{ $item['price']['display'] }}
                                                            </p>
                                                        </div>
                                                        @if(!empty($item['variant']))
                                                            <p class="mt-1 text-sm text-gray-500">
                                                                {{ $item['variant'] }}
                                                            </p>
                                                        @endif
                                                    </div>
                                                    <div class="flex-1 flex items-end justify-between text-sm">
                                                        <p class="text-gray-500">
                                                            Qty {{ $item['quantity'] }}
                                                        </p>

                                                        <div class="flex">
                                                            <button type="button" class="font-medium text-indigo-600 hover:text-indigo-500"
                                                                    @click="$dispatch('remove-from-cart', {{ $item['id'] }})"
                                                            >Remove</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach

                                    @else
                                        <div class="pt-7 pb-5 px-4 text-center font-semibold text-16">
                                            <x-label :label="ev_dynamic_translate('No items in cart.', true)"></x-label>
                                        </div>
                                    @endif

                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 py-6 px-4 sm:px-6">
                        <div class="flex justify-between text-base font-medium text-gray-900">
                            <x-label :label="ev_dynamic_translate('Subtotal', true)">
                            </x-label>
                            <p>{{ $this->subtotal['display'] }}</p>
                        </div>
                        <x-label :label="ev_dynamic_translate('Shipping and taxes calculated at checkout.', true)" class="mt-0.5 text-sm text-gray-500">
                        </x-label>
                        <div class="mt-6">
                            <a href="{{ route('checkout.shipping_info') }}" class="flex justify-center items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                                Checkout
                            </a>
                        </div>
                        <div class="mt-6 flex justify-center text-sm text-center text-gray-500">
                            <p>
                                or <button type="button" class="text-indigo-600 font-medium hover:text-indigo-500" @click="open = false">Continue Shopping<span aria-hidden="true"> &rarr;</span></button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
