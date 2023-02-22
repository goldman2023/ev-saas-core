<x-system.form-modal id="order-status-change-modal" title="Confirm Selection" :prevent-close="true">

    <div class="btn-primary w-full" wire:click="incrementOrderCycleStatus({{ $order->id }})">

        <span wire:loading.remove wire.target="incrementOrderCycleStatus">
            {{ translate('Next status') }}
        </span>

        <span wire:loading wire.target="incrementOrderCycleStatus">
            {{ translate('Updating order status...') }}
        </span>
    </div>

    <div>
        @if($order->getWEF('cycle_status') > 1)

        <fieldset class="space-y-5">
            <legend class="sr-only">Notifications</legend>
            <div class="relative flex items-start">
                <div class="flex h-5 items-center">
                    <input id="comments" checked disabled aria-describedby="comments-description" name="comments"
                        type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                </div>
                <div class="ml-3 text-sm">
                    <label for="comments" class="font-medium text-gray-700">
                        {{ translate('Generate proposal') }}
                    </label>
                    <span id="comments-description" class="text-gray-500">
                        <span class="sr-only">New comments </span>
                        {{ translate('.pdf Document will be generated') }}
                    </span>
                </div>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-5 items-center">
                    <input id="candidates" aria-describedby="candidates-description" name="candidates" type="checkbox"
                        class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                </div>
                <div class="ml-3 text-sm">
                    <label for="candidates" class="font-medium text-gray-700">
                        {{ translate('Notify customer about order update') }}
                    </label>
                    <span id="candidates-description" class="text-gray-500">
                        <span class="sr-only">New candidates</span>
                        via Email</span>
                </div>
            </div>

        </fieldset>


        @endif
    </div>
</x-system.form-modal>
