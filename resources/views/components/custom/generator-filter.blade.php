<div x-data="{
    value: 'generator3',
    active: 'Hobby',
    updateGenerator: function($event) {
        if(this.value === 'generator1') {
            this.generator = '8 kW';
            this.range = this.baseRange + 40;
        }
        if(this.value === 'generator2') {
            this.generator = '20 kW';
            this.range = this.baseRange + 90;
        }

        if(this.value === 'generator3') {
            this.generator = 'No';
            this.range = this.baseRange;
        }

        this.calculatePrice();
    }
}">
    <span class="font-medium text-lg mb-3 block">
        Generator
    </span>
    <fieldset x-data="{ initialCheckedIndex: 0 }">
        <legend class="sr-only"> Server size </legend>
        <div class="space-y-4">
            <label x-radio-group-option=""

                class="relative block cursor-pointer rounded-full border bg-white px-6 py-3 shadow-sm focus:outline-none flex justify-between border-transparent border-indigo-500 ring-2 ring-indigo-500"
                :class="{ 'border-transparent': (value === 'generator3'), 'border-gray-300': !(value === 'generator3'), 'border-indigo-500 ring-2 ring-indigo-500': (active === 'generator3'), 'undefined': !(active === 'generator3') }">
                <input
                x-on:change="updateGenerator($event)"
                type="radio" x-model="value" name="server-size" value="generator3" class="sr-only"
                    aria-labelledby="server-size-1-label"
                    aria-describedby="server-size-1-description-0 server-size-1-description-1">
                <span class="flex items-center">
                    <span class="flex flex-col text-sm">
                        <span id="server-size-1-label" class="font-medium text-gray-900">
                            No generator
                        </span>
                    </span>
                </span>
                <span id="server-size-1-description-1"
                    class="mt-2 flex text-sm sm:mt-0 sm:ml-4 sm:flex-col sm:text-right">
                    <span class="font-medium text-gray-900"></span>
                </span>
                <span class="pointer-events-none absolute -inset-px rounded-full border border-indigo-500"
                    aria-hidden="true"
                    :class="{ 'border': (active === 'generator3'), 'border-2': !(active === 'generator3'), 'border-indigo-500': (value === 'generator3'), 'border-transparent': !(value === 'generator3') }"></span>
            </label>

            <label x-radio-group-option=""
                class="relative block cursor-pointer rounded-full border bg-white px-6 py-3 shadow-sm focus:outline-none flex justify-between border-transparent border-indigo-500 ring-2 ring-indigo-500"
                :class="{ 'border-transparent': (value === 'generator1'), 'border-gray-300': !(value === 'generator1'), 'border-indigo-500 ring-2 ring-indigo-500': (active === 'generator1'), 'undefined': !(active === 'generator1') }">
                <input
                x-on:change="updateGenerator($event)"

                type="radio" x-model="value" name="server-size" value="generator1" class="sr-only"
                    aria-labelledby="server-size-1-label"
                    aria-describedby="server-size-1-description-0 server-size-1-description-1">
                <span class="flex items-center">
                    <span class="flex flex-col text-sm">
                        <span id="server-size-1-label" class="font-medium text-gray-900">
                            Generator 8 kW
                        </span>
                        <span class="text-gray-500">
                            7 Knots / 8 Hours
                        </span>
                    </span>
                </span>
                <span id="server-size-1-description-1"
                    class="mt-2 flex text-sm sm:mt-0 sm:ml-4 sm:flex-col sm:text-right">
                    <span class="font-medium text-gray-900"></span>
                </span>
                <span class="pointer-events-none absolute -inset-px rounded-full border border-indigo-500"
                    aria-hidden="true"
                    :class="{ 'border': (active === 'generator1'), 'border-2': !(active === 'generator1'), 'border-indigo-500': (value === 'generator1'), 'border-transparent': !(value === 'generator1') }"></span>
            </label>

            <label x-radio-group-option=""
                class="relative block cursor-pointer rounded-full border bg-white px-6 py-3 shadow-sm focus:outline-none flex justify-between border-gray-300 undefined"
                :class="{ 'border-transparent': (value === 'generator2'), 'border-gray-300': !(value === 'generator2'), 'border-indigo-500 ring-2 ring-indigo-500': (active === 'generator2'), 'undefined': !(active === 'generator2') }">
                <input
                x-on:change="updateGenerator($event)"

                type="radio" x-model="value" name="server-size" value="generator2" class="sr-only"
                    aria-labelledby="server-size-2-label"
                    aria-describedby="server-size-2-description-0 server-size-2-description-1">
                <span class="flex items-center">
                    <span class="flex flex-col text-sm">
                        <span id="server-size-2-label" class="font-medium text-gray-900">
                            Generator 20 kW
                        </span>
                        <span class="text-gray-500">
                            15 Knots / 6 Hours
                        </span>

                    </span>
                </span>
                <span id="server-size-2-description-1"
                    class="mt-2 flex text-sm sm:mt-0 sm:ml-4 sm:flex-col sm:text-right">
                    <span class="font-medium text-gray-900"></span>
                </span>
                <span class="pointer-events-none absolute -inset-px rounded-full border-2 border-transparent"
                    aria-hidden="true"
                    :class="{ 'border': (active === 'generator2'), 'border-2': !(active === 'generator2'), 'border-indigo-500': (value === 'generator2'), 'border-transparent': !(value === 'generator2') }"></span>
            </label>

        </div>
    </fieldset>
</div>
