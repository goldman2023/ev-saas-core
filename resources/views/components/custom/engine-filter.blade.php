<div x-data="{
    value: 'engine2',
    active: 'Hobby',
    updateSpeed: function($event) {
        if(this.value === 'engine2') {
            this.maxSpeed = 42;

        } else {
            this.maxSpeed = 25;
        }
    }
}">
    <span class="font-medium text-lg mb-3 block">
        Engine
    </span>
    <fieldset x-data="{ initialCheckedIndex: 0 }">
        <legend class="sr-only"> Server size </legend>
        <div class="space-y-4">

            <label x-radio-group-option=""
            class="relative block cursor-pointer rounded-full border bg-white px-6 py-3 shadow-sm focus:outline-none sm:flex sm:justify-between border-gray-300 undefined"
            :class="{ 'border-transparent': (value === 'engine2'), 'border-gray-300': !(value === 'engine2'), 'border-indigo-500 ring-2 ring-indigo-500': (active === 'engine2'), 'undefined': !(active === 'engine2') }">
            <input x-on:change="updateSpeed($event)" type="radio" x-model="value" name="server-size" value="engine2"
                class="sr-only" aria-labelledby="server-size-2-label"
                aria-describedby="server-size-2-description-0 server-size-2-description-1">
            <span class="flex items-center">
                <span class="flex flex-col text-sm">
                    <span id="server-size-2-label" class="font-medium text-gray-900">Emarius 34S Dual Motors, 300kW</span>

                </span>
            </span>
            <span id="server-size-2-description-1"
                class="mt-2 flex text-sm sm:mt-0 sm:ml-4 sm:flex-col sm:text-right">
                <span class="font-medium text-gray-900">300 000€</span>
            </span>
            <span class="pointer-events-none absolute -inset-px rounded-full border-2 border-transparent"
                aria-hidden="true"
                :class="{ 'border': (active === 'engine2'), 'border-2': !(active === 'engine2'), 'border-indigo-500': (value === 'engine2'), 'border-transparent': !(value === 'engine2') }"></span>
        </label>


            <label x-radio-group-option=""
                class="relative block cursor-pointer rounded-full border bg-white px-6 py-3 shadow-sm focus:outline-none sm:flex sm:justify-between border-transparent border-indigo-500 ring-2 ring-indigo-500"
                :class="{ 'border-transparent': (value === 'engine1'), 'border-gray-300': !(value === 'engine1'), 'border-indigo-500 ring-2 ring-indigo-500': (active === 'engine1'), 'undefined': !(active === 'engine1') }">
                <input type="radio" x-on:change="updateSpeed($event)" x-model="value" name="server-size" value="engine1"
                    class="sr-only" aria-labelledby="server-size-1-label"
                    aria-describedby="server-size-1-description-0 server-size-1-description-1">
                <span class="flex items-center">
                    <span class="flex flex-col text-sm">
                        <span id="server-size-1-label" class="font-medium text-gray-900">Emarius 34S Single Motor, 150kW</span>
                    </span>
                </span>
                <span id="server-size-1-description-1"
                    class="mt-2 flex text-sm sm:mt-0 sm:ml-4 sm:flex-col sm:text-right">
                    <span class="font-medium text-gray-900">270 000€</span>
                </span>
                <span class="pointer-events-none absolute -inset-px rounded-full border border-indigo-500"
                    aria-hidden="true"
                    :class="{ 'border': (active === 'engine1'), 'border-2': !(active === 'engine1'), 'border-indigo-500': (value === 'engine1'), 'border-transparent': !(value === 'engine1') }"></span>
            </label>



        </div>
    </fieldset>
</div>
