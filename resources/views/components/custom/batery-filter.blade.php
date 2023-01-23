<div x-data="{
    value: 'battery1',
    active: 'Hobby',
    updateRange: function($event) {
        if(this.value === 'battery1') {
            this.baseRange = 60;
        }

        if(this.value === 'battery2') {
            this.baseRange = 120;
        }

        if(this.value === 'battery3') {
            this.baseRange = 300;
        }

        this.range = this.baseRange;

        if(this.generator == '20 kW') {
            this.range = this.baseRange + 90;
        }  else if(this.generator == '8 kW') {
            this.range = this.baseRange + 40;
        } else {
            this.range = this.baseRange;
        }
    }
}">
    <span class="font-medium text-lg mb-3 block">
        Battery Pack
    </span>
    <fieldset x-data="{ initialCheckedIndex: 0 }">
        <legend class="sr-only"> Server size </legend>
        <div class="space-y-4">
            <label x-radio-group-option=""
                class="relative block cursor-pointer rounded-full border bg-white px-6 py-3 shadow-sm focus:outline-none sm:flex sm:justify-between border-transparent border-indigo-500 ring-2 ring-indigo-500"
                :class="{ 'border-transparent': (value === 'battery1'), 'border-gray-300': !(value === 'battery1'), 'border-indigo-500 ring-2 ring-indigo-500': (active === 'battery1'), 'undefined': !(active === 'battery1') }">
                <input
                x-on:change="updateRange($event)"
                type="radio" x-model="value" name="server-size" value="battery1" class="sr-only"
                    aria-labelledby="server-size-1-label"
                    aria-describedby="server-size-1-description-0 server-size-1-description-1">
                <span class="flex items-center">
                    <span class="flex flex-col text-sm">
                        <span id="server-size-1-label" class="font-medium text-gray-900">
                            100 kWh
                        </span>
                    </span>
                </span>
                <span id="server-size-1-description-1"
                    class="mt-2 flex text-sm sm:mt-0 sm:ml-4 sm:flex-col sm:text-right">
                    <span class="font-medium text-gray-900"></span>
                </span>
                <span class="pointer-events-none absolute -inset-px rounded-full border border-indigo-500"
                    aria-hidden="true"
                    :class="{ 'border': (active === 'battery1'), 'border-2': !(active === 'battery1'), 'border-indigo-500': (value === 'battery1'), 'border-transparent': !(value === 'battery1') }"></span>
            </label>

            <label x-radio-group-option=""
                class="relative block cursor-pointer rounded-full border bg-white px-6 py-3 shadow-sm focus:outline-none sm:flex sm:justify-between border-gray-300 undefined"
                :class="{ 'border-transparent': (value === 'battery2'), 'border-gray-300': !(value === 'battery2'), 'border-indigo-500 ring-2 ring-indigo-500': (active === 'battery2'), 'undefined': !(active === 'battery2') }">
                <input
                x-on:change="updateRange($event)"

                type="radio" x-model="value" name="server-size" value="battery2" class="sr-only"
                    aria-labelledby="server-size-2-label"
                    aria-describedby="server-size-2-description-0 server-size-2-description-1">
                <span class="flex items-center">
                    <span class="flex flex-col text-sm">
                        <span id="server-size-2-label" class="font-medium text-gray-900">
                            200 kWh
                        </span>
                    </span>
                </span>
                <span id="server-size-2-description-1"
                    class="mt-2 flex text-sm sm:mt-0 sm:ml-4 sm:flex-col sm:text-right">
                    <span class="font-medium text-gray-900">+55 000€</span>
                </span>
                <span class="pointer-events-none absolute -inset-px rounded-full border-2 border-transparent"
                    aria-hidden="true"
                    :class="{ 'border': (active === 'battery2'), 'border-2': !(active === 'battery2'), 'border-indigo-500': (value === 'battery2'), 'border-transparent': !(value === 'battery2') }"></span>
            </label>

            <label x-radio-group-option=""
            disabled
                class="opacity-50 relative block cursor-pointer rounded-full border bg-white px-6 py-3 shadow-sm focus:outline-none sm:flex sm:justify-between border-gray-300 undefined"
                :class="{ 'border-transparent': (value === 'battery3'), 'border-gray-300': !(value === 'battery3'), 'border-indigo-500 ring-2 ring-indigo-500': (active === 'battery3'), 'undefined': !(active === 'battery3') }">
                <input
                disabled
                x-on:change="updateRange($event)"

                type="radio" x-model="value" name="server-size" value="battery3" class="sr-only"
                    aria-labelledby="server-size-2-label"
                    aria-describedby="server-size-2-description-0 server-size-2-description-1">
                <span class="flex items-center">
                    <span class="flex flex-col text-sm">
                        <span id="server-size-2-label" class="font-medium text-gray-900">
                            300 kWh
                        </span>
                    </span>
                </span>
                <span id="server-size-2-description-1"
                    class="mt-2 flex text-sm sm:mt-0 sm:ml-4 sm:flex-col sm:text-right">
                    <span class="font-medium text-gray-900">Coming soon</span>
                </span>
                <span class="pointer-events-none absolute -inset-px rounded-full border-2 border-transparent"
                    aria-hidden="true"
                    :class="{ 'border': (active === 'battery3'), 'border-2': !(active === 'battery3'), 'border-indigo-500': (value === 'battery3'), 'border-transparent': !(value === 'battery3') }"></span>
            </label>

        </div>
    </fieldset>
</div>
