<!-- This example requires Tailwind CSS v2.0+ -->
<div class="bg-gray-50">
    <div class="max-w-2xl mx-auto py-24 px-4 sm:px-6 sm:py-32 lg:max-w-7xl lg:px-8">
        <div class="grid grid-cols-1 gap-y-12 sm:grid-cols-2 sm:gap-x-6 lg:grid-cols-4 lg:gap-x-8">
            <div>
                <img src="https://tailwindui.com/img/ecommerce/icons/icon-delivery-light.svg" alt=""
                    class="h-24 w-auto">
                <h3 class="mt-6 text-sm font-medium text-gray-900">
                    <x-ev.label>
                        {{ translate('Free Shipping') }}
                    </x-ev.label>
                </h3>
                <p class="mt-2 text-sm text-gray-500">
                    <x-ev.label>
                        {{ translate('Benefit Description 1') }}
                    </x-ev.label>
                </p>
            </div>

            <div>
                <img src="https://tailwindui.com/img/ecommerce/icons/icon-chat-light.svg" alt="" class="h-24 w-auto">
                <h3 class="mt-6 text-sm font-medium text-gray-900">
                    <x-ev.label>
                        {{ translate(' 24/7 Customer Support') }}
                    </x-ev.label>
                </h3>
                <p class="mt-2 text-sm text-gray-500">
                    <x-ev.label>
                        {{ translate('Benefit Description 2') }}
                    </x-ev.label>
                </p>
            </div>

            <div>
                <img src="https://tailwindui.com/img/ecommerce/icons/icon-fast-checkout-light.svg" alt=""
                    class="h-24 w-auto">
                <h3 class="mt-6 text-sm font-medium text-gray-900">

                    {{ translate(' Fast Shopping Cart') }}
                </h3>
                <p class="mt-2 text-sm text-gray-500">
                    <x-ev.label>
                        {{ translate('Benefit Description 3') }}
                    </x-ev.label>
                </p>
            </div>

            <div>
                <img src="https://tailwindui.com/img/ecommerce/icons/icon-gift-card-light.svg" alt=""
                    class="h-24 w-auto">
                <h3 class="mt-6 text-sm font-medium text-gray-900">
                    <x-ev.label>
                        {{ translate('Gift Cards') }}
                    </x-ev.label>
                </h3>
                <p class="mt-2 text-sm text-gray-500">
                    <x-ev.label>
                        {{ translate('Benefit Description 4') }}
                    </x-ev.label>
                </p>
            </div>
        </div>
    </div>
</div>
